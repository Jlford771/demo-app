<template>
    <div>
        <div :class="bannerStyle" role="alert">
            <div class="flex">
                <div class="py-1" v-if="type == 'success'"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div class="py-1" v-if="type == 'error'"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div class="py-1" v-if="type == 'warning'"><svg class="fill-current h-6 w-6 text-yellow-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div class="py-1" v-if="type == ''"><svg class="fill-current h-6 w-6 text-gray-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <div class="flex">
                        <p class="font-bold">{{title}}</p>
                        <Loader v-if="loading" class="pl-4 w-16"/>
                    </div>
                    <p class="text-sm">{{body}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- type specifies "error" which will display red, "warning" which will display yellow, and "success" which will display green - all with appropriate icons -->
<script>
import Loader from './BaseLoader.vue'
    export default{
        components:{
            Loader
        },
        props:{
            title: String,
            body: String,
            //Types: success, warning, error
            type: String,
            loading: Boolean,
        },
        setup(){
            return{

            }
        },
        computed:{
            bannerStyle(){
                if(this.type === "error"){
                    return "bg-red-100 border-t-4 border-red-500 rounded-b text-teal-900 px-4 py-3 shadow-md";
                }
                if(this.type === "warning"){
                    return "bg-yellow-100 border-t-4 border-yellow-500 rounded-b text-teal-900 px-4 py-3 shadow-md";
                }
                if(this.type === "success"){
                    return "bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md";
                }
                else{
                    return "bg-gray-100 border-t-4 border-gray-500 rounded-b text-teal-900 px-4 py-3 shadow-md";
                }
            }
        }
    }
</script>