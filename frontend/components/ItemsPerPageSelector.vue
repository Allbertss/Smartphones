<template>
    <div>
        <label for="perPage"
               class="mr-2 text-sm text-slate-400">
            Items per page:
        </label>

        <select id="perPage"
                v-model.number="localItemsPerPage"
                class="px-3 py-2 rounded border bg-slate-700 text-slate-200 border-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 hover:border-slate-500 transition cursor-pointer"
                @change="handleChange">
            <option :value="5">5</option>
            <option :value="10">10</option>
            <option :value="20">20</option>
            <option :value="50">50</option>
        </select>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    itemsPerPage: {
        type: Number,
        required: true
    },
    fetchSmartphones: {
        type: Function,
        required: true
    }
});

const emit = defineEmits(['update:itemsPerPage']);

const localItemsPerPage = ref(props.itemsPerPage);

function handleChange() {
    props.fetchSmartphones(1);
}

watch(localItemsPerPage, (newValue) => {
    emit('update:itemsPerPage', newValue);
});
</script>