<script setup>
    defineProps({
        priority: String
    })
</script>

<template>
    <span :class="{
        'bg-green-500': priority === 'normal',
        'bg-yellow-500': priority === 'urgent',
        'bg-red-600': priority === 'super-argent',
    }" class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold text-white rounded-full">
        <slot></slot>
    </span>
</template>

