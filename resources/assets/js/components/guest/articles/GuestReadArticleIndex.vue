<template>
  <div>
    <v-dialog v-model="taxonomy_dialog" width="500">
      <v-card>
        <v-card-text>
          <v-layout row>
            <v-flex xs4>
              <h3>{{ $t('taxonomy.kingdom') }}:</h3>
            </v-flex>
            <v-flex xs8>
              <p>{{ taxonomy_info_display.kingdom }}</p>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <h3>{{ $t('taxonomy.phylum') }}:</h3>
            </v-flex>
            <v-flex xs8>
              <p>{{ taxonomy_info_display.phylum }}</p>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <h3>{{ $t('taxonomy.class') }}:</h3>
            </v-flex>
            <v-flex xs8>
              <p>{{ taxonomy_info_display.class }}</p>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <h3>{{ $t('taxonomy.order') }}:</h3>
            </v-flex>
            <v-flex xs8>
              <p>{{ taxonomy_info_display.order }}</p>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <h3>{{ $t('taxonomy.family') }}:</h3>
            </v-flex>
            <v-flex xs8>
              <p>{{ taxonomy_info_display.family }}</p>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <h3>{{ $t('taxonomy.genus') }}:</h3>
            </v-flex>
            <v-flex xs8>
              <p>{{ taxonomy_info_display.genus }}</p>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <h3>{{ $t('taxonomy.species') }}:</h3>
            </v-flex>
            <v-flex xs8>
              <p>{{ taxonomy_info_display.specie }}</p>
            </v-flex>
          </v-layout>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat="flat" @click.native="taxonomy_dialog = false">
            <v-icon>fas fa-window-close</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
      <v-layout row justify-space-between>
        <v-flex xs12 align-end flexbox>
          <v-img :src="readableItem.figure_path" height="600px"></v-img>
        </v-flex>
      </v-layout>
      <v-layout row wrap justify-space-between>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.title") }}</v-subheader>
          <span class="article-header display-3">{{readableItem.title}}</span>
        </v-flex>
        <v-flex xs12 align-end flexbox>
          <v-subheader class="article-header">{{ $t("article.subtitle") }}</v-subheader>
          <h2>{{readableItem.subtitle}}</h2>
        </v-flex>
        <v-flex xs12 align-end flexbox>
          <v-subheader class="article-info">{{ $t("article.publication_date") }}</v-subheader>
          <h3>{{readableItem.publication_date | datei18n }}</h3>
          <!-- <v-date-picker :locale="applocale" v-model="readableItem.publication_date" readonly></v-date-picker> -->
        </v-flex>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.pdf_session") }}</v-subheader>
          <v-btn color="primary" @click="pdf(readableItem)">{{ $t("article.get_pdf") }}</v-btn>
        </v-flex>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.rating") }}</v-subheader>
          <v-rating v-model="readableItem.rating"></v-rating>
        </v-flex>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t('messages.increase_font_size') + ' or ' + $t('messages.decrease_font_size') }}</v-subheader>
          <v-btn @click="increaseFontSize('adjustfont', 1)" icon :title="$t('messages.increase_font_size')">
            <v-icon>fas fa-plus</v-icon>
            <v-icon>fas fa-font</v-icon>
          </v-btn>
          <v-btn @click="increaseFontSize('adjustfont', -1)" icon :title="$t('messages.decrease_font_size')">
            <v-icon>fas fa-minus</v-icon>
            <v-icon>fas fa-font</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
      <v-divider style="margin-top:20px;margin-bottom:20px;"></v-divider>
      <v-layout row justify-space-between>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.content") }}</v-subheader>
          <v-card-text id="pdf" ref="pdf" style="padding:55px;">
            <article id="adjustfont" v-html="readableItem.article_content"></article>
          </v-card-text>
        </v-flex>
      </v-layout>
      <v-divider style="margin-top:20px;margin-bottom:20px;"></v-divider>
      <v-subheader>{{ $t("messages.extra_meta_data") }}</v-subheader>
      <v-tabs v-model="activetab" icons-and-text centered>
        <v-tabs-slider color="yellow"></v-tabs-slider>
        <v-tab href="#tab-1">
          {{ $t("article.species") }}
          <v-icon>search</v-icon>
        </v-tab>
        <v-tab href="#tab-2">
          {{ $t("linkedata.title") }}
          <v-icon>blur_on</v-icon>
        </v-tab>
        <v-tab href="#tab-3">
          {{ $t("article.comments") }}
          <v-icon>people</v-icon>
        </v-tab>
        <v-tab-item value="tab-1">
          <v-card>
            <v-container>
              <v-layout>
                <v-flex d-flex xs12 sm6 md3 pa-3 v-for="(item, i) in species" :key="'specie___' + i">
                  <v-card>
                    <v-img :src="item.specie_detail.figure_path" aspect-ratio="1.30"></v-img>
                    <v-card-actions>
                      <v-list>
                        <v-list-tile>
                          <v-chip @click="getPicturesFor(item.specie_detail.taxonomy_group)" outline label color="red"><v-icon left>fas fa-images</v-icon>{{ $t("linkedata.load") }}</v-chip>
                        </v-list-tile>
                        <v-list-tile>
                          <v-chip @click.native.stop="taxonomy_dialog = true" @click.exact="showTaxonomy(item.specie_detail.taxonomy_group)" outline label color="blue"><v-icon left>fas fa-info</v-icon>{{ $t("linkedata.show_taxonomy") }}</v-chip>
                        </v-list-tile>
                        <v-list-tile>
                          <v-btn
                            target="_blank"
                            :href="'https://www.iucnredlist.org/search?query=' + item.specie_detail.taxonomy_group.taxonomy_rank_specie.rank_name.replace(' ', '+')"
                            outline label color="green">
                            <v-icon left>fas fa-dove</v-icon>
                            <v-icon left>fab fa-pagelines</v-icon>
                            {{ $t("linkedata.red_list") }}
                          </v-btn>
                        </v-list-tile>
                      </v-list>
                    </v-card-actions>
                  </v-card>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
        </v-tab-item>
        <v-tab-item value="tab-2">
          <v-card flat>
            <v-container>
              <v-subheader>Animalia</v-subheader>
              <v-divider></v-divider>
              <v-layout wrap>
                <v-flex xs6 pa-3 v-for="(item, i3) in linkedata.Animalia" :key="'specie_pictures___' + (i3 + 1)">
                  <v-card>
                    <a target="_blank" :href="item.img">
                      <v-img :src="item.img" height="300px"></v-img>
                    </a>
                    <v-card-actions>
                      <v-btn color="blue lighten-3" target="_blank" :href="item.info">{{ $t("linkedata.info") }}</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-flex>
              </v-layout>
              <v-subheader>Plantae</v-subheader>
              <v-divider></v-divider>
              <v-layout wrap>
                <v-flex xs6 pa-3 v-for="(item, i5) in linkedata.Plantae" :key="'specie_pictures___' + (i5 + 1)">
                  <v-card>
                    <a target="_blank" :href="item.img">
                      <v-img :src="item.img" height="300px"></v-img>
                    </a>
                    <v-card-actions>
                      <v-btn color="blue lighten-3" target="_blank" :href="item.info">{{ $t("linkedata.info") }}</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card>
        </v-tab-item>
        <v-tab-item value="tab-3">
          <div id="disqus_thread"></div>
        </v-tab-item>
      </v-tabs>
  </div>
