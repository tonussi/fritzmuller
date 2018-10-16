import Login from '../pages/auth/login.vue';
import Register from '../pages/auth/register.vue';
import PasswordEmail from '../pages/auth/password/email.vue';
import PasswordReset from '../pages/auth/password/reset.vue';
import NotFound from '../pages/errors/404.vue';
import Settings from '../pages/settings/index.vue';
import SettingsProfile from '../pages/settings/profile.vue';
import SettingsPassword from '../pages/settings/password.vue';

/**
 * Vue Imports Admin Session
 */
import AdminProjectsIndex from '../components/admin/projects/AdminProjectsIndex.vue';
import GuestProjectsIndex from '../components/guest/projects/GuestProjectsIndex.vue';

import AdminMembersIndex from '../components/admin/projects/AdminMembersIndex.vue';
import GuestMembersIndex from '../components/guest/projects/GuestMembersIndex.vue';

import AdminArticlesIndex from '../components/admin/articles/AdminArticlesIndex.vue';
import GuestArticlesIndex from '../components/guest/articles/GuestArticlesIndex.vue';
import GuestReadArticleIndex from '../components/guest/articles/GuestReadArticleIndex.vue';

import AdminSpeciesDetailIndex from '../components/admin/species/AdminSpeciesDetailIndex.vue';
import AdminTaxonomyGroupIndex from '../components/admin/species/AdminTaxonomyGroupIndex.vue';

import AdminMerchandiseIndex from '../components/admin/merchandise/AdminMerchandiseIndex.vue';

import GuestWelcomeIndex from '../components/guest/welcome/GuestWelcomeIndex.vue';

export default [
  { path: '/admin/articles', name: 'adminArticlesIndex', component: AdminArticlesIndex },
  { path: '/guest/articles', name: 'guestArticlesIndex', component: GuestArticlesIndex },
  { path: '/guest/articles/read/:id', name: 'guestReadArticleIndex', component: GuestReadArticleIndex },
  { path: '/admin/species', name: 'adminSpeciesDetailIndex', component: AdminSpeciesDetailIndex },
  { path: '/admin/species/taxonomy', name: 'adminTaxonomyGroupIndex', component: AdminTaxonomyGroupIndex },
  { path: '/admin/merchandise', name: 'merchandiseIndex', component: AdminMerchandiseIndex },
  { path: '/admin/projects', name: 'adminProjectsIndex', component: AdminProjectsIndex },
  { path: '/admin/members', name: 'adminMembersIndex', component: AdminMembersIndex },
  { path: '/guest/projects', name: 'guestProjectsIndex', component: GuestProjectsIndex },
  { path: '/guest/members', name: 'guestMembersIndex', component: GuestMembersIndex },

  { path: '/', name: 'guestWelcomeIndex', component: GuestWelcomeIndex },

  { path: '/login', name: 'login', component: Login },
  { path: '/logout', name: 'logout' },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword }
    ] },

  { path: '*', component: NotFound }
]
