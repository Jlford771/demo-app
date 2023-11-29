<!-- TODO
STANDARD SELECT
1. Select component that accepts an array of objects or a standard array
2. Generates however many options based on the array
3. Label and value can be specified via props. IE, :label = "name" and :value = "id" from the list of objects or populates name/value based on just the array indexes
4. Tab index - focus and blur like normal elements- but if user hits enter need to open up the select (if focused + keyenter) (or @clicked for non tab users)


RICH SELECT
1. Select component that accepts an array of objects or a standard array
2. Generates however many options based on the array
3. Label and value can be specified via props. IE, :label = "name" and :value = "id" from the list of objects
3. Has scroll for overflowed options
4. Has search to filter options
 -->
<template>
  <div class="relative w-full text-left outline-none h-10 leading-10" ref="select-wrapper">
    <div 
        ref="select"
        class="bg-white rounded-tl-md rounded-tr-md border-2 text-black cursor-pointer select-none px-2 border-gray-500 focus:border-blue-500 outline-none" 
        :class="open ? 'border-blue-500 rounded-b-none': 'rounded-b-md'" 
        @click="handleClick"
        :tabindex="tabindex" @blur="" @focus="focused = true" @keyup.enter="onEnter"
        >
        {{ selected }}
    </div>
    <div 
        ref="options-wrapper"
        class="text-black overflow-hidden border-r-2 border-l-2 border-b-2 border-blue-400 absolute bg-white left-0 right-0 z-1 rounded-bl-md rounded-br-md" 
        :class="{ 'hidden' : !open }">
      <div
        ref="options"
        class="text-black pl-1 cursor-pointer select-none outline-none hover:bg-blue-300 focus:bg-blue-300"
        v-for="(option, i) of options"
        :tabindex="0"
        :key="i"
        @keyup.enter="selectOption(option)"
        @click="selectOption(option)"
        @blur="checkPosition(i)"
        @keyup.tab="navigator"
      >
        {{ option }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    options: {
      type: Array,
      required: true,
    },
    default: {
      type: String,
      required: false,
      default: null,
    },
    tabindex: {
      type: Number,
      required: false,
      default: 0,
    },
  },
  data() {
    return {
      selected: this.default
        ? this.default
        : this.options.length > 0
        ? this.options[0]
        : null,
      open: false,
      focused: false,
      tabNavigation: false
    };
  },
  mounted() {
    // this.$emit("input", this.selected);
    // this.setDefault();
  },
  created(){
    // Detect if user clicks outside of element, if so- close it
    window.addEventListener('click', (e) => {
        if (!this.$el.contains(e.target)){
          this.open = false
        }
      })
  },
  methods:{
    onEnter(){
        // check if 
        if(this.focused){
            this.open = true
        }
    },

    handleClick(){
        this.open = !this.open
    },

    focusSelected(index){
        //if user supplies default with array
        //if user supplies default with objects
        //default behavior sets first index
        if(!this.default){
            
        }
        //default behavior sets first object

    },

    selectOption(option){
        this.selected = option;
        this.open = false;
        this.$emit('input', option);
    },
    //Checks position of current element tab - if it is the last value, closes options and sets focus back to input after re-mounting dom - same as a regular select
    checkPosition(i){
        if(i === this.options.length - 1){
            this.open = false;
            if(this.tabNavigation){
                this.$nextTick(() =>  this.$refs.select.focus());
                this.tabNavigation = false;
            }
        }
    },
    //Keeps track of if user is using tab to navigate options
    navigator(){
        this.tabNavigation = true;
    }
  },
  watch:{
    open(){
        if(this.open){
            this.focusSelected()
        }
    }
  }
};
</script>

<style scoped>
</style>