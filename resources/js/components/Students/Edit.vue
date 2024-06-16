<template>
    <form @submit.prevent="updateStudent(student)">
        <!-- Title -->
        <div class="mt-4">
            <InputField
                v-model="student.full_name"
                id="student-full-name"
                label="Full name"
                :validationErrors="validationErrors?.full_name"
            />
        </div>


        <!-- code -->
        <div class="mt-4">
            <InputField
                v-model="student.code"
                id="student-code"
                label="Code"
                :validationErrors="validationErrors?.code"
            />
        </div>

        <!-- Level -->
        <div class="mt-4">
            <SelectField
                v-model="student.level_id"
                id="student-level_id"
                label="Level"
                :options="levelOptions"
                :validationErrors="validationErrors?.level_id"
            />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <InputField
                v-model="student.email"
                id="student-email"
                label="Email"
                type="email"
                :validationErrors="validationErrors?.email"
            />
        </div>

        <!-- Date of birth -->
        <div class="mt-4">
            <InputField
                v-model="student.date_of_birth"
                id="student-date_of_birth"
                label="Date of birth"
                type="date"
                :validationErrors="validationErrors?.date_of_birth"
            />
        </div>

        <!-- Buttons -->
        <div class="mt-4">
            <button :disabled="isLoading" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm uppercase text-white disabled:opacity-75 disabled:cursor-not-allowed">
                <span v-show="isLoading" class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Save</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { onMounted, computed } from 'vue';
import { useRoute } from 'vue-router';
import useLevels from '@/composables/levels.js';
import useStudents from '@/composables/students.js';
import InputField from '@/components/Forms/InputField.vue';
import SelectField from '@/components/Forms/SelectField.vue';

const { levels, getLevels } = useLevels();
const { student, getStudent, updateStudent, validationErrors, isLoading } = useStudents();
const route = useRoute();

const levelOptions = computed(() => {
    return levels.value.map(level => ({
        value: level.id,
        text: level.name
    }));
});

onMounted(() => {
    getStudent(route.params.id);
    getLevels();
});
</script>
