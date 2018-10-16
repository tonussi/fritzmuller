<template>
  <v-card flat>

    <v-toolbar flat extended>
      <v-menu open-on-hover offset-x>
        <v-btn slot="activator" icon>
          <v-icon>verified_user</v-icon>
        </v-btn>
        <v-list>
          <v-list-tile :to="{ name: 'adminArticlesIndex' }">
            <v-list-tile-title>{{ $t('admin.articles_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'merchandiseIndex' }">
            <v-list-tile-title>{{ $t('admin.activities_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'adminTaxonomyGroupIndex' }">
            <v-list-tile-title>{{ $t('admin.taxonomy_session') }}</v-list-tile-title>
          </v-list-tile>
          <v-list-tile :to="{ name: 'adminSpeciesDetailIndex' }">
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

      <v-layout row align-center style="max-width: 650px"></v-layout>
      <v-spacer></v-spacer>

      <v-btn icon :title="$t('messages.sign_language')">
        <v-icon>fas fa-sign-language</v-icon>
      </v-btn>

      <v-btn icon :title="$t('messages.increase_font_size')">
        <v-icon>fas fa-plus</v-icon>
        <v-icon>fas fa-font</v-icon>
      </v-btn>

      <v-btn icon :title="$t('messages.decrease_font_size')">
        <v-icon>fas fa-minus</v-icon>
        <v-icon>fas fa-font</v-icon>
      </v-btn>

      <v-btn icon :title="$t('messages.turn_mode')">
        <v-icon>fas fa-adjust</v-icon>
      </v-btn>

      <v-btn icon :title="$t('messages.profile')">
        <v-icon>fas fa-user</v-icon>
      </v-btn>

      <v-btn icon href="https://fb.com/projetofritzmuller" target="_blank" title="Facebook">
        <v-icon>fab fa-facebook-square</v-icon>
      </v-btn>

      <v-btn icon href="https://twitter.com/projetofritzmuller" target="_blank" title="Twitter">
        <v-icon>fab fa-twitter-square</v-icon>
      </v-btn>

      <v-btn icon href="https://plus.google.com/projetofritzmuller" target="_blank" title="Google Plus">
        <v-icon>fab fa-google-plus-square</v-icon>
      </v-btn>

      <v-btn icon :to="{ name: 'login' }" :title="$t('auth.login')">
        <v-icon>fas fa-sign-in-alt</v-icon>
      </v-btn>

      <v-btn icon :to="{ name: 'logout' }" :title="$t('auth.logout')">
        <v-icon>fas fa-sign-out-alt</v-icon>
      </v-btn>

      <v-btn icon :to="{ name: 'register' }" :title="$t('auth.register')">
        <v-icon>fas fa-user-plus</v-icon>
      </v-btn>
    </v-toolbar>

    <v-layout row wrap>
      <v-flex xs12 sm8 offset-sm2 align-center justify-center>
        <v-card class="card--flex-toolbar" style="margin-top:-49px;position:absolute;z-index:1;padding:10px;">
          <v-toolbar card prominent>
            <v-list>
              <v-list-tile :to="{ name: 'guestWelcomeIndex' }">
                <v-list-tile-avatar>
                  <v-icon>home</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                  {{ $t('messages.dashboard') }}
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
            <v-list>
              <v-list-tile :to="{ name: 'guestArticlesIndex' }">
              <v-list-tile-avatar>
                <v-icon>explore</v-icon>
              </v-list-tile-avatar>
              <v-list-tile-content>
                {{ $t('messages.search_articles') }}
              </v-list-tile-content>
            </v-list-tile>
            </v-list>
            <v-list>
              <v-list-tile :to="{ name: 'guestProjectsIndex' }">
                <v-list-tile-avatar>
                  <v-icon>category</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                  {{ $t('messages.projects') }}
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
            <v-list>
              <v-list-tile :to="{ name: 'guestMembersIndex' }">
                <v-list-tile-avatar>
                  <v-icon>people</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                  {{ $t('messages.team') }}
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
          </v-toolbar>
        </v-card>
      </v-flex>
    </v-layout>
  </v-card>
</template>
