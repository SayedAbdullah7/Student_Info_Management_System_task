<template>
    <div>
        <label :for="id" class="block text-sm font-medium text-gray-700">
            {{ label }}
        </label>
        <select v-model="internalValue" :id="id" :class="inputClass">
            <option value="" disabled>-- Choose {{ label.toLowerCase() }} --</option>
            <option v-for="option in options" :key="option.value" :value="option.value">
                {{ option.text }}
            </option>
        </select>
        <div class="text-red-600 mt-1">
            <div v-for="message in validationErrors" :key="message">
                {{ message }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, toRefs, watch } from 'vue';

const props = defineProps({
    modelValue: [String, Number],
    label: String,
    id: String,
    options: {
        type: Array,
        required: true,
        default: () => []
    },
    validationErrors: Array
});

const emit = defineEmits(['update:modelValue']);
const { modelValue } = toRefs(props);

const internalValue = computed({
    get() {
        return modelValue.value;
    },
    set(value) {
        emit('update:modelValue', value);
    }
});

const inputClass = computed(() => ({
    'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50': true
}));
</script>
