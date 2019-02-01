<template>
    <v-card style="margin:160px 60px 10px 60px;">
      <v-layout column wrap align-center>
        <v-flex>
          <div class="text-xs-center">
            <h1>{{ $t('messages.members') }}</h1>
          </div>
        </v-flex>
      </v-layout>
      <v-layout>
        <v-flex>
          <v-container grid-list-sm>
            <v-layout wrap>
              <v-flex x6 ma-3 v-for="member in members" :key="member.member_name">
                <v-card>
                  <v-layout row wrap>
                    <v-flex xs6>
                      <v-img :src="member.figure_path"></v-img>
                    </v-flex>
                    <v-flex xs6>
                      <v-card-title primary-title>
                        <h3 class="green--text" v-text="member.member_name"></h3>
                      </v-card-title>
                    </v-flex>
                    <v-flex xs6 ma-3>
                      <label><b>{{ $t("member.name") }}</b></label>
                      <p>{{ member.member_name }}</p>
                      <label><b>{{ $t("member.grad") }}</b></label>
                      <p>{{ member.grad }}</p>
                      <label><b>{{ $t("member.bio") }}</b></label>
                      <p v-html="member.member_description"></p>
                    </v-flex>
                  </v-layout>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-flex>
      </v-layout>
    </v-card>

</template>

<script>
export default {
  data () {
    return {
      members: []
    }
  },

  created () {
    this.initialize();
  },

  beforeDestroy () {
    clearInterval(this.interval)
  },

  methods: {
    initialize() {
      var app = this;
      axios.get('/api/v1/members').then(function(resp) {
        app.members = resp.data.data;
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.members'));
      });
    }
  }
}
</script>
