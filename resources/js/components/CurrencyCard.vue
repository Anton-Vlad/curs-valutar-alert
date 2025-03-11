<script setup lang="ts">
import { ref } from 'vue';
import CountryFlagSvg from '@/components/CountryFlagSvg.vue';
import RateName from '@/components/RateName.vue';
import { Switch } from '@/components/ui/switch';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger
} from '@/components/ui/tooltip'
import { useForm } from '@inertiajs/vue3';
import { useToast } from '@/components/ui/toast/use-toast';
import CurrencyVariation from '@/components/CurrencyVariation.vue';

const props = defineProps({
    rate: Object,
});

const { toast } = useToast();

const isBookmark = ref(true);
const form = useForm({
    symbol: props.rate.currency,
    action: isBookmark.value ? 'add' : 'remove',
});

const toggleBookmark = () => {
    isBookmark.value = !isBookmark.value;
    updateBookmarks();
}

function updateBookmarks() {
    form.transform(() => ({
        symbol: props.rate.currency,
        action: isBookmark.value ? 'add' : 'remove',
    })).put(route('bookmarks.update'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            isBookmark.value = true;
            toast({
                title: 'Ai scos cu success simbolul de la Urmarite.',
                // variant: 'destructive',
            });
        },
    });
}

</script>

<template>
    <div class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-5">
        <h4 class="mt-0 mb-2 flex items-center gap-3">
            <CountryFlagSvg :code="rate.currency" />
            <RateName :code="rate.currency" />

            <CurrencyVariation :rate="rate" :class-name="{'ml-auto': true, 'mr-0': true}" />
        </h4>

        <p class="text-xl font-semibold  transition-colors first:mt-0 lg:text-2xl">
            1 {{ rate.currency }} = {{ rate.value }} RON
        </p>

        <div class="mt-3 flex items-center justify-end gap-3">


            <TooltipProvider>
                <Tooltip>
                    <TooltipTrigger>
                        <Switch
                            :model-value="isBookmark"
                            @update:model-value="toggleBookmark"
                        />
                    </TooltipTrigger>
                    <TooltipContent>
                        <p>Scoate de la urmarite</p>
                    </TooltipContent>
                </Tooltip>
            </TooltipProvider>

        </div>
    </div>
</template>
