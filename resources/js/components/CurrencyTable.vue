<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import CountryFlagSvg from '@/components/CountryFlagSvg.vue';
import RateName from '@/components/RateName.vue';
import { Switch } from '@/components/ui/switch';
import { useToast } from '@/components/ui/toast/use-toast';
import CurrencyVariation from '@/components/CurrencyVariation.vue';

const props = defineProps({
    data: Array,
    defaults: Object,
    readonly: Boolean,
});

const { toast } = useToast();

const bookmarks = ref(props.defaults);
const form = useForm({
    'symbols': bookmarks.value
});

const toggleBookmark = (rate) => {
    bookmarks.value[rate] = !bookmarks.value[rate];
    saveBookmarks();
}

function saveBookmarks() {
    form.transform(() => ({
        symbols: {...bookmarks.value},
    })).post(route('bookmarks.store'), {
        preserveScroll: true,
        onSuccess: () => {
            toast({
                title: 'Ai adaugat cu success simbolul la Urmarite.',
            });
        },
    });
}

</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead class="w-[70px]">
                    Simbol
                </TableHead>
                <TableHead class="w-[270px]">
                    Denumire
                </TableHead>
                <TableHead class="">
                    Valoare în RON
                </TableHead>
                <TableHead v-if="!readonly" class="text-right">
                    Urmărește
                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="rate in props.data" :key="rate.currency">
                <TableCell>
                    <div>
                        <span>{{ rate.currency }}</span>
                    </div>
                </TableCell>
                <TableCell>
                    <div class="flex items-center gap-5 ">
                        <CountryFlagSvg :code="rate.currency" />
                        <RateName :code="rate.currency" />
                    </div>
                </TableCell>
                <TableCell>
                    {{ rate.value }} <CurrencyVariation :rate="rate" :class-name="{'ml-3': true}" />
                </TableCell>
                <TableCell v-if="!readonly" class="text-right flex justify-end">
                    <Switch
                        :model-value="bookmarks[rate.currency]"
                        @update:model-value="toggleBookmark(rate.currency)"
                    />
                </TableCell>

            </TableRow>
        </TableBody>
    </Table>
</template>

