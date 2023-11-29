<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen justify-center flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <div class="bg-gray-300 rounded-full h-14 w-44 border-gray-200 border-2 items-center justify-center">
                <div class="flex items-center justify-center h-full">
                    <h2 class="font-black text-xl">
                        <span class="text-black">Client</span>
                        <span class="text-white italic">Sphere</span>
                    </h2>
                    <h2 class="font-bold text-2xl italic text-blue-600">+</h2>
                </div>
            </div>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
