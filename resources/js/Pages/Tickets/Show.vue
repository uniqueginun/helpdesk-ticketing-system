<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeLink from '@/Components/Link.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeTextarea from '@/Components/Textarea.vue';
import InputError from '@/Components/InputError.vue';
import TicketPriority from "@/Components/TicketPriority.vue";
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    ticket: Object
})

const form = useForm({
    notes: ''
});

const submit = () => {
    form.post(route('tickets.close', props.ticket.uuid), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="البلاغات" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                عرض تفاصيل البلاغ رقم ({{ ticket.id }})
            </h2>

            <breeze-link type="success" :href="route('tickets.index')">رجوع</breeze-link>
        </template>

        <div class="py-12">
            <div class="flex items-center justify-center sm:px-6 lg:px-8">
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <form @submit.prevent="submit" autocomplete="off">

                        <div class="mt-4">
                            <BreezeLabel value="نوع العطل" />
                            <BreezeInput type="text" class="mt-1 block w-full" :value="ticket.display_type" readonly />
                        </div>

                        <div class="mt-4">
                            <BreezeLabel value="الموظف طالب الخدمة" />
                            <BreezeInput type="text" class="mt-1 block w-full" :value="ticket.employee_name" readonly />
                        </div>

                        <div class="mt-4">
                            <BreezeLabel value="الإدارة التي يتبع لها" />
                            <BreezeInput type="text" class="mt-1 block w-full" :value="ticket.department.name" readonly />
                        </div>

                        <div class="mt-4">
                            <BreezeLabel value="تفاصيل البلاغ" />
                            <BreezeInput type="text" class="mt-1 block w-full" :value="ticket.details" readonly />
                        </div>

                        <div class="mt-4">
                            <BreezeLabel value="الأولوية" />
                            <ticket-priority :priority="ticket.priority">{{ ticket.priority_name }}</ticket-priority>
                        </div>

                        <template v-if="ticket.closable">
                            <div class="mt-4">
                                <BreezeLabel for="details" value="كتابة ملاحظات إنهاء الطلب" />
                                <BreezeTextarea id="details" rows="10" v-model="form.notes"></BreezeTextarea>
                                <input-error :message="form.errors.notes"></input-error>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    حفظ وإنهاء الطلب
                                </BreezeButton>
                            </div>
                        </template>

                        <template v-if="ticket.finish_action">
                            <div>{{ `تم ${ticket.finish_action.action_name} بواسطة ${ticket.finish_action.creator_name} في ${ticket.finish_action.creation_date}` }}</div>
                            <div>{{ ticket.finish_action.action_notes }}</div>
                        </template>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
