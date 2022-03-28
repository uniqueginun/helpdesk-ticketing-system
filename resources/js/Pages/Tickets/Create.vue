<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeLink from '@/Components/Link.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeSelect from '@/Components/Select.vue';
import BreezeTextarea from '@/Components/Textarea.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    ticket_type: '',
    other_ticket_type: '',
    employee_name: '',
    department_id: '',
    priority: 'normal',
    details: '',
    technician: '',
});

const submit = () => {
    form.post(route('tickets.store'), {
        onSuccess: () => form.reset(),
    });
};

defineProps({
    ticketPriority: Object,
    deviceTypes: Object,
    technicians: Array,
    departments: Array,
})

</script>

<template>
    <Head title="البلاغات" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                إنشاء بلاغ جديد
            </h2>

            <breeze-link type="success" :href="route('tickets.index')">رجوع</breeze-link>
        </template>

        <div class="py-12">
            <div class="flex items-center justify-center sm:px-6 lg:px-8">
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <form @submit.prevent="submit" autocomplete="off">

                        <div class="mt-4">
                            <BreezeLabel for="ticket_type" value="نوع العطل" />
                            <BreezeSelect id="ticket_type" required v-model.number="form.ticket_type">
                                <option value="">إختر</option>
                                <option v-for="item of Object.keys(deviceTypes)" :key="item" :value="item">{{ deviceTypes[item] }}</option>
                            </BreezeSelect>
                            <input-error :message="form.errors.ticket_type"></input-error>
                        </div>

                        <div class="mt-4" v-if="form.ticket_type === 4">
                            <BreezeLabel for="other_ticket_type" value="أدخل النوع" />
                            <BreezeInput id="other_ticket_type" type="text" class="mt-1 block w-full" v-model="form.other_ticket_type" required />
                            <input-error :message="form.errors.other_ticket_type"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="employee_name" value="الموظف طالب الخدمة" />
                            <BreezeInput id="employee_name" type="text" class="mt-1 block w-full" v-model="form.employee_name" required />
                            <input-error :message="form.errors.employee_name"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="departments" value="الإدارة التي يتبع لها" />
                            <BreezeSelect id="departments" required v-model="form.department_id">
                                <option value="">إختر الإدارة</option>
                                <option v-for="item of departments" :key="item.id" :value="item.id">{{ item.name }}</option>
                            </BreezeSelect>
                            <input-error :message="form.errors.department_id"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="details" value="تفاصيل البلاغ" />
                            <BreezeTextarea id="details" rows="10" v-model="form.details" required></BreezeTextarea>
                            <input-error :message="form.errors.details"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="user_role" value="الأولوية" />
                            <BreezeSelect id="user_role" required v-model="form.priority">
                                <option v-for="item of Object.keys(ticketPriority)" :key="item" :value="item">{{ ticketPriority[item] }}</option>
                            </BreezeSelect>
                            <input-error :message="form.errors.priority"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="technicians" value="إسناد البلاغ الى الفني" />
                            <BreezeSelect id="technicians" required v-model="form.technician">
                                <option value="">إختر الفني</option>
                                <option v-for="item of technicians" :key="item.id" :disabled="!item.available" :value="item.id">{{ item.name }}</option>
                            </BreezeSelect>
                            <input-error :message="form.errors.technician"></input-error>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                حفظ البلاغ
                            </BreezeButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
