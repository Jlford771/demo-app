<template>
    <div class="relative">
       <BellIcon class="text-white cursor-pointer p-1"/> 
       <div v-if="list.length > 0" class="bg-red-500 h-4 w-4 rounded-full absolute top-0 right-0 flex items-center justify-center text-white text-sm">
            <span>{{list.length}}</span>
       </div>
    </div>
</template>

<script>
import BellIcon from '../../../assets/icons/BellIcon.vue'
    export default{
        components:{
            BellIcon
        },
        props:{

        },
        setup(){
            return{
                list: []
            }
        },
        computed:{
            
        }
    }
</script>