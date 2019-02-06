<template>
  <v-card style="padding-top:60px;">
    <v-container fluid grid-list-md>
      <v-card-text>
        <v-container fluid>

          <v-layout>

            <v-flex xs6>
              <v-text-field v-model="contentquery" type="text" :label="$t('messages.search_by_title_content')"></v-text-field>
            </v-flex>

            <v-flex xs6>
              <v-btn color="primary" large @click="search()" prepend-icon="search">
                <v-icon>search</v-icon>
                {{ $t("messages.execute_search") }}
              </v-btn>
            </v-flex>

          </v-layout>

          <v-layout>

            <v-flex xs6>
              <v-expansion-panel>
                <v-expansion-panel-content>
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
              </v-expansion-panel>
            </v-flex>
            <v-flex xs6>
              <v-expansion-panel>
                <v-expansion-panel-content>
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

          </v-layout>

        </v-container>
      </v-card-text>
      <v-content>
        <v-container fluid>
          <v-container class="px-0" fluid grid-list-md>
            <v-layout row wrap>
              <v-flex d-flex xs12 sm6 md3 v-for="(post, idx) in articles" :key="post.title + '__n_' + idx">
                <v-card>
                  <v-layout row wrap>
                    <v-flex xs6>
                      <v-img :src="post.figure_path" height="20vh"></v-img>
                    </v-flex>
                    <v-flex xs6>
                      <v-card-title primary-title>
                        <h2 class="headline" v-text="post.title"></h2>
                      </v-card-title>
                      <v-card-title>
                        <p class="grey--text">{{ post.subtitle }}</p>
                      </v-card-title>
                      <v-card-title>
                        <v-badge right color="cyan">
                          <v-icon :title="$t('messages.active_and_published')" slot="badge" small>done</v-icon>
                          <span>{{ post.publication_date | datei18n }}</span>
                        </v-badge>
                      </v-card-title>
                    </v-flex>
                  </v-layout>
                  <v-card-actions>
                    <v-btn flat color="cyan" :to="{ path: '/guest/articles/read/' + post.id }">
                      {{ $t("article.readit") }}
                    </v-btn>
                    <v-spacer></v-spacer>
                    <span>
                      {{ $t("messages.donate") }}
                      <v-btn flat color="blue">
                        {{ post.price | currencyi18n }}
                      </v-btn>
                    </span>
                  </v-card-actions>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-container>
      </v-content>
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
        });
      } else {
        if (app.contentquery == '') {
          axios.get('/api/v1/articles/newest/5').then(function(resp) {
            app.articles = resp.data;
          });
        } else {
          axios.get('/api/v1/articles/search/' + this.contentquery).then(function(response) {
            app.articles = response.data;
          });
        }
      }
    }
  }
}
</script>
