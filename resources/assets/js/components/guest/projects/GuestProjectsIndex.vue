<template>
    <v-card style="margin:160px 60px 10px 60px;">
      <v-layout column wrap align-center>
        <v-flex>
          <div class="text-xs-center">
            <h1>{{ $t('messages.projects') }}</h1>
          </div>
        </v-flex>
      </v-layout>
      <v-layout>
        <v-flex>
          <v-container grid-list-sm>
            <v-layout wrap>
              <v-flex x6 ma-3 v-for="project in projects" :key="project.project_name">
                <v-card>
                  <v-layout row wrap>
                    <v-flex xs6>
                      <v-img :src="project.figure_path"></v-img>
                    </v-flex>
                    <v-flex xs6>
                      <v-card-title primary-title>
                        <h3 class="green--text" v-text="project.project_name"></h3>
                      </v-card-title>
                    </v-flex>
                    <v-flex xs6 ma-3>
                      <label><b>{{ $t("project.description") }}</b></label>
                      <p v-html="project.project_description"></p>
                      <label><b>{{ $t("project.created_at") }}</b></label>
                      <p>{{ project.created_at | datei18n }}</p>
                      <label><b>{{ $t("project.updated_at") }}</b></label>
                      <p>{{ project.updated_at | datei18n }}</p>
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
