<template>
    <div class="max-w-[80%] mx-auto bg-slate-800 text-slate-300 p-4 space-y-4">
        <MultiSelectFilter label="Categories"
                           :options="filters.category"
                           v-model="selectedCategories" />

        <MultiSelectFilter label="Brands"
                           :options="filters.brand"
                           v-model="selectedBrands" />
        <MultiSelectFilter label="Models"
                           :options="filters.model"
                           v-model="selectedModels" />

        <MultiSelectFilter label="Grades"
                           :options="filters.grade"
                           v-model="selectedGrades" />

        <MultiSelectFilter label="Conditions"
                           :options="filters.condition"
                           v-model="selectedConditions" />

        <PriceRangeFilter v-if="priceRange[0] !== priceRange[1]"
                          v-model="selectedPriceRange"
                          :min="priceRange[0]"
                          :max="priceRange[1]"
                          currency="PLN" />

        <button @click="applyFilters"
                class="w-full bg-slate-700 text-slate-200 py-2 rounded mt-4 cursor-pointer hover:bg-slate-600 transition">
            Apply filters
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useSmartphoneFilters } from '@/composables/useSmartphoneFilters';
import MultiSelectFilter from './MultiSelectFilter.vue';
import PriceRangeFilter from './PriceRangeFilter.vue';

const props = defineProps({
    activeFilters: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['apply-filters']);

const { filters, loadFilters } = useSmartphoneFilters();

const priceRange = ref([0, 0]);
const selectedPriceRange = ref([0, 0]);

const selectedCategories = ref([]);
const selectedBrands = ref([]);
const selectedModels = ref([]);
const selectedGrades = ref([]);
const selectedConditions = ref([]);

const activeFiltersLocal = computed(() => ({
    categories: selectedCategories.value,
    brands: selectedBrands.value,
    models: selectedModels.value,
    grades: selectedGrades.value,
    conditions: selectedConditions.value,
    priceRange: selectedPriceRange.value
}));

function applyFilters() {
    emit('apply-filters', activeFiltersLocal.value);
}

onMounted(async () => {
    await loadFilters();

    if (filters.value.priceRange) {
        const min = filters.value.priceRange.min || 0;
        const max = filters.value.priceRange.max || 0;

        priceRange.value = [min, max];

        selectedPriceRange.value.splice(0, selectedPriceRange.value.length, ...(props.activeFilters?.priceRange || [min, max]));
    }

    if (props.activeFilters) {
        selectedCategories.value.splice(0, selectedCategories.value.length, ...(props.activeFilters.categories || []));
        selectedBrands.value.splice(0, selectedBrands.value.length, ...(props.activeFilters.brands || []));
        selectedModels.value.splice(0, selectedModels.value.length, ...(props.activeFilters.models || []));
        selectedGrades.value.splice(0, selectedGrades.value.length, ...(props.activeFilters.grades || []));
        selectedConditions.value.splice(0, selectedConditions.value.length, ...(props.activeFilters.conditions || []));
    }
});
</script>