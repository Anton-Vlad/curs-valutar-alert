<script setup>
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import CountryFlagSvg from '@/components/CountryFlagSvg.vue';
import { Bookmark } from 'lucide-vue-next';
import { Button } from '@/components/ui/button/index.js';

const props = defineProps({
    data: Array
});

</script>

<template>
    <Table>
<!--        <TableCaption>A list of your recent invoices.</TableCaption>-->
        <TableHeader>
            <TableRow>
                <TableHead class="w-[140px]">
                    Code
                </TableHead>
                <TableHead class="w-[160px]">RON Value</TableHead>
                <TableHead>Currency</TableHead>
                <TableHead class="text-right">
                    Bookmark
                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="rate in props.data" :key="rate.currency">
                <TableCell>
                    <div class="flex items-center gap-5 ">
                        <CountryFlagSvg :code="rate.currency" />
                        <span>{{ rate.currency }}</span>
                    </div>
                </TableCell>
                <TableCell>{{ rate.rate }}</TableCell>
                <TableCell>
                    <span>{{ rate.currency }}</span>
                </TableCell>
                <TableCell class="text-right flex justify-end">
                    <Button variant="link">
                        <Bookmark />
                    </Button>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

