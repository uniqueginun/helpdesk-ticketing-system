<script setup>
import { ref } from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeMainApplicationLogo from '@/Components/ApplicationMainLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import FlashMessage from "@/Components/FlashMessage";
import { Link } from '@inertiajs/inertia-vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')" class="flex flex-row">
                                    <BreezeApplicationLogo class="block h-12 w-auto" />
                                    <BreezeMainApplicationLogo class="block h-12 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex mr-2">
                                <BreezeNavLink class="ml-8" :href="route('dashboard')" :active="route().current('dashboard')">
                                    لوحة التحكم
                                </BreezeNavLink>

                                <template v-if="$page.props.auth.user.role === 'admin'">
                                    <BreezeNavLink :href="route('users.index')" :active="route().current('users.index')">
                                        المستخدمين
                                    </BreezeNavLink>

                                    <BreezeNavLink :href="route('reports.index')" :active="route().current('reports.index')">
                                        التقارير
                                    </BreezeNavLink>
                                </template>

                                <BreezeNavLink v-if="$page.props.auth.user.role !== 'technician'" :href="route('departments.index')" :active="route().current('departments.index')">
                                    الأقسام
                                </BreezeNavLink>

                                <BreezeNavLink :href="route('tickets.index')" :active="route().current('tickets.index')">
                                    البلاغات
                                </BreezeNavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            تسجيل خروج
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <BreezeResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            لوحة التحكم
                        </BreezeResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink class="ml-8" :href="route('dashboard')" :active="route().current('dashboard')">
                                لوحة التحكم
                            </BreezeResponsiveNavLink>

                            <template v-if="$page.props.auth.user.role === 'admin'">
                                <BreezeResponsiveNavLink :href="route('users.index')" :active="route().current('users.index')">
                                    المستخدمين
                                </BreezeResponsiveNavLink>

                                <BreezeResponsiveNavLink :href="route('reports.index')" :active="route().current('reports.index')">
                                    التقارير
                                </BreezeResponsiveNavLink>
                            </template>

                            <BreezeResponsiveNavLink v-if="$page.props.auth.user.role !== 'technician'" :href="route('departments.index')" :active="route().current('departments.index')">
                                الأقسام
                            </BreezeResponsiveNavLink>

                            <BreezeResponsiveNavLink :href="route('tickets.index')" :active="route().current('tickets.index')">
                                البلاغات
                            </BreezeResponsiveNavLink>

                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                خروج
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center flex-row">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <flash-message />
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
    td.text-sm, th.text-sm {
        font-size: 1.125rem !important;
        line-height: 1.75rem !important;
    }
</style>
