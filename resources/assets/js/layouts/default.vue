<template>
  <v-app id="inspire" :dark="NightMode">
    <my-tool-bar/>
    <v-content>
      <child/>
    </v-content>
    <my-footer/>
  </v-app>
</template>

<script>
import MyToolBar from '../components/common/Navbar'
import MyFooter from '../components/common/Footer'

export default {
  name: 'MainLayout',

  data: () => ({
    NightMode: false
  }),

  components: {
    MyToolBar,
    MyFooter
  },

  mounted() {
    this.$root.$on("NightModeCangeMessage", (message) => {
      console.log('Receive emission');
      this.NightMode = message;
    });
  }
}
</script>
