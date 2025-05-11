<template>
    <div
         class="relative flex flex-col w-full h-full overflow-scroll text-slate-300 bg-slate-800 shadow-md rounded-lg bg-clip-border">
        <table class="w-full text-left table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-slate-600 bg-slate-700">
                        <p class="text-sm font-normal leading-none text-slate-300">Category</p>
                    </th>
                    <th class="p-4 border-b border-slate-600 bg-slate-700">
                        <p class="text-sm font-normal leading-none text-slate-300">Brand</p>
                    </th>
                    <th class="p-4 border-b border-slate-600 bg-slate-700">
                        <p class="text-sm font-normal leading-none text-slate-300">Model</p>
                    </th>
                    <th class="p-4 border-b border-slate-600 bg-slate-700">
                        <div class="flex items-center gap-1 text-sm font-normal text-blue-gray-900 cursor-pointer"
                             @click="setSort('grade')">
                            <p class="text-slate-300">Grade</p>
                            
                            <SortIcon />
                        </div>
                    </th>
                    <th class="p-4 border-b border-slate-600 bg-slate-700">
                        <p class="text-sm font-normal leading-none text-slate-300">Condition</p>
                    </th>
                    <th class="p-4 border-b border-slate-600 bg-slate-700">
                        <div class="flex items-center gap-1 text-sm font-normal text-blue-gray-900 cursor-pointer"
                             @click="setSort('price')">
                            <p class="text-slate-300">Price (PLN)</p>
                            
                            <SortIcon />
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="smartphones.length === 0">
                    <td colspan="6"
                        class="text-sm font-normal leading-none text-slate-300 text-center">
                        <div class="my-5">No records found</div>
                    </td>
                </tr>

                <tr v-for="smartphone in smartphones"
                    :key="smartphone.id"
                    class="even:bg-slate-900 hover:bg-slate-700 cursor-pointer"
                    @click="goToSmartphonePage(smartphone.uniqueIdentifier)">
                    <td class="p-4 border-b border-slate-700">
                        <p class="text-sm text-slate-100 font-semibold">{{ smartphone.category }}</p>
                    </td>
                    <td class="p-4 border-b border-slate-700">
                        <p class="text-sm text-slate-300">{{ smartphone.brand }}</p>
                    </td>
                    <td class="p-4 border-b border-slate-700">
                        <p class="text-sm text-slate-300">{{ smartphone.model }}</p>
                    </td>
                    <td class="p-4 border-b border-slate-700">
                        <p class="text-sm text-slate-300">{{ smartphone.grade }}</p>
                    </td>
                    <td class="p-4 border-b border-slate-700">
                        <p class="text-sm text-slate-300">{{ smartphone.condition }}</p>
                    </td>
                    <td class="p-4 border-b border-slate-700">
                        <p class="text-sm text-slate-300">{{ formatPrice(smartphone.price) }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import SortIcon from './svgs/SortIcon.vue';

defineProps({
    smartphones: {
        type: Array,
        required: true
    },
    setSort: {
        type: Function,
        required: true
    }
});

const goToSmartphonePage = (uniqueIdentifier) => {
    const url = `https://breezy.pl/en/product/${uniqueIdentifier}`;

    window.open(url, '_blank');
};

const formatPrice = (price) => {
    return (price / 100).toFixed(2);
};
</script>