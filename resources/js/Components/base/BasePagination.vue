<template>
    <ul id="pagination-wrapper" class="table border-collapse text-center bg-white shadow-sm">
        <!-- always preset left end (functionality will go to page 1) - disabled when no more pages to move to -->
        <li class="w-8 h-8 border border-gray-200 table-cell">
            <button class="hover:bg-blue-100 w-full h-full transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-gray-50" 
                @click="currentPage = 1; $emit('change', currentPage)" 
                :disabled="currentPage <= 1"
                >
                    «
            </button>
        </li>
        <!-- left end to go back 1 page - disabled when no more pages to move to -->
        <li class="w-8 h-8 border border-gray-200 table-cell">
            <button 
                class="hover:bg-blue-100 w-full h-full transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-gray-50" 
                @click="currentPage = currentPage - 1; $emit('change', currentPage)"
                :disabled="currentPage <= 1"
                >
                    ‹
            </button>
        </li>
        <!-- v-for to display up to 4 numbered pages depending on position (4 if end or start is in within 4, or 3 if middle of pages) -->
        <li class="w-8 h-8 border border-gray-200 table-cell" v-for="(pageNumber, index) in currentNavigableList">
            <button 
                class=" w-full h-full transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50"
                :class="selectedPage(pageNumber)"
                @click="currentPage = pageNumber; $emit('change', currentPage)"
            >
                {{pageNumber}}
            </button>
        </li>
        <!-- right end to go next 1 page - disabled when no more pages to move to -->
        <li class="w-8 h-8 border border-gray-200 table-cell">
            <button class="hover:bg-blue-100 w-full h-full transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-gray-50" 
            @click="currentPage = currentPage + 1; $emit('change', currentPage)"
            :disabled="currentPage === totalPages"
            >
                ›
            </button>
        </li>
        <!-- always preset right end (functionality will go to last page based on total/perpage) - disabled when no more pages to move to -->
        <li class="w-8 h-8 border border-gray-200 table-cell">
            <button class="hover:bg-blue-100 w-full h-full transition duration-100 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:cursor-not-allowed disabled:opacity-50 disabled:bg-gray-50" 
                @click="currentPage = totalPages; $emit('change', currentPage)" 
                :disabled="currentPage === totalPages"
                >
                    »
            </button>
        </li>
    </ul>
</template>

<script>
    export default{
        props:{
            total:{
                type: Number,
                required: false,
                default: 0,
            },
            perPage:{
                type: Number,
                required: false,
                default: 10,
            },
            page:{
                type: Number,
                required: false,
            }
        },
        data(){
            return{
                totalPages: Math.ceil(this.total/this.perPage),
                currentPage: this.total > 0 ? 1 : 0,
            }
        },
        methods:{
            selectedPage(pageNumber){
                if(this.currentPage === pageNumber){
                    return 'bg-blue-500 text-white hover:bg-blue-600'
                }
                else{
                    return 'hover:bg-blue-100'
                }
            },
        },
        watch:{
            total(){
                this.totalPages = Math.ceil(this.total/this.perPage);
            },
            page(){
                this.currentPage = 1;
                this.selectedPage(1);
            }
        },
        computed:{
            // Optimize this algorithm later, some of these conditions can be modified
            currentNavigableList(){
                if (this.totalPages === 1) {
                    return [1];
                }

                const start = 1;
                const paginationList = [];

                if (this.currentPage > start + 1 && this.currentPage < this.totalPages - 1) {
                    return [this.currentPage - 1,this.currentPage, this.currentPage + 1,];
                } 
                else if ((this.currentPage <= 2) && this.totalPages > 3) {
                    return [1, 2, 3];
                } 
                else if (this.totalPages <= 3) {
                    for (let i = 1; i <= this.totalPages; i++) {
                        paginationList.push(i);
                    }
                    return paginationList;
                } 
                else if (this.currentPage >= this.totalPages - 1) {
                    return [this.totalPages - 2, this.totalPages - 1, this.totalPages];
                }

                if (this.totalPages > 1) {
                    paginationList.push(this.totalPages);
                }

                return paginationList;
            }
        }
    }
</script>