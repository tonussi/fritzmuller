<template>
  <v-card style="padding-top:60px;">
    <v-container fluid grid-list-md>
      <v-card-text>
        <v-container fluid>
          <v-layout row wrap>
            <v-flex xs12 sm12>
              <v-text-field v-model="contentquery" type="text" :label="$t('messages.search_by_title_content')"></v-text-field>
            </v-flex>
            <v-flex xs12 sm12>
              <v-expansion-panel>
                <v-expansion-panel-content class="red lighten-3">
                  <div slot="header">
                    {{ $t('messages.search_by_species_taxanomy') }}
                  </div>
                  <v-card-text>
                    <v-checkbox v-model="byTaxanomy" :label="$t('messages.search_by_flora_taxonomy')"></v-checkbox>
                    <v-text-field v-model="taxonomyQuery.kingdom" type="text" :label="$t('species.search_by_taxa_kingdom')"></v-text-field>
                    <v-text-field v-model="taxonomyQuery.phylum" type="text" :label="$t('species.search_by_taxa_phylum')"></v-text-field>
                    <v-text-field v-model="taxonomyQuery.class" type="text" :label="$t('species.search_by_taxa_class')"></v-text-field>
                    <v-text-field v-model="taxonomyQuery.order" type="text" :label="$t('species.search_by_taxa_order')"></v-text-field>
                    <v-text-field v-model="taxonomyQuery.family" type="text" :label="$t('species.search_by_taxa_family')"></v-text-field>
                    <v-text-field v-model="taxonomyQuery.genus" type="text" :label="$t('species.search_by_taxa_genus')"></v-text-field>
                    <v-text-field v-model="taxonomyQuery.specie" type="text" :label="$t('species.search_by_taxa_specie')"></v-text-field>
                  </v-card-text>
                </v-expansion-panel-content>
                <v-expansion-panel-content class="blue lighten-3">
                  <div slot="header">
                    {{ $t('messages.search_between_dates') }}
                  </div>
                  <v-card-text>
                    <v-checkbox v-model="byPublicationDate" :label="$t('messages.search_between_dates')"></v-checkbox>
                    <v-dialog
                      ref="begin_publication_date_dialog"
                      persistent
                      v-model="begin_modal_date_check"
                      lazy
                      full-width
                      width="300px"
                      :return-value.sync="begin_publication_date">
                      <v-text-field
                        :label="$t('messages.begin_date_label')"
                        slot="activator"
                        v-model="begin_publication_date"
                        prepend-icon="event"
                        readonly>
                      </v-text-field>
                      <v-date-picker :locale="applocale" v-model="begin_publication_date" scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="begin_modal_date_check = false">{{ $t("messages.cancel") }}</v-btn>
                        <v-btn flat color="primary" @click="$refs.begin_publication_date_dialog.save(begin_publication_date)">{{ $t("messages.ok") }}</v-btn>
                      </v-date-picker>
                    </v-dialog>
                    <v-dialog
                      ref="end_publication_date_dialog"
                      persistent
                      v-model="end_modal_date_check"
                      lazy
                      full-width
                      width="300px"
                      :return-value.sync="end_publication_date">
                      <v-text-field
                        :label="$t('messages.end_date_label')"
                        slot="activator"
                        v-model="end_publication_date"
                        prepend-icon="event"
                        readonly>
                      </v-text-field>
                      <v-date-picker :locale="applocale" v-model="end_publication_date" scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="end_modal_date_check = false">{{ $t("messages.cancel") }}</v-btn>
                        <v-btn flat color="primary" @click="$refs.end_publication_date_dialog.save(end_publication_date)">{{ $t("messages.ok") }}</v-btn>
                      </v-date-picker>
                    </v-dialog>
                  </v-card-text>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-flex>
            <v-flex xs12 sm12>
              <v-btn block color="green lighten-3" @click="search()" prepend-icon="search">
                {{ $t("messages.execute_search") }}
                <v-spacer></v-spacer>
                <v-icon>search</v-icon>
              </v-btn>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card-text>
      <v-layout row wrap>
        <v-flex
          v-for="(card, i) in articles"
          :key="i">
          <v-card>
            <v-img
              :src="card.figure_path"
              height="200px">
            </v-img>
            <v-card-title primary-title>
              <div>
                <h2 class="headline" v-text="card.title"></h2>
                <p class="grey--text">{{ card.subtitle }}</p>
                <v-badge right color="cyan">
                  <v-icon :title="$t('messages.active_and_published')" slot="badge" dark small>done</v-icon>
                  <span>{{ card.publication_date }}</span>
                </v-badge>
              </div>
            </v-card-title>
            <v-card-actions>
              <v-btn flat color="cyan" :to="{ path: '/guest/articles/read/' + card.id }">{{ $t("article.readit") }}</v-btn>
              <v-spacer></v-spacer>
              {{ $t("article.shareit") }}
              <v-btn icon @click.native="card.show = !card.show">
                <v-icon>{{ card.show ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</v-icon>
              </v-btn>
            </v-card-actions>
            <v-slide-y-transition>
              <span v-show="card.show">
                <v-btn flat color="blue" :to="{ path: '/guest/articles/read/' + card.id }">{{ $t("article.shareit") }}</v-btn>
              </span>
            </v-slide-y-transition>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </v-card>
</template>

<script>
export default {
  data () {
    return {
      applocale: 'pt-br',
      articles: [],
      begin_date_label: this.$i18n.t('messages.begin_date_label'),
      end_date_label: this.$i18n.t('messages.end_date_label'),
      byTaxanomy: false,
      byPublicationDate: false,
      taxonomyQuery: {
        kingdom: '',
        phylum: '',
        class: '',
        order: '',
        family: '',
        genus: '',
        specie: ''
      },
      contentquery: '',
      dialog: false,
      begin_modal_date_check: false,
      begin_publication_date: undefined,
      end_modal_date_check: false,
      end_publication_date: undefined
    }
  },

  watch: {
    begin_modal_date_check() {
      this.whatsCurrentLocale();
    },
    end_modal_date_check() {
      this.whatsCurrentLocale();
    }
  },

  methods: {
    whatsCurrentLocale() {
      this.applocale = this.$i18n.locale;
    },

    initialize() {
      var app = this;
      axios.get('/api/v1/articles/newest/5').then(function(resp) {
        app.articles = resp.data;
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.articles'));
      });
    },

    search() {
      var app = this;
      // Clear the error message.
      this.error = '';
      // Empty the articles array so we can fill it with the new articles.
      this.articles = [];
      // Set the loading property to true, this will display the "Searching..." button.
      this.loading = true;
      // Making a get request to our API and passing the query to it.
      if (app.byPublicationDate && app.begin_publication_date !== undefined && app.end_publication_date !== undefined) {
        axios.get('/api/v1/articles/advanced/begindate/' + app.begin_publication_date + '/enddate/' + app.end_publication_date).then(function(resp) {
          app.articles = resp.data;
        }).catch(function(resp) {
          console.log(resp);
          alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.articles'));
        });
      } else {
        if (app.contentquery === '') {
          axios.get('/api/v1/articles/newest/5').then(function(resp) {
            app.articles = resp.data;
          }).catch(function(resp) {
            console.log(resp);
            alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.articles'));
          });
        } else {
          axios.get('/api/v1/search?q=' + this.contentquery).then(function(response) {
            // console.log(response);
            app.articles = response.data;
          }).catch(function(response) {
            console.log(response);
            alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.articles'));
          });
        }
      }
    }
  }
}
</script>
