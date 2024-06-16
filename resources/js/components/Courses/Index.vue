<template>


    <TableComponent :headers="headers" :data="coursesPaginated.data">
        <template #toolbar>
            <div class="flex justify-end w-full my-3">
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
                    <input v-model="searchQuery" @input="handleSearch"
                           type="text" id="table-search"
                           class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                           placeholder="Search for items">
                </div>
            </div>
        </template>

        <template #actions="{ row }">
            <router-link class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                         :to="{ name: 'enrolments.index', params: { id: row.id } }">Details
            </router-link>
            <!--            <a href="#" @click.prevent="deleteCourse(row.id)" class="ml-2">Delete</a>-->
        </template>

        <template #pagination>
            <TailwindPagination :data="coursesPaginated"
                                @pagination-change-page="page => getCoursesPaginated(page, selectedLevel)"
                                class="mt-4"/>
        </template>
    </TableComponent>

</template>
<script setup>
import {onMounted, ref, watch} from "vue";
import {TailwindPagination} from 'laravel-vue-pagination';
import useCourses from "@/composables/courses";
import useLevels from "@/composables/levels";
import TableComponent from '@/components/TableComponent.vue';


const selectedLevel = ref('')
const {courses, getCourses, coursesPaginated, getCoursesPaginated} = useCourses()
const {levels, getLevels} = useLevels()

const headers = [
    {key: 'id', label: 'ID'},
    {key: 'name', label: 'name'},
    {key: 'code', label: 'code'},
    {key: 'description', label: 'description'},
    {key: 'created_at', label: 'Created at'}
]
const searchQuery = ref('');
const handleSearch = () => {
    getCoursesPaginated(1, searchQuery.value);
};
onMounted(() => {
    getLevels()
    getCoursesPaginated()
})

watch(selectedLevel, (current) => {
    getCoursesPaginated(1, current)
})

</script>
