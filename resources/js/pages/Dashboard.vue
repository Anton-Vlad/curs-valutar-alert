<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import CurrencyTable from '@/components/CurrencyTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tabel Principal',
        href: '/principal',
    },
];

const props = defineProps<{
    name?: string;
    rates: Array;
    latestDate?: string;
}>();
</script>

<template>
    <Head title="Tabel Principal" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-5">
                    <h4 class="mt-0 mb-2">Ultimul comunicat</h4>
                    <p class="text-2xl font-semibold  transition-colors first:mt-0 lg:text-3xl">
                        {{ latestDate }}
                    </p>
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <CurrencyTable :data="props.rates" />
            </div>
        </div>
    </AppLayout>
</template>
