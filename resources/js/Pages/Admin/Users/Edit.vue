<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeLink from '@/Components/Link.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeSelect from '@/Components/Select.vue';
import InputError from '@/Components/InputError.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    types: Object,
    user: Object
})

const form = useForm({
    edited_user_id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    user_role: props.user.user_role,
    update_password: false,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.put(route('users.update', props.user.id), {
        onSuccess: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="المستخدمين" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                إنشاء مستخدم جديد
            </h2>

            <breeze-link type="success" :href="route('users.index')">رجوع</breeze-link>
        </template>

        <div class="py-12">
            <div class="flex items-center justify-center sm:px-6 lg:px-8">
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    <form @submit.prevent="submit" autocomplete="off">
                        <div>
                            <BreezeLabel for="name" value="الإسم" />
                            <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="false" />
                            <input-error :message="form.errors.name"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="email" value="البريد الإلكتروني" />
                            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                            <input-error :message="form.errors.email"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="user_role" value="نوع المستخدم" />
                            <BreezeSelect id="user_role" required v-model="form.user_role">
                                <option value="">إختر</option>
                                <option v-for="item of Object.keys(types)" :key="item" :value="item">{{ types[item] }}</option>
                            </BreezeSelect>
                            <input-error :message="form.errors.user_role"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="update_password" value="تحديث كلمة المرور" />
                            <BreezeCheckbox id="update_password" v-model="form.update_password" />
                        </div>

                        <template v-if="form.update_password">
                            <div class="mt-4">
                                <BreezeLabel for="password" value="كلمة المرور" />
                                <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" />
                                <input-error :message="form.errors.password"></input-error>
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="password_confirmation" value="تأكيد كلمة المرور" />
                                <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                            </div>
                        </template>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                تحديث المستخدم
                            </BreezeButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
