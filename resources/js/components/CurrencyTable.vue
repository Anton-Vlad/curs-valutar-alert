<script setup>
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { ref, onMounted } from 'vue';
import CountryFlagSvg from '@/components/CountryFlagSvg.vue';
import RateName from '@/components/RateName.vue';
import { Switch } from '@/components/ui/switch';

const props = defineProps({
    data: Array
});

const bookmarks = ref({});

onMounted(() => {
    for (let i = 0; i < props.data.length; i++) {
        bookmarks.value[props.data[i].currency] = false;
    }

    // bookmarks.value['EUR'] = true;
})

const toggleBookmark = (rate) => {
    bookmarks.value[rate] = !bookmarks.value[rate];

    console.log(bookmarks.value);
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
                <TableHead class="text-right">
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
                    {{ rate.rate }}
                </TableCell>
                <TableCell class="text-right flex justify-end">
                    <Switch
                        :model-value="bookmarks[rate.currency]"
                        @update:model-value="toggleBookmark(rate.currency)"
                    />
                </TableCell>

            </TableRow>
        </TableBody>
    </Table>
</template>