</template>

<script>
import * as jsPDF from 'jspdf';
import moment from 'moment';
import utils from '../../../plugins/utils';
import localemanager from '../../../plugins/localemanager';

export default {
  data () {
    return {
      applocale: 'pt-br',
      taxonomy_dialog: false,
      taxonomy_info_display: '',
      linkedata: {
        Animalia: [],
        Plantae: []
      },
      fauna: [],
      flora: [],
      species: [],
      activetab: 'linkedata_0',
      readableItem: {
        taxonomy_group: {
          taxonomy_rank_specie: {}
        },
        modal_date_check: false
      }
    }
  },

  created() {
    this.getArticleById();
    this.getSpeciesRelated();
    this.startDisqus();
  },

  methods: {
    increaseFontSize: utils.increaseFontSize,

    pdf(item) {
      let margins = {
        top: 20,
        bottom: 20,
        right: 20,
        left: 20,
        width: 842 - 20,
        height: 540
      };

      let pdfName = item.title.replace(/\s/g, '_').toLowerCase();
      let options = {orientation: 'l', unit: 'px', format: 'a3'};
      let doc = new jsPDF(options);

      let img = new Image();
      img.src = item.figure_path;

      try {
        doc.addImage(img, 0, 0);
      } catch (error) {
        console.log(error);
      }

      doc.addPage();

      doc.setFontSize(52);
      doc.setFontType("bold");
      doc.text(margins.right, margins.height - 80, item.title);
      doc.setFontSize(22);
      doc.text(margins.right, margins.height - 40, item.subtitle);
      doc.setFontSize(12);

      doc.setFontType("italic");

      let publication_date = moment(String(item.publication_date), "YYYY-MM-DD").locale(localemanager.getSystemLocale());
      doc.text(margins.right, margins.height - 10, publication_date.format("LL"));

      doc.addPage();

      doc.fromHTML(item.article_content, margins.left, margins.top, {
        width: margins.width
      }, function(cb) {
        let aux = pdfName + '_' + publication_date.format("YYYYMMDD") + '_' + localemanager.getSystemLocale().replace('-', '').toLowerCase() + '.pdf';
        doc.save(aux);
      }, margins);
    },

    showTaxonomy(newTaxonomy) {
      var app = this;
      if (newTaxonomy.taxonomy_rank_kingdom != undefined) {
        app.taxonomy_info_display = {
          kingdom: newTaxonomy.taxonomy_rank_kingdom.rank_name,
          phylum: newTaxonomy.taxonomy_rank_phylum.rank_name,
          class: newTaxonomy.taxonomy_rank_class.rank_name,
          order: newTaxonomy.taxonomy_rank_order.rank_name,
          family: newTaxonomy.taxonomy_rank_family.rank_name,
          genus: newTaxonomy.taxonomy_rank_genus.rank_name,
          specie: newTaxonomy.taxonomy_rank_specie.rank_name
        }
      } else {
        app.taxonomy_info_display = {
          kingdom: this.$i18n.t('alerts.missing_rank_association'),
          phylum: this.$i18n.t('alerts.missing_rank_association'),
          class: this.$i18n.t('alerts.missing_rank_association'),
          order: this.$i18n.t('alerts.missing_rank_association'),
          family: this.$i18n.t('alerts.missing_rank_association'),
          genus: this.$i18n.t('alerts.missing_rank_association'),
          specie: this.$i18n.t('alerts.missing_rank_association')
        }
      }
    },

    updateWindowTitle(newtitle, newsubtitle) {
      console.log(newtitle, newsubtitle);
      document.title = newtitle + " (" + newsubtitle + ")";
    },

    getArticleById() {
      var app = this;
      axios.get('/api/v1/articles/read/' + app.$route.params.id).then(function(resp) {
        app.readableItem = resp.data;
        document.title = document.title + ' :: ' + resp.data.title + " (" + resp.data.subtitle + ")";
        console.log(resp.data);
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
      });
    },

    getSpeciesRelated() {
      var app = this;
      console.log('/api/v1/articles/' + app.$route.params.id + '/all_species');
      axios.get('/api/v1/articles/' + app.$route.params.id + '/all_species').then(function(resp) {
        app.species = resp.data;
        console.log(app.species);
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.animals'));
      });
    },

    getPicturesFor(item) {
      if (item.taxonomy_rank_kingdom.rank_name === 'Plantae') {
        this.getSplinkContent(item.taxonomy_rank_specie.rank_name);
      } else if (item.taxonomy_rank_kingdom.rank_name === 'Animalia') {
        this.getBritannicaContent(item.taxonomy_rank_specie.rank_name);
      }
      this.goToLinkedDataTab();
    },

    getSplinkContent(specie) {
      var app = this;
      console.log('/api/v1/splink/' + specie + '/2/10')
      axios.get('/api/v1/splink/' + specie + '/2/10').then(function(resp) {
        app.linkedata.Plantae = resp.data;
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
      });
    },

    getBritannicaContent(specie) {
      var app = this;
      console.log('/api/v1/britannica/' + specie + '/10')
      axios.get('/api/v1/britannica/' + specie + '/10').then(function(resp) {
        app.linkedata.Animalia = resp.data;
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
      });
    },

    goToLinkedDataTab() {
      this.activetab = 'tab-2';
    },

    startDisqus() {
      var app = this;
      var disqus_config = function () {
        this.page.url = 'http://projetofritzmuller.herokuapp.com/guest/articles/read/' + app.$route.params.id;
        this.page.identifier = 'article:/guest/articles/read/' + app.$route.params.id;
      };
      (function() {
        var d = document, s = d.createElement('script');
        s.src = 'https://projetofritzmuller-herokuapp-com.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
      })();
    }
  }
}
</script>
