<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import { Link } from '@inertiajs/vue3';


const { agents, clientId, clientName } = usePage().props;

const tableLoading = ref(false);
const agentHeaders = ref([
    { text: 'Name', value: 'name' },
    { text: 'Department', value: 'department' },
    { text: 'Title', value: 'title' },
    { text: 'Email', value: 'email' },
])
 
</script>

<template>
    <Head title="Agents" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Agents</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row space-x-5">
                    <Link :href="route('dashboard')">
                        <BaseButton type="secondary" class="font-semibold">Back</BaseButton>
                    </Link>
                    <h1 class="bold text-3xl">{{ clientName }}</h1>
                </div>
                <hr class="h-1 my-4 bg-gray-200 border-0 rounded">
                
                <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-8 rounded-md">
                    <h2 class="font-bold text-xl mb-2">Agents</h2>
                    <hr class="mb-2">
                    <BaseTable :headers="agentHeaders" :items="agents" :loading="tableLoading" :perPage="5" enableSearch>
                    </BaseTable>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
