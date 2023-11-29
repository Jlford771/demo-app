<template>
    <button 
        class="block px-4 py-1 transition duration-100 ease-in-out focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed"
        :class="typeClasses"
        :disabled="disabled"
        @focus="$emit('focus')"
        @blur="$emit('blur')"
        >
        <div class="flex items-center justify-center space-x-4">
            <slot></slot>
            <BaseButtonLoader v-show="loading" class="ml-2"></BaseButtonLoader>
        </div>
    </button>
</template>

<script>
import BaseButtonLoader from './BaseButtonLoader.vue'
    export default{
        components:{
            BaseButtonLoader
        },
        props:{
            // Types: primary, secondary, error, success
            type:{
                type: String,
                required: false,
                default: 'primary'
            },
            disabled:{
                type:Boolean,
                required: false,
                default: false,
            },
            loading:{
                type: Boolean,
                required: false,
                default: false
            }
        },
        setup(){
            return{
            }
        },
        computed:{
            typeClasses(){
                if(this.type === 'primary'){
                    return 'text-white bg-blue-500 border border-2 border-blue-600 rounded shadow-md hover:bg-blue-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 disabled:bg-blue-500'
                }
                else if(this.type === 'secondary'){
                    return 'text-black bg-gray-300 border rounded border-2 border-gray-400 shadow-md hover:bg-gray-400 focus:border-gray-400 focus:ring-2 focus:ring-gray-400 disabled:bg-gray-300' 
                }
                else if(this.type === 'error'){
                    return 'text-white bg-red-500 border border-2 border-red-600 rounded shadow-md hover:bg-red-600 focus:border-red-500 focus:ring-2 focus:ring-red-500 disabled:bg-red-500'
                }
                else if(this.type === 'success'){
                    return 'text-white bg-green-500 border border-2 border-green-600 rounded shadow-md hover:bg-green-600 focus:border-green-500 focus:ring-2 focus:ring-green-500 disabled:bg-green-500'
                }
            }
        }
    }
</script>