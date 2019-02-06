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
import GuestArticleSearchIndex from '../components/guest/articles/GuestArticleSearchIndex.vue';
import GuestSpecieSearchIndex from '../components/guest/articles/GuestSpecieSearchIndex.vue';

import GuestReadArticleIndex from '../components/guest/articles/GuestReadArticleIndex.vue';

import AdminSpecieDetailIndex from '../components/admin/species/AdminSpecieDetailIndex.vue';
import AdminTaxonomyGroupIndex from '../components/admin/species/AdminTaxonomyGroupIndex.vue';

import AdminMerchandiseIndex from '../components/admin/merchandise/AdminMerchandiseIndex.vue';

import AdminTicketsIndex from '../components/admin/tickets/AdminTicketsIndex.vue';

import GuestWelcomeIndex from '../components/guest/welcome/GuestWelcomeIndex.vue';

import GuestReadSpecieIndex from '../components/guest/species/GuestReadSpecieIndex.vue';

export default [
  { path: '/admin/tickets', name: 'adminTicketsIndex', component: AdminTicketsIndex },
  { path: '/admin/articles', name: 'adminArticlesIndex', component: AdminArticlesIndex },
  { path: '/admin/species', name: 'adminSpecieDetailIndex', component: AdminSpecieDetailIndex },
  { path: '/admin/taxonomy', name: 'adminTaxonomyGroupIndex', component: AdminTaxonomyGroupIndex },
  { path: '/admin/merchandise', name: 'adminMerchandiseIndex', component: AdminMerchandiseIndex },
  { path: '/admin/projects', name: 'adminProjectsIndex', component: AdminProjectsIndex },
  { path: '/admin/members', name: 'adminMembersIndex', component: AdminMembersIndex },

  { path: '/guest/articles', name: 'guestArticleSearchIndex', component: GuestArticleSearchIndex },
  { path: '/guest/species', name: 'guestSpecieSearchIndex', component: GuestSpecieSearchIndex },
  { path: '/guest/articles/read/:id', name: 'guestReadArticleIndex', component: GuestReadArticleIndex },
  { path: '/guest/projects', name: 'guestProjectsIndex', component: GuestProjectsIndex },
  { path: '/guest/members', name: 'guestMembersIndex', component: GuestMembersIndex },
  { path: '/guest/species/read/:id', name: 'guestReadSpecieIndex', component: GuestReadSpecieIndex },

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
