<script setup>
    defineProps({
        dimensions: {
            type: String,
            default: 'h-12 w-12'
        }
    })
</script>

<template>
    <img src="/images/1834EB9C-E1AE-42F1-B238-A515532E42CD.jpeg" class="ml-2" :class="dimensions">
</template>
