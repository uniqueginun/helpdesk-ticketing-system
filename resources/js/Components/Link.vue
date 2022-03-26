<script setup>
    const props = defineProps({
        theme: {
            type: String,
            default: 'success'
        }
    })

    const is = theme => props.theme === theme;
</script>

<template>
    <a
        :class="{
            'border-green-500 text-green-500': is('success'),
            'border-yellow-500 text-yellow-500': is('warning'),
            'border-red-600 text-red-600': is('danger'),
        }"

        class="
            inline-block
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
            ease-in-out
        "
    >
        <slot></slot>
    </a>
</template>
