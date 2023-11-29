<!-- TODO
4. Add footer slot ? - or perhaps there should be a seperate confirm modal component
5. Add a loading state? 
 -->
<template>
    <div v-show="visible" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" @click="closeModal">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-full p-4 text-center sm:p-0">

            <div id="modal-container" class=" bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-7xl" @click.stop :style="style">
                <div class="absolute right-0 cursor-pointer text-3xl pr-3 text-red-500 font-bold" @click="closeModal">x</div>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2" id="modal-title">{{title}}</h3>
                            <hr>
                            <div id="modal-content" class="mt-2">
                                <!-- Slot will render any html written within the BaseModal tags when used (including other components) -->
                                <slot></slot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        props:{
            visible: Boolean,
            title: {
                type: String,
                default: ''
            },
            size: {
                type: String,
                default: ''
            }
        },
        setup(){
            return{
                showModal: false,
                // Might need to turn these all into objects with both height and width if infinite height is a big problem
                sizes: {
                    xs: '312px', sm: '384px', md: '448px', lg: '512px', xl: '576px', x2: '672px', x3: '768px', x4: '896px', x5: '1024px', x6: '1152px', x7: '1280px'
                }
            }
        },
        methods:{
            closeModal(){
                this.$emit('close')
            }
        },
        computed:{
            style(){
                let style = '';
                if(this.size){
                    style += ('width: ' + this.sizes[this.size] + '; ');
                }
                return style;
            }
        }
    }
</script>