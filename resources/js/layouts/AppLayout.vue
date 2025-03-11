<script setup lang="ts">
import AppLayout from '@/layouts/app/AppHeaderLayout.vue';
import { Toaster } from '@/components/ui/toast'
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppLayout :breadcrumbs="props.breadcrumbs">
        <slot />
        <Toaster />
    </AppLayout>
</template>
