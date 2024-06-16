<template>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex justify-end w-full my-3">
            <router-link :to="{ name: 'enrollments.create' }">
                <button type="button"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Add Enrollment
                </button>
            </router-link>
        </div>
        <div class="flex justify-between w-full my-3">
            <h6 class="text-lg font-bold dark:text-white ml-5">Course : {{ course.name }}</h6>
            <div class="pb-4 bg-white dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="table-search" v-model="searchQuery" @input="handleSearch"
                           class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Search for items">
                </div>
            </div>

        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                        ID

                </th>
                <th scope="col" class="px-6 py-3">Student Full Name</th>
                <th scope="col" class="px-6 py-3">Student Code</th>
                <th scope="col" class="px-6 py-3" v-for="item in gradeItems"> {{ item.name }} <br> (Max:
                    {{ item.max_degree }})
                </th>
                <th scope="col" class="px-6 py-3">Total</th>
                <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
            <tr v-for="enrollment in enrollments.data" :key="enrollment.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{ enrollment.id }}</td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{
                        enrollment.student.full_name
                    }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">{{
                        enrollment.student.code
                    }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900" v-for="item in gradeItems"
                    :key="item.id">{{ getGradeByItemId(enrollment, item.id) }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{
                        enrollment.grades_sum??'-'
                    }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    <a href="#" @click.prevent="deleteEnrollment(enrollment.id)"
                       class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</a>
                </td>
            </tr>
            </tbody>
        </table>
        <TailwindPagination :data="enrollments" @pagination-change-page="page => getEnrollments(route.params.id, page)"
                            class="mt-4"/>
    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
import {TailwindPagination} from 'laravel-vue-pagination';
import useEnrollments from '@/composables/enrollments';
import {useRoute} from 'vue-router';
import useCourses from "@/composables/courses.js";

const {enrollments, getEnrollments, gradeItems, getGradeItems, deleteEnrollment} = useEnrollments();
const {getCourse, course} = useCourses();
const route = useRoute();
const searchQuery = ref('');

const handleSearch = () => {
    getEnrollments(route.params.id, 1, searchQuery.value);
};

onMounted(() => {
    getEnrollments(route.params.id);
    getGradeItems();
    getCourse(route.params.id);
});

const getGradeByItemId = (enrollment, itemId) => {
    if (enrollment.grades) {
        const grade = enrollment.grades.find(g => g.grade_item_id === itemId);
        return grade ? grade.grade : '-';
    }
    return '-';
};

</script>
