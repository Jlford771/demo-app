<!-- TODO
 Add prop to disallow any user from inputting anything other than letters, letters/numbers, numbers, or pass a single character or list of characters to filter out with regex
-->
<template>
    <div>
        <label v-if="label">{{ label }}</label>
        <input 
            class="mt-1 block w-full px-3 py-2 transition duration-100 ease-in-out border rounded shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed"
            :class="computedStyle"
            :placeholder="label"
            :value="modelValue"
            @input="updateValue"
            v-bind="$attrs"
        />
        <span class="text-sm text-red-500 mt-2">{{errorMessage}}</span>
    </div>
</template>

<script>

export default{
    props:{
        // variants: success, error
        variant: String,
        modelValue: [String, Number],
        label: String,
        errorMessage: String
    },
    data(){
        return{
        }
    },
    methods:{
        updateValue(){
            this.$emit('update:modelValue', event.target.value);
        }
    },
    computed:{
        computedStyle(){
            if(this.variant == "success"){
                return 'border-green-300 bg-green-50 placeholder-gray-400 text-green-900';
            }
            else if(this.variant == "error"){
                return 'border-red-300 bg-red-50 placeholder-red-200 text-red-900';
            }
            else{
                return 'text-black placeholder-gray-400 bg-white border-gray-300 focus:border-blue-500';
            }
        }
    }
}

</script>