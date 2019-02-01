<template>
  <div>

    <v-toolbar fixed app>
      <v-toolbar-side-icon @click.stop="LeftDrawer = !LeftDrawer"></v-toolbar-side-icon>

      <v-menu open-on-hover offset-x>
        <v-btn slot="activator" icon>
          <v-icon>verified_user</v-icon>
        </v-btn>
        <v-list>
          <v-list-tile :to="{ name: 'adminTicketsIndex' }">
            <v-list-tile-title>{{ $t('admin.tickets_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'adminArticlesIndex' }">
            <v-list-tile-title>{{ $t('admin.articles_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'adminMerchandiseIndex' }">
            <v-list-tile-title>{{ $t('admin.activities_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'adminTaxonomyGroupIndex' }">
            <v-list-tile-title>{{ $t('admin.taxonomy_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'adminSpecieDetailIndex' }">
            <v-list-tile-title>{{ $t('admin.species_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'adminProjectsIndex' }">
            <v-list-tile-title>{{ $t('admin.projects_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'adminMembersIndex' }">
            <v-list-tile-title>{{ $t('admin.members_session') }}</v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-menu>

      <v-spacer></v-spacer>
      <v-toolbar-side-icon @click.stop="RightDrawer = !RightDrawer"></v-toolbar-side-icon>
    </v-toolbar>

    <v-navigation-drawer v-model="RightDrawer" fixed temporary right app>
      <v-list>
        <v-list-tile href="http://www.vlibras.gov.br/" target="_blank" :title="$t('messages.sign_language')">
          <v-list-tile-avatar>
            <v-icon>fas fa-sign-language</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('messages.sign_language') }}
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile :to="{ name: 'settings.profile' }" :title="$t('messages.profile')">
          <v-list-tile-avatar>
            <v-icon>fas fa-user</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('messages.profile') }}
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile href="https://fb.com/projetofritzmuller" target="_blank" title="Facebook">
          <v-list-tile-avatar>
            <v-icon>fab fa-facebook-square</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            Facebook
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile href="https://twitter.com/projetofritzmuller" target="_blank" title="Twitter">
          <v-list-tile-avatar>
            <v-icon>fab fa-twitter-square</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            Twitter
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile href="https://plus.google.com/projetofritzmuller" target="_blank" title="Google Plus">
          <v-list-tile-avatar>
            <v-icon>fab fa-google-plus-square</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            Google Plus
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile :to="{ name: 'login' }" :title="$t('auth.login')">
          <v-list-tile-avatar>
            <v-icon>fas fa-sign-in-alt</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('auth.login') }}
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile :to="{ name: 'logout' }" :title="$t('auth.logout')">
          <v-list-tile-avatar>
            <v-icon>fas fa-sign-out-alt</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('auth.logout') }}
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile :to="{ name: 'register' }" :title="$t('auth.register')">
          <v-list-tile-avatar>
            <v-icon>fas fa-user-plus</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('auth.register') }}
          </v-list-tile-content>
        </v-list-tile>

        <v-list-tile :title="$t('messages.nightmode')">
          <v-list-tile-avatar>
            <v-icon>fas fa-moon</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            <v-switch
              :label="$t('messages.nightmode')"
              v-model="NightMode">
            </v-switch>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>

    <v-navigation-drawer v-model="LeftDrawer" fixed temporary left app>
      <v-list>
        <v-list-tile :to="{ name: 'guestWelcomeIndex' }">
          <v-list-tile-avatar>
            <v-icon>home</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('messages.dashboard') }}
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'guestArticlesIndex' }">
          <v-list-tile-avatar>
            <v-icon>explore</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('messages.search_articles') }}
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'guestProjectsIndex' }">
          <v-list-tile-avatar>
            <v-icon>category</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('messages.projects') }}
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile :to="{ name: 'guestMembersIndex' }">
          <v-list-tile-avatar>
            <v-icon>people</v-icon>
          </v-list-tile-avatar>
          <v-list-tile-content>
            {{ $t('messages.team') }}
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>

  </div>
</template>

<script>
  export default {
    data: () => ({
      LeftDrawer: false,
      RightDrawer: false,
      NightMode: false
    }),

    watch: {
      NightMode (val) {
        this.$root.$emit("NightModeCangeMessage", val);
        console.log("Emit Information");
      }
    }
  }
</script>
