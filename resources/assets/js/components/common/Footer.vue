<template>
  <v-footer height="86px" app>
    <v-subheader>&nbsp;&copy;&nbsp;2018.&nbsp;{{ $t('messages.rights_message') }}.</v-subheader>
    <v-spacer></v-spacer>
    <v-flex style="margin-right:30px;">
      <v-autocomplete :label="$t('messages.choose_your_language')"
        :items="availableLocales"
        item-text="name"
        item-value="label"
        v-model="localizationState">
      </v-autocomplete>
    </v-flex>
  </v-footer>
</template>

<script>
export default {
  data: () => ({
    availableLocales: [
      { label: 'en', name: 'EUA English' },
      { label: 'pt-br', name: 'Português Brasileiro' }
    ],
    localizationState: ''
  }),
  watch: {
    localizationState: function (v) {
      this.setLocaleCookie(v);
    }
  },
  methods: {
    setLocaleCookie(v) {
      if (v != this.autoAppLang) {
        this.autoAppLang = v;
        console.log(localStorage.getItem('locale'));
        localStorage.setItem('locale', v);
        this.$i18n.locale = localStorage.getItem('locale');
        this.$vuetify.lang.current = this.$i18n.locale;
      }
    }
  }
}
</script>
