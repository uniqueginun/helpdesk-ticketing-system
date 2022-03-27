<script setup>
    import { useForm } from "@inertiajs/inertia-vue3";
    import BreezeButton from '@/Components/Button.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeSelect from '@/Components/Select.vue';

    defineProps({
        departments: Array,
        types: Object,
        priorities: Object,
        technicians: Array
    })

    const form = useForm({
        ticket_type: '',
        department_id: '',
        priority: '',
        technician: '',
    });

    const submit = () => {
        form.post(route('dashboard.query'), {
            onSuccess: () => {},
        });
    };
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="px-10 mx-auto container align-middle">
        <h4>الإستعلام عن البلاغات</h4>
        <div class="py-12">
            <div class="flex items-center justify-center sm:px-6 lg:px-8">
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <form @submit.prevent="submit" autocomplete="off">

                        <div class="mt-4">
                            <BreezeLabel for="ticket_type" value="نوع العطل" />
                            <BreezeSelect id="ticket_type" required v-model.number="form.ticket_type">
                                <option value="">إختر</option>
                                <option v-for="item of Object.keys(types)" :key="item" :value="item">{{ types[item] }}</option>
                            </BreezeSelect>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="departments" value="الإدارة" />
                            <BreezeSelect id="departments" required v-model="form.department_id">
                                <option value="">إختر الإدارة</option>
                                <option v-for="item of departments" :key="item.id" :value="item.id">{{ item.name }}</option>
                            </BreezeSelect>
                        </div>


                        <div class="mt-4">
                            <BreezeLabel for="user_role" value="الأولوية" />
                            <BreezeSelect id="user_role" required v-model="form.priority">
                                <option v-for="item of Object.keys(priorities)" :key="item" :value="item">{{ priorities[item] }}</option>
                            </BreezeSelect>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="technicians" value="الفني" />
                            <BreezeSelect id="technicians" required v-model="form.technician">
                                <option value="">إختر الفني</option>
                                <option v-for="item of technicians" :key="item.id" :value="item.id">{{ item.name }}</option>
                            </BreezeSelect>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                إستعلام
                            </BreezeButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</template>
