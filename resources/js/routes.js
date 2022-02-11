import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from './components/pages/Home';
import About from './components/pages/About';
import Contacts from './components/pages/Contacts';
import Posts from './components/pages/Posts';

Vue.use(VueRouter);

const router = new VueRouter({
   mode: 'history',
   linkActiveClass: 'active',
   routes: [
      {
         path: '/',
         name: 'home',
         component: Home
      },
      {
         path: '/about',
         name: 'about',
         component: About
      },
      {
         path: '/contacts',
         name: 'contacts',
         component: Contacts
      },
      {
         path: '/blog',
         name: 'blog',
         component: Posts
      }
   ]
});

export default router;