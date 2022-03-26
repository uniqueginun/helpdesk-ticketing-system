<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeLink from '@/Components/Link.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeSelect from '@/Components/Select.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    name: '',
    email: '',
    user_role: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => form.reset(),
    });
};

defineProps({
    types: Object
})
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
                            <BreezeLabel for="password" value="كلمة المرور" />
                            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required />
                            <input-error :message="form.errors.password"></input-error>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="password_confirmation" value="تأكيد كلمة المرور" />
                            <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="user_role" value="نوع المستخدم" />
                            <BreezeSelect id="user_role" required v-model="form.user_role">
                                <option value="">إختر</option>
                                <option v-for="item of Object.keys(types)" :key="item" :value="item">{{ types[item] }}</option>
                            </BreezeSelect>
                            <input-error :message="form.errors.user_role"></input-error>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                إنشاء المستخدم
                            </BreezeButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
