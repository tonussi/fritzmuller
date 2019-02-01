<template>
  <v-container>
    <v-layout>
      <v-flex>
        <v-card-text style="margin-top: 120px;">
          <card :title="$t('messages.settings')">
            <ul class="nav nav-pills">
              <li v-for="tab in tabs" :key="tab.route">
                <router-link :to="{ name: tab.route }" active-class="active">
                  <v-icon>fas fa-{{ tab.icon }}</v-icon>
                  {{ tab.name }}
                </router-link>
              </li>
            </ul>
          </card>
          <transition name="fade" mode="out-in">
            <router-view/>
          </transition>
        </v-card-text>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  middleware: 'auth',

  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('messages.profile'),
          route: 'settings.profile'
        },
        {
          icon: 'lock',
          name: this.$t('messages.password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>
