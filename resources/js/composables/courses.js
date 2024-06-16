import { ref, inject } from 'vue'
import {useRouter} from 'vue-router'
import {data} from "autoprefixer";

export default function useCourses() {
    // const courses = ref([])
    const courses = ref([])
    const coursesPaginated = ref({})
    const course = ref({})


    const getCoursesPaginated = async (page = 1, query = '') => {
        axios.get('/api/courses',{
            params: {
                page,
                search: query
            }})
            .then(response => {
                console.log('getCourses')
                console.log(response.data)
                coursesPaginated.value = response.data;
            })
    }

    const getAvailableCoursesForStudent= async (studentId) => {
        axios.get('/api/courses/available-for-student/' + studentId)
            .then(response => {
                console.log('getAvailableCoursesForStudent')
                console.log(response.data.data)
                courses.value = response.data.data;
            })
    }

    const getCourse = async (id) => {
        axios.get('/api/courses/' + id)
            .then(response => {
                console.log('getCourse')
                console.log(response.data.data)
                course.value = response.data.data;
            })
    }




    return {
        courses,
        getAvailableCoursesForStudent,
        course,
        getCourse,
        coursesPaginated,
        getCoursesPaginated,
    }
}
