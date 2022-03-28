<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import TicketStatus from "@/Components/TicketStatus.vue";
import TicketPriority from "@/Components/TicketPriority.vue";
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
    tickets: Object
})
</script>

<template>
    <Head title="التقرير العام" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                تقرير البلاغات العام
                <span v-if="tickets.total">(الإجمالي: {{ tickets.total }})</span>
            </h2>

            <button onclick="window.print()" class="print-btn bg-green-200 text-green-900 py-2 px-4 rounded shadow hover:shadow-xl hover:bg-green-300 duration-300">طباعة</button>
        </template>

        <div class="py-12 mx-4">
            <table class="min-w-full text-center">
                <thead class="border-b bg-gray-300">
                <tr>
                    <th class="text-lg font-medium text-white px-6 py-4">تاريخ الطلب</th>
                    <th class="text-lg font-medium text-white px-6 py-4">العطل</th>
                    <th class="text-lg font-medium text-white px-6 py-4">صاحب الطلب</th>
                    <th class="text-lg font-medium text-white px-6 py-4">الإدارة التابع لها</th>
                    <th class="text-lg font-medium text-white px-6 py-4">الفني</th>
                    <th class="text-lg font-medium text-white px-6 py-4">الأولوية</th>
                    <th class="text-lg font-medium text-white px-6 py-4">الحالة</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="ticket in tickets" :key="ticket.id" class="bg-white border-b">
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900">{{ ticket.creation_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900">{{ ticket.display_type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900">{{ ticket.employee_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900">{{ ticket.department_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900">{{ ticket.technician_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900"><ticket-priority :priority="ticket.priority">{{ ticket.priority_name }}</ticket-priority></td>
                    <td class="px-6 py-4 whitespace-nowrap text-lg font-medium text-gray-900"><ticket-status :status="ticket.status" class="bg-blue-600">{{ ticket.status_name }}</ticket-status></td>
                </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style>
@media print {
    .print-btn {
        display: none;
    }

    .min-h-screen.bg-gray-100, body, main {
        background: white !important;
    }
}
</style>

