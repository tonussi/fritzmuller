<template>
  <v-container grid-list-xl text-xs-center>
    <v-layout row wrap>
      <v-flex xs4 offset-xs4>
        <v-card-text ma-3 style="margin-top: 120px;">

          <div class="row">
            <div class="col-md-3">
              <card :title="$t('settings')" class="settings-card">
                <ul class="nav flex-column nav-pills">
                  <li v-for="tab in tabs" :key="tab.route" class="nav-item">
                    <router-link :to="{ name: tab.route }" class="nav-link" active-class="active">
                      <fa :icon="tab.icon" fixed-width/>
                      {{ tab.name }}
                    </router-link>
                  </li>
                </ul>
              </card>
            </div>

            <div class="col-md-9">
              <transition name="fade" mode="out-in">
                <router-view/>
              </transition>
            </div>
          </div>

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

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
