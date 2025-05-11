<template>
    <div v-if="options.length">
        <h3 class="text-lg font-semibold mb-2">{{ label }}</h3>
        <select class="w-full p-2 border rounded bg-slate-700 text-slate-200"
                multiple
                @change="onChange">
            <option v-for="option in options"
                    :key="option"
                    :value="option"
                    :selected="modelValue.includes(option)">
                {{ option }}
            </option>
        </select>
    </div>
</template>

<script setup>
const props = defineProps({
    label: String,
    options: {
        type: Array,
        default: () => []
    },
    modelValue: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['update:modelValue']);

function onChange(event) {
    const selected = Array.from(event.target.selectedOptions).map(opt => opt.value);

    emit('update:modelValue', selected);
}
</script>