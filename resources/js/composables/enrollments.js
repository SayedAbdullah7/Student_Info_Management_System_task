import { ref, inject } from 'vue'
import {useRouter,useRoute} from "vue-router";


export default function useEnrollments() {
    const enrollments = ref({})
    const gradeItems = ref({})
    const router = useRouter()
    const route = useRoute()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getEnrollments = async (id, page = 1, query = '') => {
        axios.get(`/api/enrollments/${id}`, {
            params: {
                page,
                search: query
            }
        }).then(response => {
            console.log('getCourseStudents');
            console.log(response.data);
            enrollments.value = response.data;
        });
    };


    const getGradeItems = async () => {
        axios.get('/api/grade-items')
            .then(response => {
                console.log('getGradeItems')
                console.log(response.data.data)
                gradeItems.value = response.data.data;
            })
    }
    const deleteEnrollment = async (id) => {
        swal({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this action!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.delete('/api/enrollments/' + id)
                        .then(response => {
                            getEnrollments(route.params.id)
                            swal({
                                icon: 'success',
                                title: 'enrollment deleted successfully',
                            })
                        })
                        .catch(error => {
                            console.log(error)
                            swal({
                                icon: 'error',
                                title: 'Something went wrong'
                            })
                        })
                }
            })
    }

    const storeEnrollment = async (enrollment) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        axios.post('/api/enrollments', enrollment)
            .then(response => {
                router.push({name: 'enrolments.index', params: {id: enrollment.course_id}})
                console.log(response)
                swal({
                    icon: 'success',
                    title: 'Enrolment saved successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    console.log(error.response.data)
                    validationErrors.value = error.response.data.errors
                    isLoading.value = false
                }
            })
    }

    return {
        enrollments,
        getEnrollments,
        gradeItems,
        getGradeItems,
        deleteEnrollment,
        storeEnrollment,
        validationErrors,
        isLoading
    }
}
