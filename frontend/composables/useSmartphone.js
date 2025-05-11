export function useSmartphones() {
    async function getSmartphones(
        page = 1,
        itemsPerPage = 10,
        sortBy = 'price',
        sortOrder = 'asc',
        uniqueIdentifier = '',
        filters = null
    ) {
        try {
            const params = new URLSearchParams();

            params.append('page', page);
            params.append('itemsPerPage', itemsPerPage);
            params.append(`order[${sortBy}]`, sortOrder);

            if (uniqueIdentifier) {
                params.append('uniqueIdentifier', uniqueIdentifier);
            }

            if (filters) {
                if (filters.categories && filters.categories.length > 0) {
                    filters.categories.forEach(category => {
                        params.append('category[]', category);
                    });
                }

                if (filters.brands && filters.brands.length > 0) {
                    filters.brands.forEach(brand => {
                        params.append('brand[]', brand);
                    });
                }

                if (filters.models && filters.models.length > 0) {
                    filters.models.forEach(model => {
                        params.append('model[]', model);
                    });
                }

                if (filters.grades && filters.grades.length > 0) {
                    filters.grades.forEach(grade => {
                        params.append('grade[]', grade);
                    });
                }

                if (filters.conditions && filters.conditions.length > 0) {
                    filters.conditions.forEach(condition => {
                        params.append('condition[]', condition);
                    });
                }

                if (filters.priceRange && Array.isArray(filters.priceRange) && filters.priceRange.length === 2) {
                    params.append('price[gte]', Math.floor(filters.priceRange[0] * 100));
                    params.append('price[lte]', Math.floor(filters.priceRange[1] * 100));
                }
            }

            const response = await fetch(`http://localhost:8000/api/smartphones?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/ld+json',
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Error fetching smartphones:', error);

            throw error;
        }
    }

    return {
        getSmartphones,
    };
}