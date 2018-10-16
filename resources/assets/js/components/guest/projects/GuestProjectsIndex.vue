<template>

    <v-card style="margin:160px 60px 10px 60px;">
      <v-layout column wrap align-center>
        <v-flex xs12 sm6 md4 class="my-3">
          <div class="text-xs-center">
            <h2 class="headline">{{ $t('messages.projects') }}</h2>
          </div>
        </v-flex>
      </v-layout>
      <v-layout>
        <v-flex>
          <v-container grid-list-sm>
            <v-layout wrap>
              <v-flex
                v-bind="{ [`xs${project.flex}`]: true }"
                v-for="project in projects"
                :key="project.project_name">
                <v-card>
                  <v-layout row wrap>
                    <v-flex xs6>
                      <v-img :src="project.figure_path" height="20vh"></v-img>
                    </v-flex>
                    <v-flex xs6>
                      <v-card-title primary-title>
                        <h3 class="green--text" v-text="project.project_name"></h3>
                      </v-card-title>
                    </v-flex>
                  </v-layout>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    {{ $t("project.moreinfo") }}
                    <v-btn icon @click.native="project.show = !project.show">
                      <v-icon>{{ project.show ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</v-icon>
                    </v-btn>
                  </v-card-actions>
                  <v-slide-y-transition>
                    <span v-show="project.show">
                      <label class="orange--text">{{ $t("project.description") }}</label>
                      <p class="grey--text" v-html="project.project_description"></p>
                      <label class="orange--text">{{ $t("project.created_at") }}</label>
                      <p class="grey--text">{{ project.created_at }}</p>
                      <label class="orange--text">{{ $t("project.updated_at") }}</label>
                      <p class="grey--text">{{ project.updated_at }}</p>
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
      projects: []
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
      axios.get('/api/v1/projects').then(function(resp) {
        app.projects = resp.data.data;
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.projects'));
      });
    }
  }
}
</script>
