<script setup>
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger
} from '@/components/ui/tooltip';
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
                <TableHead class="w-[100px]">
                    Flag
                </TableHead>
                <TableHead>Code</TableHead>
                <TableHead>Value</TableHead>
                <TableHead class="text-right">
                    Bookmark
                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="rate in props.data" :key="rate.currency">
                <TableCell>
                    <CountryFlagSvg :code="rate.currency" />
                </TableCell>
                <TableCell>
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <span>{{ rate.currency }}</span>
                                <span v-if="rate.currency === 'HRK'"> [!]</span>
                            </TooltipTrigger>
                            <TooltipContent>
                                <p>Add to library</p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                </TableCell>
                <TableCell>{{ rate.rate }}</TableCell>
                <TableCell class="text-right flex justify-end">
                    <Button variant="link">
                        <Bookmark />
                    </Button>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

