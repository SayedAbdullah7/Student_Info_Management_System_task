import { ref, reactive, inject } from 'vue'
import { useRouter } from 'vue-router';

const user = reactive({
    name: '',
    email: '',
})

export default function useAuth() {
    const processing = ref(false)
    const validationErrors = ref({})
    const router = useRouter()
    const swal = inject('$swal')
    const loginForm = reactive({
        email: '',
        password: '',
        remember: false
    })

    const submitLogin = async () => {
        console.log('submitLogin')
        if (processing.value) return
        console.log('line 23')
        processing.value = true
        validationErrors.value = {}

        axios.post('/login', loginForm)
            .then(async response => {
                console.log('login response')
                console.log(response)
                user.name = response.data.name
                user.email = response.data.email
                loginUser(response)
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => processing.value = false)
    }

    const loginUser = (response) => {
        user.name = response.data.name
        user.email = response.data.email

        localStorage.setItem('loggedIn', JSON.stringify(true))
        router.push({ name: 'students.index' })
    }

    const getUser = () => {
        axios.get('/api/user')
            .then(response => {
                loginUser(response)
            })
    }

    const logout = async () => {
        if (processing.value) return

        processing.value = true

        axios.post('/logout')
            .then(response => router.push({ name: 'login' }))
            .catch(error => {
                swal({
                    icon: 'error',
                    title: error.response.status,
                    text: error.response.statusText
                })
            })
            .finally(() => {
                processing.value = false
            })
    }

    return { loginForm, validationErrors, processing, submitLogin, user, getUser, logout }
}
