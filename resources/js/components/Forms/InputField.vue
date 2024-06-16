<template>
    <div>
        <label :for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ label }}
        </label>
        <component
            :is="tag"
            :id="id"
            :type="type"
            :value="modelValue"
            @input="updateValue($event.target.value)"
            v-bind="attrs"
            :class="inputClass"
        />
        <div class="text-red-600 mt-1">
            <div v-for="message in validationErrors" :key="message">
                {{ message }}
            </div>
        </div>
    </div>
</template>

<script setup>
import {computed, toRefs} from 'vue';

const props = defineProps({
    modelValue: [String, Number, File],
    label: String,
    id: String,
    tag: {
        type: String,
        default: 'input'
    },
    validationErrors: Array,
    type: String
});

const emit = defineEmits(['update:modelValue']);

const {modelValue, id, tag, type, validationErrors, ...attrs} = toRefs(props);

const inputClass = computed(() => ({
    'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500': true
}));

const updateValue = (value) => {
    emit('update:modelValue', value);
};
</script>
