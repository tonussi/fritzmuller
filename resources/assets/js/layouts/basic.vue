<template>
  <v-app id="inspire">
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
  name: 'BasicLayout',

  components: {
    MyToolBar,
    MyFooter
  }
}
</script>

<style lang="scss">
.basic-layout {
  color: #636b6f;
  height: 100vh;
  font-weight: 100;
  position: relative;

  .links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
}
</style>
