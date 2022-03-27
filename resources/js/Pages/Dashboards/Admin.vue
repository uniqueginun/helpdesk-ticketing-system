<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import TicketByStatus from "@/Components/TicketByStatus";

defineProps({
    'ticket_status': Array
})

</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                لوحة التحكم
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <ticket-by-status :ticket_status="ticket_status"></ticket-by-status>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
