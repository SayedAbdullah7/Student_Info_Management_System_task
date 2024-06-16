
import { ref } from 'vue'

export default function useLevels() {
    // const levels = ref({})
    const levels = ref([]);

    const getLevels = async () => {
        axios.get('/api/levels')
            .then(response => {
                console.log('getLevels',response.data)
                levels.value = response.data.data;
            })
    }

    return { levels, getLevels }
}
