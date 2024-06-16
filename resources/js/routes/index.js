
import { createRouter, createWebHistory } from 'vue-router';

import AuthenticatedLayout from '@/layouts/Authenticated.vue';
import GuestLayout from '@/layouts/Guest.vue';

import StudentsIndex from '@/components/Students/Index.vue'
import StudentsCreate from '@/components/Students/Create.vue'
import StudentsEdit from '@/components/Students/Edit.vue'
import CoursesIndex from '@/components/Courses/Index.vue'
import EnrollmentsIndex from '@/components/Enrollments/Index.vue'
import EnrollmentsCreate from '@/components/Enrollments/Create.vue'
import Login from '@/components/Auth/Login.vue';

const routes = [
    {
        path: '/',
        redirect: { name: 'login' },
        component: GuestLayout,
        children: [
            {
                path: '/login',
                name: 'login',
                component: Login
            },
        ]
    },
    {
        component: AuthenticatedLayout,
        // beforeEnter: auth,
        children: [
            {
                path: '/students',
                name: 'students.index',
                component: StudentsIndex,
                meta: { title: 'Students' }
            },
            {
                path: '/students/create',
                name: 'students.create',
                component: StudentsCreate,
                meta: { title: 'Add new student' }
            },
            {
                path: '/students/edit/:id',
                name: 'students.edit',
                component: StudentsEdit,
                meta: { title: 'Edit student' }
            },
            {
                path: '/courses',
                name: 'courses.index',
                component: CoursesIndex,
                meta: { title: 'Courses' }
            },
            {
                path: '/courses/:id/details',
                name: 'enrolments.index',
                component: EnrollmentsIndex,
                meta: { title: 'Courses' }
            },
            {
                path: '/enrollment/create',
                name: 'enrollments.create',
                component: EnrollmentsCreate,
                meta: { title: 'Add Enrollment' }
            },

        ]
    }
]


export default createRouter({
    history: createWebHistory(),
    routes
})
