<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import InputError from '@/Components/InputError.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeLink from '@/Components/Link.vue';

import {Head, useForm} from '@inertiajs/inertia-vue3';
import {ref} from "vue";

defineProps({
    departments: Array,
})

const input = ref(null);

const form = useForm({
    name: '',
    id: ''
});

const updateDepartment = ({id, name}) => {
    form.id = id
    form.name = name
}

const submit = () => {
    form.post(route('departments.store'), {
        onSuccess: () => form.reset(),
    });
};

</script>

<template>
    <Head title="الأقسام" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                الأقسام
            </h2>
        </template>

        <div class="py-12">
            <div class="flex items-center justify-center sm:px-6 lg:px-8">
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <form @submit.prevent="submit" autocomplete="off">

                        <div class="mt-4">
                            <BreezeLabel for="update_name" value="إسم القسم" />
                            <BreezeInput id="update_name" type="text" class="mt-1 block w-full" v-model="form.name" required ref="input" />
                            <input-error :message="form.errors.name"></input-error>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                 حفظ
                            </BreezeButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">إسم القسم</th>
                                                <th scope="col" class="text-sm font-medium text-white px-6 py-4">إجراء</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(department, index) of departments" :key="index" class="bg-white border-b">
                                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ department.name }}</td>
                                                <td>
                                                    <breeze-button @click.prevent="updateDepartment(department)">تحديث</breeze-button>
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
