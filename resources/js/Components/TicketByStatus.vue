<script setup>
import Card from "@/Components/Card";

defineProps({
    'ticket_status': Array
})
</script>

<template>
    <div class="px-10 mx-auto container align-middle">
        <div class="grid grid-cols-2 gap-2">
            <card v-for="(ticket, index) of ticket_status" :key="index">
                <div>
                    <h6 class="text-2xl">{{ ticket.display_name }}</h6>
                    <h4 class="text-black text-4xl font-bold text-right">{{ ticket.status_count }}</h4>
                </div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-12 w-12"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="#EF4444"
                         stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"
                        />
                    </svg>
                </div>
            </card>
        </div>
    </div>
</template>
