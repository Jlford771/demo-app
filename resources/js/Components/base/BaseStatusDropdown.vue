<template>
    <div class="shadow-lg rounded-lg border-2 p-8 bg-white">
        <div class="flex justify-between items-center">
            <div class="text-lg font-bold">{{title}}</div>
            <div v-if="loading"><BaseLoader class="text-gray-400 w-12"/></div>
            <StatusIcon v-if="!loading && status && !notAvailable" class="cursor-pointer" @click="showContent = !showContent" :status="status"></StatusIcon>
            <div v-if="!loading && notAvailable">N/A</div>
        </div>
        <div v-show="showContent">
            <hr class="mb-2 mt-4" />
            <slot></slot>
        </div>
    </div>
</template>


<script>
import StatusIcon from '../StatusIcon.vue';

export default{
    components:{
        StatusIcon
    },
    props:{
        status: String,
        title: String,
        loading: Boolean,
        notAvailable: {
            type: Boolean,
            default: false
        }
    },
    data(){
        return{
            showContent: false,
        }
    },
    watch:{
        status(){
            if(this.status === 'error'){
                this.showContent = true;
            }
        }
    }
}
</script>