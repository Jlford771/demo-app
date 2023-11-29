<template>  
    <div>
        <CheckIcon v-if="status === 'success'" class=" text-green-500" :class="class"/>
        <WarningIcon v-if="status === 'warning'" class=" text-yellow-400" :class="class"/>
        <CrossIcon v-if="status === 'error'" class=" text-red-500" :class="class"/>
        <CrossIcon v-if="status === ''" class=" text-gray-500" :class="class"/>
    </div>
</template>

<script>
import CheckIcon from '../../assets/icons/CheckIcon.vue'
import WarningIcon from '../../assets/icons/WarningIcon.vue'
import CrossIcon from '../../assets/icons/CrossIcon.vue'
    export default{
        components:{
            CheckIcon,
            WarningIcon,
            CrossIcon
        },
        props:{
            status: String,
            class: String
        },
    }
</script>