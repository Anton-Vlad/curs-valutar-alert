<script setup lang="ts">

const props = defineProps({
    rate: Object,
    className: String,
});

</script>

<template>
    <span :class="{
        'text-xs': true,
        ...className,
        'text-green-500': (rate.variation > 0),
        'text-red-500': (rate.variation < 0),
        'text-gray-500': (rate.variation == 0),
    }">({{ rate.variation }})</span>
</template>
