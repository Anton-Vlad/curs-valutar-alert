<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import { Label } from '@/components/ui/label'
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Switch } from '@/components/ui/switch';
import { ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Alerte',
        href: '/settings/alerte',
    },
];

const dailyAlertStatus = ref(true);

const toggleDailyAlert = () => {
    dailyAlertStatus.value = !dailyAlertStatus.value;
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Setari alerte" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Setari alerte" description="Gestioneaza alertele contului" />


                <div>
                    <ul>
                        <li class="flex items-center space-x-4">
                            <Switch
                                id="daily-alert-toggle"
                                :model-value="dailyAlertStatus"
                                @update:model-value="toggleDailyAlert"
                            />

                            <Label for="daily-alert-toggle">Alerte zilnice</Label>
                        </li>
                    </ul>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
