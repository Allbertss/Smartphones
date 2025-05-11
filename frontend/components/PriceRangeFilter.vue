<template>
    <div>
        <h3 class="text-lg font-semibold mb-2">{{ label }}</h3>

        <USlider v-model="sliderValue"
                 color="info"
                 :min="min"
                 :max="max" />

        <div class="flex justify-between mt-2 text-sm text-slate-400">
            <div class="flex items-center">
                <input v-model.number="minInputValue"
                       type="number"
                       class="w-20 text-sm text-slate-400 bg-transparent border-b border-slate-400 appearance-none"
                       :min="min"
                       :max="sliderValue[1]"
                       @change="handleMinChange">
                <span class="ml-1 text-slate-400">{{ currency }}</span>
            </div>

            <div class="flex items-center">
                <input v-model.number="maxInputValue"
                       type="number"
                       class="w-20 text-sm text-slate-400 bg-transparent border-b border-slate-400 appearance-none"
                       :min="sliderValue[0]"
                       :max="max"
                       @change="handleMaxChange">
                <span class="ml-1 text-slate-400">{{ currency }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    modelValue: {
        type: Array,
        required: true,
    },
    min: {
        type: Number,
        required: true,
    },
    max: {
        type: Number,
        required: true,
    },
    label: {
        type: String,
        default: 'Price range',
    },
    currency: {
        type: String,
        default: 'PLN',
    }
});

const emit = defineEmits(['update:modelValue']);

const sliderValue = ref([props.min, props.max]);

const minInputValue = ref(props.min);
const maxInputValue = ref(props.max);

onMounted(() => {
    if (props.modelValue && props.modelValue.length === 2) {
        sliderValue.value = [...props.modelValue];

        minInputValue.value = props.modelValue[0];
        maxInputValue.value = props.modelValue[1];
    }
});

watch(() => props.modelValue, (newValue) => {
    if (newValue && newValue.length === 2) {
        if (sliderValue.value[0] !== newValue[0] || sliderValue.value[1] !== newValue[1]) {
            sliderValue.value = [...newValue];
        }

        if (minInputValue.value !== newValue[0]) {
            minInputValue.value = newValue[0];
        }

        if (maxInputValue.value !== newValue[1]) {
            maxInputValue.value = newValue[1];
        }
    }
}, { deep: true });

watch(sliderValue, (newValue) => {
    minInputValue.value = newValue[0];
    maxInputValue.value = newValue[1];

    emit('update:modelValue', [...newValue]);
}, { deep: true });

const handleMinChange = () => {
    if (minInputValue.value < props.min) {
        minInputValue.value = props.min;
    } else if (minInputValue.value > maxInputValue.value) {
        minInputValue.value = maxInputValue.value;
    }

    if (sliderValue.value[0] !== minInputValue.value) {
        sliderValue.value = [minInputValue.value, sliderValue.value[1]];
    }
};

const handleMaxChange = () => {
    if (maxInputValue.value > props.max) {
        maxInputValue.value = props.max;
    } else if (maxInputValue.value < minInputValue.value) {
        maxInputValue.value = minInputValue.value;
    }

    if (sliderValue.value[1] !== maxInputValue.value) {
        sliderValue.value = [sliderValue.value[0], maxInputValue.value];
    }
};
</script>