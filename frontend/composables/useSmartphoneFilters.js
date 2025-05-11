import { ref } from 'vue';

export const useSmartphoneFilters = () => {
    const filters = ref({
        brand: [],
        model: [],
        grade: [],
        category: [],
        condition: [],
        priceRange: {
            min: 0,
            max: 0,
        },
    });

    const isLoaded = ref(false);

    const loadFilters = async () => {
        if (isLoaded.value) {
            return;
        }

        const [brands, models, grades, categories, conditions, priceRange] = await Promise.all([
            $fetch('http://localhost:8000/api/smartphone/brands'),
            $fetch('http://localhost:8000/api/smartphone/models'),
            $fetch('http://localhost:8000/api/smartphone/grades'),
            $fetch('http://localhost:8000/api/smartphone/categories'),
            $fetch('http://localhost:8000/api/smartphone/conditions'),
            $fetch('http://localhost:8000/api/smartphone/price-range'),
        ]);

        filters.value.brand = brands || [];
        filters.value.model = models || [];
        filters.value.grade = grades || [];
        filters.value.category = categories || [];
        filters.value.condition = conditions || [];
        filters.value.priceRange.min = (priceRange?.min / 100) || 0;
        filters.value.priceRange.max = (priceRange?.max / 100) || 0;

        isLoaded.value = true;
    };

    return {
        filters,
        loadFilters,
    };
};
