<script setup>
import {ref} from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

  //INPUTS

  const input1 = ref("");

  function test(){
    console.log('working');
  }

  const loading = ref(false)

//TABLE COMPONENTS
const headers = ref([
            { text: 'Name', value: 'name' },
            { text: 'Time', value: 'time' },
            { text: 'Message', value: 'message' },
        ]
      );

const data = ref([
    {name: 'John Splinsk', time: '6:01 AM', message: 'This is a message'},
    {name: 'Samantha Warren', time: '5:01 PM', message: 'This is a message'},
    {name: 'Diane Smith', time: '8:31 AM', message: 'This is a message'},
    {name: 'Roger Wickens', time: '2:31 PM', message: 'This is a message'},
    {name: 'Rebecca Ainstien', time: '4:45 AM', message: 'This is a message'},
    {name: 'Sophia Vondt', time: '11:52 AM', message: 'This is a message'},
    {name: 'Steve Allen', time: '2:52 PM', message: 'This is a message'},
    {name: 'Max Kitz', time: '9:52 PM', message: 'This is a message'},
])

const headers2 = ref([
            { text: 'Name', value: 'name' },
            { text: 'Time', value: 'time' },
            { text: 'Message', value: 'message' },
            { text: 'Actions', value: 'actions', className: 'w-1'}
        ]
      );

const data2 = ref([
    {name: 'John Splinsk', time: '6:01 AM', message: 'This is a message'},
    {name: 'Samantha Warren', time: '5:01 PM', message: 'This is a message'},
    {name: 'Diane Smith', time: '8:31 AM', message: 'This is a message'},
    {name: 'Roger Wickens', time: '2:31 PM', message: 'This is a message'},
    {name: 'Rebecca Ainstien', time: '4:45 AM', message: 'This is a message'},
    {name: 'Sophia Vondt', time: '11:52 AM', message: 'This is a message'},
    {name: 'Steve Allen', time: '2:52 PM', message: 'This is a message'},
    {name: 'Max Kitz', time: '9:52 PM', message: 'This is a message'},
])

//MODAL COMPONENTS
const showModal = ref(false);
const showSlotModal = ref(false);
const modalSize = ref('');

</script>

