import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

import Chat from '../components/Chat'
import Contact from '../components/Contact'

const router= new Router({
    routes: [
        {
            path: '/chat/:id',
            name: 'Chat',
            component: Chat
        },
        {
            path: '/',
            name: 'Contact',
            component: Contact
        }
    ]
})

export default router