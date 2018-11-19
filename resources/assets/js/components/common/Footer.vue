<template>
  <v-footer height="126px" app>
    <v-subheader>&nbsp;&copy;&nbsp;2018.&nbsp;{{ $t('messages.rights_message') }}.</v-subheader>
    <v-spacer></v-spacer>
    <v-layout row wrap>
      <v-flex style="margin-right:30px;">
        <v-autocomplete :label="$t('messages.choose_your_language')"
          :items="availableLocales"
          item-text="name"
          item-value="code"
          v-model="localizationState">
        </v-autocomplete>
      </v-flex>
      <v-flex>
        <v-autocomplete :label="$t('messages.choose_your_currency')"
          :items="availableCurrencies"
          item-text="name"
          item-value="code"
          v-model="currencyState">
        </v-autocomplete>
      </v-flex>
    </v-layout>
  </v-footer>
</template>

<script>
import localemanager from '../../plugins/localemanager';
import currencymanager from '../../plugins/currencymanager';

export default {
  data: () => ({
    availableLocales: localemanager.localeCodes,
    localizationState: localemanager.getSystemLocale(),
    availableCurrencies: currencymanager.currencyCodes,
    currencyState: currencymanager.getSystemCurrency()
  }),
  watch: {
    localizationState: function (v) {
      localemanager.setSystemLocale(v);
      this.$i18n.locale = localemanager.getSystemLocale();
    },
    currencyState: function (v) {
      currencymanager.setSystemCurrency(v);
    }
  }
}
</script>
