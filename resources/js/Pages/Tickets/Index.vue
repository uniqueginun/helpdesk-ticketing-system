<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeLink from '@/Components/Link.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeSelect from '@/Components/Select.vue';
import Pagination from '@/Components/Pagination.vue';
import TicketStatus from "@/Components/TicketStatus.vue";
import TicketPriority from "@/Components/TicketPriority.vue";
import { Head } from '@inertiajs/inertia-vue3';

defineProps({
    tickets: Object,
    ticketPriority: Object,
})

</script>

<template>
    <Head title="البلاغات" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                البلاغات
            </h2>

            <breeze-link v-if="$page.props.auth.user.role === 'admin'" type="success" :href="route('tickets.create')">إنشاء بلاغ جديد</breeze-link>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="w-full sm:max-w-md my-3 flex flex-row items-center justify-end">
                            <div class="w-full mr-1">
                                <BreezeSelect>
                                    <option value="">الأولوية</option>
                                    <option v-for="item of Object.keys(ticketPriority)" :key="item" :value="item">{{ ticketPriority[item] }}</option>
                                </BreezeSelect>
                            </div>
                            <div class="w-full mr-1">
                                <BreezeSelect>
                                    <option value="">الأولوية</option>
                                    <option v-for="item of Object.keys(ticketPriority)" :key="item" :value="item">{{ ticketPriority[item] }}</option>
                                </BreezeSelect>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full text-center">
                                            <thead class="border-b bg-gray-800">
                                            <tr>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">تاريخ الطلب</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">العطل</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">صاحب الطلب</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">الإدارة التابع لها</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">الفني</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">الأولوية</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">الحالة</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">التفاصيل</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="ticket in tickets.data" :key="ticket.id" class="bg-white border-b">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ticket.creation_date }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ ticket.display_type }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ ticket.employee_name }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ ticket.department_name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ ticket.technician_name }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <ticket-priority :priority="ticket.priority">{{ ticket.priority_name }}</ticket-priority>
                                                </td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <ticket-status :status="ticket.status" class="bg-blue-600">{{ ticket.status_name }}</ticket-status>
                                                </td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                    <breeze-link type="success" :href="route('tickets.show', ticket.uuid)">عرض</breeze-link>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <pagination class="mt-6" :links="tickets.links" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
