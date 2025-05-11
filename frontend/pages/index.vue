<template>
    <div class="container mx-auto">
        <LoadingSpinner v-if="isLoading" />

        <div v-if="error"
             class="w-[80%] mx-auto mt-4">
            <Error :error-message="error.message" />
        </div>

        <div v-else>
            <FiltersPanel v-show="isOpen"
                          :active-filters="activeFilters"
                          @apply-filters="handleFilterApply" />

            <div class="w-[80%] mx-auto my-10">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <ItemsPerPageSelector :items-per-page="itemsPerPage"
                                          :fetch-smartphones="fetchSmartphones"
                                          @update:items-per-page="itemsPerPage = $event" />

                    <FilterPanelButton :is-open="isOpen"
                                       @update:is-open="isOpen = $event" />

                    <Search :on-search="handleSearch" />
                </div>

                <Table :smartphones="smartphones"
                       :set-sort="setSort" />

                <Pagination :current-page="currentPage"
                            :total-pages="totalPages"
                            @update:current-page="fetchSmartphones" />

            </div>

        </div>
    </div>
</template>

<script setup>
import LoadingSpinner from '~/components/LoadingSpinner.vue';
import Pagination from '~/components/Pagination.vue';
import Table from '~/components/Table.vue';
import ItemsPerPageSelector from '~/components/ItemsPerPageSelector.vue';
import Error from '~/components/Error.vue';
import FiltersPanel from '~/components/FiltersPanel.vue';
import FilterPanelButton from '~/components/FilterPanelButton.vue';
import Search from '~/components/Search.vue';

import { useSmartphones } from '~/composables/useSmartphone';
import { computed, ref } from 'vue';

const { getSmartphones } = useSmartphones();

const currentPage = ref(1);
const itemsPerPage = ref(10);
const sortBy = ref('price');
const sortOrder = ref('asc');
const uniqueIdentifier = ref('');
const activeFilters = ref(null);

const data = ref(null);
const error = ref(null);
const isLoading = ref(false);

const isOpen = ref(false);

function setSort(field) {
    if (sortBy.value === field) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortBy.value = field;
        
        sortOrder.value = 'asc';
    }

    fetchSmartphones(1);
}

function handleSearch(query) {
    uniqueIdentifier.value = query;

    if (isOpen.value) {
        isOpen.value = false;
    }

    fetchSmartphones(1);
}

function handleFilterApply(filters) {
    activeFilters.value = filters;

    isOpen.value = false;

    fetchSmartphones(1);
}

async function fetchSmartphones(page) {
    isOpen.value = false;

    currentPage.value = page;
    isLoading.value = true;
    error.value = null;

    try {
        const result = await getSmartphones(
            currentPage.value,
            itemsPerPage.value,
            sortBy.value,
            sortOrder.value,
            uniqueIdentifier.value,
            activeFilters.value,
        );

        data.value = result;
    } catch (err) {
        error.value = err;

        console.error('Error fetching smartphones:', err);
    } finally {
        isLoading.value = false;
    }
}

onMounted(async () => {
    isLoading.value = true;

    try {
        await fetchSmartphones(currentPage.value);
    } finally {
        isLoading.value = false;
    }
});

const smartphones = computed(() => data.value?.['member'] || []);
const totalItems = computed(() => data.value?.['totalItems'] || 0);
const totalPages = computed(() => Math.ceil(totalItems.value / itemsPerPage.value));
</script>