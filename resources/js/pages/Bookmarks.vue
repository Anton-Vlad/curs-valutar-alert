<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import CurrencyCard from '@/components/CurrencyCard.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My bookmarked currencies',
        href: '/bookmarks',
    },
];

const props = defineProps<{
    name?: string;
    rates: Array;
    latestDate?: string;
}>();
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div v-if="rates.length">
                <h2 class="text-xl mb-2 mt-3">Simboluri urmarite de tine</h2>
                <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
                    Configureaza alerte pe fiecare simbol.
                </p>
                <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                    <CurrencyCard
                        v-for="(item, index) in rates"
                        :rate="item"
                        :key="index"
                    />
                </div>
            </div>

            <div v-else>
                <h2 class="text-xl mb-2 mt-3">Momentan nu umaresti niciun simbol.</h2>
                <p class="mb-0 text-[#706f6c] dark:text-[#A1A09A]">Mergi in pagina principala si alege din tabel pana la 6 simboluri pe care vrei sa le urmaresti.</p>
                <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">Ele vor aparea aici si vei putea configura alerte pe fiecare.</p>
                <div  class="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div class="relative overflow-hidden rounded-xl border aspect-video border-sidebar-border/70 dark:border-sidebar-border p-3">
                        <PlaceholderPattern />
                    </div>
                    <div class="relative overflow-hidden rounded-xl border aspect-video border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern />
                    </div>
                    <div class="relative overflow-hidden rounded-xl border aspect-video border-sidebar-border/70 dark:border-sidebar-border">
                        <PlaceholderPattern />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
