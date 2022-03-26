<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeLink from '@/Components/Link.vue';

import { Head } from '@inertiajs/inertia-vue3';
import { Link } from "@inertiajs/inertia-vue3";

defineProps({
    users: Array,
    auth: Object
})
</script>

<template>
    <Head title="المستخدمين" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                المستخدمين
            </h2>

            <breeze-link type="success" :href="route('users.create')">إنشاء مستخدم</breeze-link>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden">
                                        <table class="min-w-full text-center">
                                            <thead class="border-b bg-gray-800">
                                            <tr>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">#</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">الإسم</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">البريد الإلكتروني</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">نوع المستخدم</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">إجراء</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(user, index) of users" :key="index" class="bg-white border-b">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ user.id }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ user.user_role }}</td>
                                                <td>
                                                    <breeze-link class="mx-1" theme="warning" :href="route('users.edit', user.id)">تحديث</breeze-link>
                                                    <Link
                                                        v-if="auth.user.id !== user.id"
                                                        class="inline-block
                                                            border-red-600
                                                            text-red-600
                                                            px-6 py-2
                                                            border-2
                                                            font-medium
                                                            text-xs
                                                            leading-tight
                                                            uppercase
                                                            rounded-full
                                                            hover:bg-black
                                                            hover:bg-opacity-5
                                                            focus:outline-none
                                                            focus:ring-0
                                                            transition
                                                            duration-150
                                                            ease-in-out"
                                                        theme="danger"
                                                        :href="route('users.destroy', user.id)"
                                                        method="delete"
                                                        as="button">حذف</Link>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
