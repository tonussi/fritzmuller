<template>
  <v-container grid-list-xl text-xs-center>
    <v-layout row wrap>
      <v-flex xs4 offset-xs4>
        <v-card-text style="margin-top: 120px;">
          <card class="text-center">
            <h3 class="mb-4">{{ $t('messages.page_not_found') }}</h3>
            <div class="links">
              <v-btn color="cyan lighten-3" :to="{ name: 'guestWelcomeIndex' }">
                {{ $t('messages.go_home') }}
              </v-btn>
            </div>
          </card>
        </v-card-text>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
