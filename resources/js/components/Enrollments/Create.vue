<template>
    <form @submit.prevent="storeEnrollment(enrollment)">
        <!-- Student -->
        <div class="mt-4">
            <SelectField
                v-model="enrollment.student_id"
                id="enrollment-student_id"
                label="Student"
                :options="studentOptions"
                :validationErrors="validationErrors?.student_id"
            />
        </div>
        <div class="mt-4">
            <SelectField
                v-model="enrollment.course_id"
                id="enrollment-course_id"
                label="Course"
                :options="courseOptions"
                :validationErrors="validationErrors?.course_id"
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
        </div>
    </form>
</template>

<script setup>
import {onMounted, reactive, computed, watch} from 'vue';
import useLevels from '@/composables/levels.js';
import useStudents from '@/composables/students';
import InputField from "@/components/Forms/InputField.vue";
import SelectField from "@/components/Forms/SelectField.vue";
import useEnrollments from "@/composables/enrollments.js";
import useCourses from "@/composables/courses.js";

const enrollment = reactive({
    student_id: '',
    course_id: '',
})

const {students, getStudents} = useStudents()
const {courses, getCourses, getAvailableCoursesForStudent} = useCourses()
const {storeEnrollment, validationErrors, isLoading} = useEnrollments()

const studentOptions = computed(() => {
    return students.value.map(student => ({
        value: student.id,
        text: student.full_name
    }));
});
const courseOptions = computed(() => {
    return courses.value.map(course => ({
        value: course.id,
        text: course.name
    }));
});
onMounted(() => {
    getStudents()
    getAvailableCoursesForStudent(0)
})

watch(() => enrollment.student_id, (newValue, oldValue) => {
    getAvailableCoursesForStudent(newValue);
});

</script>
