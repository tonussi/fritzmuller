<template>
  <section>

    <carousel :per-page="1" :speed="1000" :mouseDrag="true" :autoplay="true">
      <slide v-for="(item, idx) in cards" :key="idx">
        <v-img :id="'merchan_img_id__' + idx" :ref="'merchan_img__' + idx" height="600" :src="item.figure_path">
          <v-container grid-list-xl text-xs-center>
              <v-layout row wrap>
                <v-card-text style="margin-top: 120px;">
                  <h1 class="white--text front-text-header">{{item.title}}</h1>
                  <p class="white--text front-text-paragraph">{{item.activity_description}}</p>
                  <v-btn color="blue lighten-3" :to="{ path: item.target_url }">
                    {{ $t("messages.explore") }}
                    <v-spacer></v-spacer>
                  </v-btn>
                </v-card-text>
              </v-layout>
          </v-container>
        </v-img>
      </slide>
    </carousel>

    <v-card class="m-4">
      <v-content>
        <v-layout row align-center>
          <v-flex xs12>
            <div style="margin-top:60px" class="text-xs-center">
              <h2 class="display-3 font-weight-light">{{ $t('messages.posts') }}</h2>
            </div>
          </v-flex>
        </v-layout>
        <v-container fluid grid-list-md>
          <v-layout row wrap>
            <v-flex d-flex xs12 sm6 md3 v-for="(post, idx) in posts" :key="'posts__n_' + idx">
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
          <v-layout column wrap align-center>
            <v-flex xs12 sm4>
              <div class="text-xs-center font-weight-light">
                <v-btn block color="blue lighten-3" @click="loadMoreArticles()">{{ $t("article.loadmore") }}</v-btn>
              </div>
            </v-flex>
          </v-layout>
        </v-container>
      </v-content>
      <v-content>
        <v-flex xs12>
          <div style="margin-top:60px" class="text-xs-center">
            <h2 class="display-3 font-weight-light">{{ $t('species.species_we_saw') }}</h2>
          </div>
        </v-flex>
        <v-container fluid grid-list-md>
          <v-layout row wrap>
            <v-flex d-flex xs12 sm6 md3 v-for="(specie_item, idx) in species" :key="'species__n_' + idx">
              <v-card>
                <v-layout row wrap>
                  <v-flex xs6>
                    <v-img :src="specie_item.figure_path" height="20vh"></v-img>
                  </v-flex>
                  <v-flex xs6>
                    <v-card-title primary-title>
                      <p v-if="taxonomy_group !== null"><b>{{ specie_item.taxonomy_group.taxonomy_rank_specie.rank_name }}</b></p>
                    </v-card-title>
                    <v-card-title>
                      <v-badge right color="orange">
                        <v-icon :title="$t('messages.active_and_published')" slot="badge" small>done</v-icon>
                        <span>{{ specie_item.created_at | datei18n }}</span>
                      </v-badge>
                    </v-card-title>
                  </v-flex>
                </v-layout>
                <v-card-actions>
                  <v-btn flat color="blue lighten-2" :to="{ path: '/guest/species/read/' + specie_item.id }">
                    {{ $t("article.readit") }}
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
          <v-layout column wrap align-center>
            <v-flex xs12 sm4>
              <div class="text-xs-center font-weight-light">
                <v-btn block color="blue lighten-3" @click="loadMoreSpecies()">{{ $t("species.loadmore") }}</v-btn>
              </div>
            </v-flex>
          </v-layout>
        </v-container>
      </v-content>
    </v-card>
  </section>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      cards: [],
      posts: [],
      species: [],
      howManyMoreArticles: 5,
      howManyMoreSpecies: 5
    }
  },

  created () {
    this.initialize();
  },

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  methods: {
    initialize() {
      var app = this;
      axios.get('/api/v1/merchandise/newest/15').then(function(resp) {
        app.cards = resp.data;
      });
      axios.get('/api/v1/articles/newest/' + this.howManyMoreArticles).then(function(resp) {
        app.posts = resp.data;
      });
      axios.get('/api/v1/species/newest/' + this.howManyMoreSpecies).then(function(resp) {
        app.species = resp.data;
        console.log(app.species);
      });
    },
    loadMoreArticles() {
      var app = this;
      this.howManyMoreArticles = this.howManyMoreArticles + 5;
      axios.get('/api/v1/articles/newest/' + this.howManyMoreArticles).then(function(resp) {
        app.posts = resp.data;
      });
    },
    loadMoreSpecies() {
      var app = this;
      this.howManyMoreSpecies = this.howManyMoreSpecies + 5;
      axios.get('/api/v1/species/newest/' + this.howManyMoreSpecies).then(function(resp) {
        app.species = resp.data;
      });
    }
  }
}
</script>
