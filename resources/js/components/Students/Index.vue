<template>
    <TableComponent :headers="headers" :data="studentsPaginated.data" :loading="loading">
        <template #toolbar>
            <div class="flex justify-end w-full my-3">
                    <router-link :to="{ name: 'students.create' }" >
                        <button type="button"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Add Student
                        </button>
                    </router-link>
            </div>
            <div class="w-1/3">
                <form class="max-w-sm mx-auto">
                    <label for="levels" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                    <select v-model="selectedLevel" id="levels"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected> Filter by level</option>
                        <option v-for="level in levels" :value="level.id" :key="level.id">
                            {{ level.name }}
                        </option>
                    </select>
                </form>
            </div>

            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div
                    class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                              clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input v-model="searchQuery" @input="handleSearch" type="text" id="table-search"
                       class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Search for items">
            </div>
        </template>

        <template #actions="{ row }">
            <td class="font-medium hover:underline">
                <router-link class="text-blue-600 dark:text-blue-500" :to="{ name: 'students.edit', params: { id: row.id } }">Edit</router-link>
                <a href="#" @click.prevent="deleteStudent(row.id)" class="ml-2 text-red-600 dark:text-red-500">Delete</a>
            </td>
        </template>

        <template #pagination>
            <TailwindPagination :data="studentsPaginated"
                                @pagination-change-page="page => getStudentsPaginated(page, selectedLevel)"
                                class="mt-4"/>
        </template>

        <template #empty>
            <p>No students found.</p>
        </template>
    </TableComponent>
</template>

<script setup>
import {onMounted, ref, watch} from "vue";
import {TailwindPagination} from 'laravel-vue-pagination';
import useStudents from "@/composables/students.js";
import useLevels from "@/composables/levels";
import TableComponent from "@/components/TableComponent.vue";

const headers = [
    {key: 'id', label: 'ID'},
    {key: 'full_name', label: 'Full Name'},
    {key: 'code', label: 'Code'},
    {key: 'email', label: 'Email'},
    {key: 'level.name', label: 'Level'},
    {key: 'date_of_birth', label: 'Date of Birth'},
    {key: 'created_at', label: 'Created at'},

]

const searchQuery = ref('');
const loading = ref(false);

const handleSearch = () => {
    getStudentsPaginated(1, selectedLevel.value, searchQuery.value);
};

const selectedLevel = ref('');
const {students, getStudents, studentsPaginated, getStudentsPaginated, deleteStudent} = useStudents();
const {levels, getLevels} = useLevels();

onMounted(() => {
    getStudentsPaginated();
    getLevels();
});
watch(selectedLevel, (current, previous) => {
    getStudentsPaginated(1, current, searchQuery.value);
});
</script>
