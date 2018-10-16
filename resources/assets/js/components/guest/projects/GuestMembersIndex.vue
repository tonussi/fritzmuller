<template>

    <v-card style="margin:160px 60px 10px 60px;">
      <v-layout column wrap align-center>
        <v-flex xs12 sm4 class="my-3">
          <div class="text-xs-center">
            <h2 class="headline">{{ $t('messages.members') }}</h2>
          </div>
        </v-flex>
      </v-layout>
      <v-layout>
        <v-flex>
          <v-container grid-list-sm>
            <v-layout wrap>
              <v-flex
                v-bind="{ [`xs${member.flex}`]: true }"
                v-for="member in members"
                :key="member.member_name">
                <v-card>
                  <v-layout row wrap>
                    <v-flex xs6>
                      <v-img :src="member.figure_path" height="20vh"></v-img>
                    </v-flex>
                    <v-flex xs6>
                      <v-card-title primary-title>
                        <h3 class="green--text" v-text="member.member_name"></h3>
                      </v-card-title>
                    </v-flex>
                  </v-layout>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    {{ $t("member.readmore") }}
                    <v-btn icon @click.native="member.show = !member.show">
                      <v-icon>{{ member.show ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</v-icon>
                    </v-btn>
                  </v-card-actions>
                  <v-slide-y-transition>
                      <span v-show="member.show">
                        <label class="orange--text">{{ $t("member.name") }}</label>
                        <p class="grey--text">{{ member.member_name }}</p>
                        <label class="orange--text">{{ $t("member.grad") }}</label>
                        <p class="grey--text">{{ member.grad }}</p>
                        <label class="orange--text">{{ $t("member.bio") }}</label>
                        <p class="grey--text" v-html="member.member_description"></p>
                      </span>
                  </v-slide-y-transition>
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
