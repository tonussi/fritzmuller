<template>
  <v-app>
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

  components: {
    MyToolBar,
    MyFooter
  }
}
</script>
