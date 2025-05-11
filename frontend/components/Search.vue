<template>
    <div class="w-full md:w-auto">
        <div class="relative w-full max-w-sm min-w-[200px]">
            <input v-model="searchQuery"
                   class="w-full h-10 pl-3 pr-11 rounded border bg-slate-700 text-slate-200 placeholder-slate-400 border-slate-600 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 hover:border-slate-500 transition shadow-sm"
                   placeholder="Unique identifier..."
                   @keyup.enter="handleSearch">
            <button class="absolute top-1 right-1 h-8 w-8 flex items-center justify-center rounded bg-slate-600 hover:bg-slate-500 transition cursor-pointer"
                    type="button"
                    @click="handleSearch">
                <SearchIcon />
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import SearchIcon from './svgs/SearchIcon.vue';

const props = defineProps({
    onSearch: {
        type: Function,
        required: true
    }
});

const searchQuery = ref('');

function handleSearch() {
    if (searchQuery.value.trim()) {
        props.onSearch(searchQuery.value.trim());
    }
}
</script>