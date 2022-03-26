<script setup>
defineProps({
    status: String
})
</script>

<template>
    <span :class="{
        'bg-gray-200': status === 'new',
        'bg-yellow-500': status === 'assigned',
        'bg-gray-300': status === 'saved',
        'bg-green-600': status === 'closed',
    }" class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold text-white rounded-full">
        <slot></slot>
    </span>
</template>
