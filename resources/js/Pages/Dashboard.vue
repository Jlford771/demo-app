<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { nextTick,ref, onMounted } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';;
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const clients = ref([]);
const tableLoading = ref(false);
const clientHeaders = ref([
    { text: 'Name', value: 'name' },
    { text: 'Type', value: 'type' },
    { text: 'Join Date', value: 'formatted_created_at' },
    { text: 'Agents', value: 'agents_count' },
    { text: 'Actions', value: 'actions', className: 'w-1'}
])



const fetchClients = () => {
    axios.get('/api/clients')
        .then(response => {
            clients.value = response.data.clients;
            tableLoading.value = true;
            populatePieGraph();
            fetchTrajectorySeries();
        })
        .catch(error => {
            console.error('Error fetching clients:', error);
        })
        .finally(() => {
            tableLoading.value = false;
        });
};

// Fetch clients when the component is mounted
onMounted(fetchClients);

//CRUD
const showFormModal = ref(false);
const form = ref({
    name: '',
    type: ''
});

const createClient = () => {
    axios.post('/api/clients', form.value)
        .then(response => {
            console.log('User created:', response.data);
            showFormModal.value = false;
            resetForm();
            fetchClients();
        })
        .catch(error => {
            console.error('Error creating user:', error);
        })
};

const showDeleteModal = ref(false);

const deleteClient = (clientId) => {
    console.log(clientId);
    axios.delete(`/api/clients/${selectedClientId.value}`)
        .then(response => {
            console.log('Client deleted:', response.data);
            showDeleteModal.value = false;
            fetchClients();
            
        })
        .catch(error => {
            console.error('Error deleting client:', error);
        });
};

//Update
const editingClient = ref(false);
const selectedClientId = ref(0);

const editClient = (clientId) =>{
    editingClient.value = true;

    const client = clients.value.find(client => client.id === clientId);
    selectedClientId.value = client.id

    form.value.name = client.name;
    form.value.type = client.type; 

    showFormModal.value = true;
}

const updateClient = () => {
    axios.patch(`/api/clients/${selectedClientId.value}`, form.value)
        .then(response => {
            console.log('User created:', response.data);
            showFormModal.value = false;
            resetForm();
            fetchClients();
        })
        .catch(error => {
            console.error('Error updating user:', error);
        })
};

const closeModal = () => {
    showFormModal.value = false;
    editingClient.value = false;
    resetForm();
};

const resetForm = () =>{
    form.value.name = '';
    form.value.type = ''; 
}

//Graphs
const options = ref({
    labels: []
})

const series = ref([]);

const populatePieGraph = () =>{
    const { uniqueTypes, typeCountsArray } = clients.value.reduce(
        (accumulator, client) => {
            const { uniqueTypes, typeCountsArray } = accumulator;
            const index = uniqueTypes.indexOf(client.type);
        if (index === -1) {
            uniqueTypes.push(client.type);
            typeCountsArray.push(1);
        } else {
            typeCountsArray[index] += 1;
        }

        return accumulator;
        },
        { uniqueTypes: [], typeCountsArray: [] }
  );
  options.value = { ...options.value, labels: uniqueTypes };
  series.value = typeCountsArray
};


const lineSeries = ref([
            {
              name: "Trial",
              data: [2, 4, 4, 4, 7, 10]
            },
            {
              name: "Standard",
              data: [1, 4, 4, 4, 5, 5]
            },
            {
              name: "Premium",
              data: [2, 4, 5, 7, 7, 7]
            },
            {
              name: "Business",
              data: [2, 3, 3, 4, 6, 10]
            }
          ]);

const lineChartOptions = ref({
            chart: {
              height: 350,
              type: 'line',
              dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
              },
              toolbar: {
                show: false
              }
            },
            dataLabels: {
              enabled: true,
            },
            stroke: {
              curve: 'smooth'
            },
            grid: {
              borderColor: '#e7e7e7',
              row: {
                colors: ['#f3f3f3', 'transparent'],
                opacity: 0.5
              },
            },
            markers: {
              size: 1
            },
            xaxis: {
              categories: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
              title: {
                text: 'Month'
              }
            },
            yaxis: {
              title: {
                text: 'Membership',
              },
              min: 0,
            },
            legend: {
              position: 'top',
              horizontalAlign: 'right',
              floating: true,
              offsetY: -25,
              offsetX: -5
            }
          });


const fetchTrajectorySeries = () => {
    axios.get('/api/trajectorySeries')
        .then(response => {
            lineSeries.value = response.data.trajectorySeries;
            
        })
        .catch(error => {
            console.error('Error fetching trajectorySeries:', error);
            lineSeries.value = [
            {
              name: "Trial",
              data: [2, 4, 4, 4, 7, 10]
            },
            {
              name: "Standard",
              data: [1, 4, 4, 4, 5, 5]
            },
            {
              name: "Premium",
              data: [2, 4, 5, 7, 7, 7]
            },
            {
              name: "Business",
              data: [2, 3, 3, 4, 6, 10]
            }
          ]
        })
};
    
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex space-x-16 mb-10">
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8 rounded-md w-1/2 ">
                        <h2 class ="font-bold text-xl">Membership Rates</h2>
                        <hr class="my-2">
                        <apexchart width="400" type="pie" :options="options" :series="series"></apexchart>
                    </div>
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8 rounded-md w-1/2">
                        <h2 class ="font-bold text-xl">Trajectory</h2>
                        <hr class="my-2">
                        <apexchart type="line" height="250" :options="lineChartOptions" :series="lineSeries"></apexchart>
                    </div>
                </div>
                <div class="flex justify-end mb-4">
                    <SecondaryButton @click="showFormModal = true"> Create</SecondaryButton>
                </div>
                
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8 rounded-md">
                    <h2 class="font-bold text-xl mb-2">Clients</h2>
                    <hr class="mb-2">
                    <BaseTable :headers="clientHeaders" :items="clients" :loading="tableLoading" :perPage="5" enableSearch>
                        <template #row_actions="item">
                            <div class="flex space-x-4">
                                <BaseButton @click="editClient(item.item.id)" >Update</BaseButton>
                                <BaseButton @click="selectedClientId = item.item.id, showDeleteModal = true" type="error">Delete</BaseButton>
                                <Link :href="route('agents.index', { clientId: item.item.id })">
                                    <BaseButton type="secondary" >View</BaseButton>
                                </Link>
                            </div>
                        </template>
                        <template #row_agents_count="item">
                            {{ item.item.agents.length }}
                        </template>
                    </BaseTable>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <Modal :show="showFormModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    {{editingClient ? 'Update Client' : 'Create Client'}}
                </h2>
                <hr>    
                <div class="space-y-2">
                    <div class="mt-6">
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="type"
                        />
                    </div>

                    <div>
                        <InputLabel for="type" value="Type" />

                        <select
                            id="type"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.type"
                            required
                            autofocus
                            autocomplete="type"
                        >
                            <option value="" disabled>Select a type</option>
                            <option value="Trial">Trial</option>
                            <option value="Standard">Standard</option>
                            <option value="Premium">Premium</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="editingClient ? updateClient() : createClient()"
                    >
                        Submit
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
        <!-- delete modal -->
        <Modal :show="showDeleteModal" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                     Delete Client
                </h2>
                <hr>    
                <p class="mt-8">Are you sure that you want to delete the client?</p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="showDeleteModal=false"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteClient()"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
