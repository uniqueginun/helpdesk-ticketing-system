<script setup>
    defineProps(['modelValue']);

    defineEmits(['update:modelValue']);
</script>

<template>
    <div class="flex justify-center">
        <div class="mb-3 w-full">
            <select :value="modelValue" @change="$emit('update:modelValue', $event.target.value)" class="form-select appearance-none
              block
              w-full
              px-3
              py-2
              text-base
              font-normal
              text-gray-700
              bg-white bg-clip-padding bg-no-repeat
              border border-solid border-gray-300
              rounded
              transition
              ease-in-out
              m-0
              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Default select example">
                <slot></slot>
            </select>
        </div>
    </div>
</template>
