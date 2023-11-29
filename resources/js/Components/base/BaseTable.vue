<!-- USAGE

Create and pass Headers (:headers) prop to component with format matching items to be rendered:

    - text is the column header lable, value is the key the column will match to in the items list of objects passed in. Actions is an extra column to do custom logic in like update/deletes (not required)
        
       customerHeaders = [
            { text: 'Name', value: 'name' },
            { text: 'Time', value: 'time' },
            { text: 'Message', value: 'message' },
            { text: 'Actions', value: 'actions', className: 'w-1'}
        ]

Pass Values (:items prop) as a list of objects (generally already formatted this way in backend)

    customers = [
        {name: 'John Splinsk', time: '6:01 AM', message: 'This is a message'},
        {name: 'Samantha Warren', time: '5:01 PM', message: 'This is a message'},
    ]

Code usage ex:
    <BaseTable :headers="customerHeaders" :items="customers" :loading="apiLoadingData" :perPage="5" bordered></BaseTable>

    - loading is not required, perPage is not required and has a default of 10 if not set manually, bordered is just for style.
-->
<template>
    <div class="flex flex-col rounded-md" :class="wrapperStyle">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="flex flex-col max-w-screen md:py-2 md:align-middle md:inline-block md:min-w-full sm:px-6 lg:px-8">
                <div class="overflow-x-auto border-b border-gray-200 rounded-lg" :class="{ 'shadow': shadow }">
                    <!-- Search input -->
                    <div v-if="enableSearch" class="flex justify-end">
                        <div>
                            <input 
                                type="text"
                                class="block w-40 px-10 py-1 transition duration-100 ease-in-out rounded-tr-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 placeholder:text-sm placeholder:italic"
                                :class="bordered ? 'border-l' : 'border-2'"
                                placeholder="Search.."
                                @input="$emit('search', search);"
                                v-model="search"/>
                        </div>
                    </div>
                    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                            <tr>
                                <th v-for="header in headers" :class="header.className" scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <slot :name="`header_${header.value}`" v-bind="{ header }">
                                        {{ header.text }}
                                    </slot>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-show="!loading" v-for="(item, index) in paginatedList"
                                :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'" class="">
                                <td v-for="header in headers" class="px-6 py-4 text-sm font-medium text-gray-600">
                                    <slot  :name="`row_${header.value}`" v-bind="{ item, index }">
                                        {{ renderValue(item, header.value) }}
                                    </slot>
                                </td>
                            </tr>
                            <tr v-if="loading || filteredItems.length < 1">
                                <td class="bg-white px-3 py-2 text-center" colspan="100%">
                                    <loader v-show="loading" class="text-gray-400 w-12 mx-auto" />
                                    <span v-if="!loading" class="">
                                        N/A
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                        <!-- Pagination -->
                        <tfoot v-if="Math.ceil(filteredItems.length/perPage) > 1">
                            <tr class="bg-white">
                                <td class="py-2 px-3" colspan="100%">
                                    <div class="flex items-center justify-between space-x-8">
                                        <div>{{ `${from} - ${to} of ${filteredItems.length}` }}</div>
                                        <BasePagination :total="filteredItems.length" :perPage="perPage" @change="handlePaginate" :page="paginatePage"></BasePagination>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import loader from './BaseLoader.vue'

export default {
    components:{
        loader,
    },
    props: {
        headers: {
            type: Array,
            default: () => []
        },
        items: {
            type: Array,
            default: () => []
        },
        loading: Boolean,
        shadow: {
            type: Boolean,
            default: false,
        },
        perPage: {
            type: Number,
            required: false,
            default: 10
        },
        enableSearch:{
            type: Boolean,
            required: false,
            default: false
        },
        bordered:{
            type: Boolean,
            required: false,
            default: false
        }
    },
    data(){
        return{
            currentPage: 1,
            paginatePage: 1,
            search: ''
        }
    },
    methods: {
        renderValue(item, field) {
            let value = '';

            field.split('.').forEach((property, key) => {
                value = key === 0 ? item[property] : value ? value[property] : '';
            })

            return value || '0';
        },
        handlePaginate(pageNumber){
            this.currentPage = pageNumber
        }
    },
    //if array of objects passed to table changes - currentPage is set back to 1 to reset pagination
    //paginatePage is only changed to force pagination component to rerender as it's changing a pagination prop
    watch:{
        items(){
            this.currentPage = 1;
            this.paginatePage = Math.random() * 100000;
            this.search = '';
        }
    },
    //paginates based on perPage and currentPage values
    computed:{
        paginatedList(){
            return this.filteredItems.slice(this.perPage * this.currentPage - this.perPage, this.perPage * this.currentPage);
        },

        from(){
            if(this.currentPage === 1){
                return 1
            }
            else{
                return this.perPage * (this.currentPage -1) + 1
            }
        },

        to(){
            if(this.perPage > this.filteredItems.length){
                return this.filteredItems.length
            }
            else if(this.currentPage === 1){
                return this.perPage
            }
            else if(this.currentPage != Math.ceil(this.filteredItems.length/this.perPage)){
                return (this.perPage * (this.currentPage))
            }
            else{
                return this.filteredItems.length
            }
        },

        //Computed filtered list of items based on current search value
        filteredItems(){
            return this.items.filter((item) =>{
                let values = Object.values(item);
                let found = false;

                values.every((value) => {
                    //convert value to string so it can be compared regardless of type
                    value = String(value);
                
                    if(value.toLowerCase().includes(this.search.toLowerCase())){
                        found = true;
                        return false;
                    }
                    return true;
                })

                return found;
            });
        },

        wrapperStyle(){
            if(this.bordered){
                return 'border-2'
            }
        }
    }
}
</script>


<style scoped>
    input {
        background: white url("../base/assets/search-icon.svg") no-repeat 15px center;
        background-size: 15px 15px;
    }
</style>