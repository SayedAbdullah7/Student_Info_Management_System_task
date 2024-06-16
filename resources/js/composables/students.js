import {ref, inject} from 'vue'
import {useRouter} from 'vue-router'
import {data} from "autoprefixer";

export default function useStudents() {
    // const students = ref([])
    // const students = ref({})
    const studentsPaginated = ref({})
    const students = ref([])
    const allStudents = ref({})

    const student = ref({})
    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    // const getStudents = async () => {
    //     axios.get('/api/students')
    //         .then(response => {
    //             students.value = response.data;
    //         })
    // }
    // const getStudents = async (page = 1) => {
    //     axios.get('/api/students?page=' + page)
    const getStudents = async () => {
        axios.get('/api/students/all')
            .then(response => {
                console.log(response.data)
                students.value = response.data;
            })
    }
    const getStudentsPaginated = async (page = 1, level_id = '', query = '') => {
        axios.get('/api/students', {
            params: {
                page,
                level_id,
                search: query
            }
        })
            .then(response => {
                console.log(response.data)
                studentsPaginated.value = response.data;
            })
    }
    const getStudent = async (id) => {
        axios.get('/api/students/' + id)
            .then(response => {
                console.log('here')
                console.log(response.data)
                student.value = response.data;
            })
    }

    const storeStudent = async (student) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        axios.post('/api/students', student)
            .then(response => {
                console.log(response)
                router.push({name: 'students.index'})
                swal({
                    icon: 'success',
                    title: 'Student saved successfully'
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

    const updateStudent = async (student) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        axios.put('/api/students/' + student.id, student)
            .then(response => {
                router.push({name: 'students.index'})
                swal({
                    icon: 'success',
                    title: 'Student saved successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const deleteStudent = async (id) => {
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
                    axios.delete('/api/students/' + id)
                        .then(response => {
                            getStudentsPaginated()
                            // router.push({ name: 'students.index' })
                            swal({
                                icon: 'success',
                                title: 'Student deleted successfully'
                            })
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Something went wrong'
                            })
                        })
                }
            })
    }

    return {
        students,
        studentsPaginated,
        student,
        getStudents,
        getStudentsPaginated,
        getStudent,
        storeStudent,
        updateStudent,
        deleteStudent,
        validationErrors,
        isLoading
    }
}
