<template>
    <form @submit.prevent="storeStudent(student)">

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
            <button :disabled="isLoading"
                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm uppercase text-white disabled:opacity-75 disabled:cursor-not-allowed">
                <span v-show="isLoading"
                      class="inline-block animate-spin w-4 h-4 mr-2 border-t-2 border-t-white border-r-2 border-r-white border-b-2 border-b-white border-l-2 border-l-blue-600 rounded-full"></span>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Save</span>
            </button>

            <!--            <InputField v-model="student.name" id="student-name" label="Title" :error="validationErrors?.title" inputClass="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />-->
            <!--            <InputField label="Title" v-model="student.title" type="text" :inputClass="inputClass" :errorMessage="validationErrors?.title" />-->
        </div>
    </form>
</template>

<script setup>
import {onMounted, reactive, computed} from 'vue';
import useLevels from '@/composables/levels.js';
import useStudents from '@/composables/students';
import InputField from "@/components/Forms/InputField.vue";
import SelectField from "@/components/Forms/SelectField.vue";

const student = reactive({
    name: '',
    title: '',
    content: '',
    level_id: '',
    thumbnail: ''
})

const {levels, getLevels} = useLevels()
const {storeStudent, validationErrors, isLoading} = useStudents()
const levelOptions = computed(() => {
    return levels.value.map(level => ({
        value: level.id,
        text: level.name
    }));
});
onMounted(() => {
    getLevels()
})
</script>
