<template>
  <section>

    <carousel :per-page="1" :speed="9000" :mouseDrag="true" :autoplay="true">
      <slide v-for="(item, idx) in cards" :key="idx">
        <v-img :id="'merchan_img_id__' + idx" :ref="'merchan_img__' + idx" height="600" :src="item.figure_path">
          <v-container grid-list-xl text-xs-center>
              <v-layout row wrap>
                <v-card-text style="margin-top: 120px;">
                  <h1 class="white--text front-text-header">{{item.title}}</h1>
                  <p class="white--text front-text-paragraph">{{item.activity_description}}</p>
                  <v-btn large color="green lighten-3" :to="{ path: item.target_url }">
                    {{ $t("messages.explore") }}
                    <v-spacer></v-spacer>
                  </v-btn>
                </v-card-text>
              </v-layout>
          </v-container>
        </v-img>
      </slide>
    </carousel>

    <v-card style="margin:160px 60px 10px 60px;">
      <v-layout row align-center>
        <v-flex xs12>
          <div style="margin-top:60px" class="text-xs-center">
            <h2 class="headline">{{ $t('messages.posts') }}</h2>
          </div>
        </v-flex>
      </v-layout>
      <v-layout row align-center>
        <v-flex xs12>
          <v-container grid-list-sm>
            <v-layout row wrap>
              <v-flex
                v-bind="{ [`xs${post.flex}`]: true }"
                v-for="(post, idx) in posts"
                :key="post.title + '__n_' + idx">
                <v-card>
                  <v-layout row wrap>
                    <v-flex xs6>
                      <v-img :src="post.figure_path" height="20vh"></v-img>
                    </v-flex>
                    <v-flex xs6>
                      <v-card-title primary-title>
                        <h2 class="headline" v-text="post.title"></h2><br/>
                        <p class="grey--text">{{ post.subtitle }}</p><br/>
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
                    {{ $t("messages.donate") }}
                    <v-btn icon @click.native="post.show = !post.show">
                      <v-icon>{{ post.show ? 'keyboard_arrow_down' : 'keyboard_arrow_up' }}</v-icon>
                    </v-btn>
                  </v-card-actions>
                  <v-slide-y-transition>
                    <span v-show="post.show">
                      <v-btn flat color="blue">
                        {{ 1 | fmtcurrency }}
                      </v-btn>
                    </span>
                  </v-slide-y-transition>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-flex>
      </v-layout>
      <v-layout column wrap align-center>
        <v-flex xs12 sm4>
          <div class="text-xs-center">
            <v-btn block color="teal lighten-3" @click="loadMore()">{{ $t("article.loadmore") }}</v-btn>
          </div>
        </v-flex>
      </v-layout>
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
      howManyMore: 15
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
      }).catch(function(resp) {
        alert("Could not load Running Actitivies!");
      });
      axios.get('/api/v1/articles/newest/' + this.howManyMore).then(function(resp) {
        app.posts = resp.data;
      }).catch(function(resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.articles'));
      });
    },
    loadMore() {
      var app = this;
      this.howManyMore = this.howManyMore + 5;
      axios.get('/api/v1/articles/newest/' + this.howManyMore).then(function(resp) {
        app.posts = resp.data;
      }).catch(function(resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.articles'));
      });
    }
  }
}
</script>
