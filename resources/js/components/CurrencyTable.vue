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
                    Track
                </TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="rate in props.data" :key="rate.code">
                <TableCell>
                    <CountryFlagSvg :code="rate.code" />
                </TableCell>
                <TableCell>
                    <TooltipProvider>
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <span>{{ rate.code }}</span>
                            </TooltipTrigger>
                            <TooltipContent>
                                <p>Add to library</p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                </TableCell>
                <TableCell>{{ rate.value }}</TableCell>
                <TableCell class="text-right">
                    -
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>

