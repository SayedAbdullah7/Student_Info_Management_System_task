import './bootstrap';

// import Alpine from 'alpinejs';
//
// window.Alpine = Alpine;
//
// Alpine.start();
import {createApp, onMounted} from 'vue'
// import { createRouter, createWebHistory } from 'vue-router'
// import App from './layouts/App.vue'

// import PostsIndex from './components/Posts/Index.vue'
// import PostsCreate from './components/Posts/Create.vue'

// createApp({})
//     .component('PostsIndex', PostsIndex)
//     .mount('#app')

import router from './routes/index'
import VueSweetalert2 from 'vue-sweetalert2';
import useAuth from './composables/auth';
import 'flowbite';

// createApp(App)
createApp({
    setup() {
        const {getUser} = useAuth()
        onMounted(getUser)
    }
})

    .use(router)
    .use(VueSweetalert2)
    .mount('#app')