<template>
  <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Agents</h2>
        </template>
  <div>
    <h1 class="mx-20 mt-10 text-3xl font-bold">Base Components</h1>
    <hr class ="mt-2"/>
    <div class="mx-40 my-10 space-y-16">

      <!-- INPUT COMPONENT -->
      <div>
        <h1 class="mt-4 font-bold text-2xl">Inputs</h1>
        <hr class="mb-3"/>
        <div class="flex space-x-4 text-black">
          <BaseInput class=" bg-gray-100" type="text" v-model="input1" label="Name"></BaseInput>
          <BaseInput class="bg-gray-100" type="text" variant="error" v-model="input1" label="Company"></BaseInput>
          <BaseInput class="bg-gray-100" type="text" variant="success" v-model="input1" label="Company"></BaseInput>
          <BaseInput class="bg-gray-100" type="number" v-model="input1" label="Quantity"></BaseInput>
          <BaseInput class="bg-gray-100" type="text" variant="error" errorMessage="Password must be at least 12 characters" v-model="input1" label="Password"></BaseInput>
        </div>
      </div>

      <!-- BUTTON COMPONENT -->
      <div>
        <h1 class="mt-4 font-bold text-2xl">Buttons</h1>
        <hr class="mb-3"/>
        <div class="flex space-x-4 text-black">
          <BaseButton @focus="test" @click="test" @blur="test" type="primary" class=" font-semibold" :loading="loading">Primary</BaseButton>
          <BaseButton type="secondary" class=" font-semibold" @click="loading = !loading" :loading="loading">Secondary</BaseButton>
          <BaseButton type="error" class=" font-semibold" :loading="loading">Error</BaseButton>
          <BaseButton type="success" class=" font-semibold" :loading="loading">Success</BaseButton>
        </div>
        <h1 class="mt-4 font-semibold">Loading State</h1>
        <hr class="mb-3"/>
        <div class="flex space-x-4 text-black">
          <BaseButton @focus="test" @click="test" @blur="test" type="primary" class=" font-semibold" :loading="true">Primary</BaseButton>
          <BaseButton type="secondary" class=" font-semibold" :loading="true">Secondary</BaseButton>
          <BaseButton type="error" class=" font-semibold" :loading="true">Error</BaseButton>
          <BaseButton type="success" class=" font-semibold" :loading="true">Success</BaseButton>
        </div>
        <h1 class="mt-4 font-semibold">Disabled State</h1>
        <hr class="mb-3"/>
        <div class="flex space-x-4 text-black">
          <BaseButton @focus="test" @click="test" @blur="test" type="primary" class=" font-semibold" :disabled="true">Primary</BaseButton>
          <BaseButton type="secondary" class=" font-semibold" :disabled="true">Secondary</BaseButton>
          <BaseButton type="error" class=" font-semibold" :loading="true" :disabled="true">Error</BaseButton>
          <BaseButton type="success" class=" font-semibold" :loading="true" :disabled="true">Success</BaseButton>
        </div>
      </div>

      <!-- PAGINATION COMPONENT -->
      <div>
        <h1 class="mt-4 font-bold text-2xl">Pagination</h1>
        <hr class="mb-3"/>
        <BasePagination :total="100" :perPage="10"></BasePagination>
      </div>

      <!-- TABLE COMPONENT -->
      <div>
        <h1 class="mt-4 font-bold text-2xl">Table</h1>
        <h1 class="mt-4 font-semibold">Default</h1>
        <hr class="mb-3"/>

        <BaseTable :headers="headers" :items="data" :perPage="5" bordered></BaseTable>

        <h1 class="mt-4 font-semibold">Custom slot for a column</h1>
        <hr class="mb-3"/>

        <BaseTable :headers="headers2" :items="data2" :perPage="5" bordered>
          <template #row_name="item">
              <div class="flex space-x-4 items-center">
                  <div class="h-8 w-8 bg-gray-300 rounded-full"></div>
                  <p>{{item.item.name}}</p>
              </div>
          </template>
          <template #row_actions="item">
              <div class="flex space-x-4">
                  <BaseButton >Update</BaseButton>
                  <BaseButton type="error">Delete</BaseButton>
              </div>
          </template>
        </BaseTable>

        <h1 class="mt-4 font-semibold">Loading State</h1>
        <hr class="mb-3"/>
        <BaseTable :headers="headers" :perPage="5" bordered :loading="true"></BaseTable>
      </div>
      <!-- MODAL COMPONENT -->
      <div>
        <h1 class="mt-4 font-bold text-2xl">Modal</h1>
        <h1 class="mt-4">Properties: Boolean: visible, String: title, String: size, slot</h1>
        <hr class="mb-3"/>
        <div class="flex space-x-4">
          <BaseButton @click="showModal = true" >Show Modal</BaseButton>
          <BaseButton @click="showSlotModal = true">Slot Content Modal</BaseButton>
        </div>

        <h1 class="mt-4 font-semibold">Size Options (Ex: size="xs")</h1>
        <hr class="mb-3"/>
        <div class="flex space-x-4">
          <BaseButton @click="modalSize = 'xs'; showModal = true;">xs</BaseButton>
          <BaseButton @click="modalSize = 'sm'; showModal = true;">sm</BaseButton>
          <BaseButton @click="modalSize = 'lg'; showModal = true;">lg</BaseButton>
          <BaseButton @click="modalSize = 'xl'; showModal = true;">xl</BaseButton>
          <BaseButton @click="modalSize = 'x2'; showModal = true;">x2</BaseButton>
          <BaseButton @click="modalSize = 'x3'; showModal = true;">x3</BaseButton>
          <BaseButton @click="modalSize = 'x4'; showModal = true;">x4</BaseButton>
          <BaseButton @click="modalSize = 'x5'; showModal = true;">x5</BaseButton>
          <BaseButton @click="modalSize = 'x6'; showModal = true;">x6</BaseButton>
          <BaseButton @click="modalSize = 'x7'; showModal = true;">x7</BaseButton>
        </div>
      </div>
      <BaseModal
        :visible="showModal" 
        title="Title"
        @close="showModal = false"
        :size="modalSize"
        >
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In auctor tincidunt facilisis. Vestibulum sed fringilla nisi, et pellentesque metus. Proin vitae dui condimentum, elementum leo eu, pharetra velit. Sed id massa et felis consequat efficitur. In a eleifend augue. Vestibulum.</p>
    </BaseModal>

    
      <BaseModal
        :visible="showSlotModal" 
        title="Custom Slot Content (Any HTML)"
        @close="showSlotModal = false"
        >
        <BaseTable :headers="headers" :items="data" :perPage="5"></BaseTable>
    </BaseModal>

      

      <!-- ALERT COMPONENT -->
      <div>
        <h1 class="mt-4 font-bold text-2xl">Alert</h1>
        <h1 class="mt-4">Properties: String: title, String: type, String: body, Boolean: loading</h1>
        <hr class="mb-3"/>
        <div class="space-y-2">
          <BaseAlert title="Title" body="Body content"></BaseAlert>
          <BaseAlert title="Success" type="success" body="All operations have been successful."></BaseAlert>
          <BaseAlert title="Warning" type="warning" body="The options you have selected are not compatible."></BaseAlert>
          <BaseAlert title="Error" type="error" body="There is something wrong with this page."></BaseAlert>
        </div>
        

        <h1 class="mt-4 font-semibold">Loading State</h1>
        <hr class="mb-3"/>
        <BaseAlert title="Title" body="Body content" :loading="true"></BaseAlert>
      </div>
    </div>
  </div>
  </AuthenticatedLayout>
</template>