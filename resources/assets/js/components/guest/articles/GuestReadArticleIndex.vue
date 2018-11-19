<template>
  <v-card style="margin:60px;">
    <v-dialog v-model="taxonomy_dialog" max-width="590">
      <v-card>
        <v-card-text>
          <v-layout row>
            <v-flex xs4>
              <v-subheader>Kingdom:</v-subheader>
            </v-flex>
            <v-flex xs8>
              <v-chip label color="green lighten-2">{{ taxonomy_info_display.kingdom }}</v-chip>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <v-subheader>Phylum:</v-subheader>
            </v-flex>
            <v-flex xs8>
              <v-chip label color="green lighten-2">{{ taxonomy_info_display.phylum }}</v-chip>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <v-subheader>Class:</v-subheader>
            </v-flex>
            <v-flex xs8>
              <v-chip label color="green lighten-2">{{ taxonomy_info_display.class }}</v-chip>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <v-subheader>Order:</v-subheader>
            </v-flex>
            <v-flex xs8>
              <v-chip label color="green lighten-2">{{ taxonomy_info_display.order }}</v-chip>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <v-subheader>Family:</v-subheader>
            </v-flex>
            <v-flex xs8>
              <v-chip label color="green lighten-2">{{ taxonomy_info_display.family }}</v-chip>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <v-subheader>Genus:</v-subheader>
            </v-flex>
            <v-flex xs8>
              <v-chip label color="green lighten-2">{{ taxonomy_info_display.genus }}</v-chip>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs4>
              <v-subheader>Species:</v-subheader>
            </v-flex>
            <v-flex xs8>
              <v-chip label color="green lighten-2">{{ taxonomy_info_display.specie }}</v-chip>
            </v-flex>
          </v-layout>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat="flat" @click.native="taxonomy_dialog = false">Cool!</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-container fluid grid-list-md>
      <v-layout row justify-space-between>
        <v-flex xs12 align-end flexbox>
          <v-img :src="readableItem.figure_path" height="600px"></v-img>
        </v-flex>
      </v-layout>
      <v-layout row wrap justify-space-between>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.title") }}</v-subheader>
          <span class="display-3">{{readableItem.title}}</span>
        </v-flex>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.subtitle") }}</v-subheader>
          <h2>{{readableItem.subtitle}}</h2>
        </v-flex>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.publication_date") }}</v-subheader>
          <h3>{{readableItem.publication_date }}</h3>
          <!-- <v-date-picker :locale="applocale" v-model="readableItem.publication_date" readonly></v-date-picker> -->
        </v-flex>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.pdf_session") }}</v-subheader>
          <v-btn @click="pdf(readableItem)">{{ $t("article.get_pdf") }}</v-btn>
        </v-flex>
      </v-layout>
      <v-layout row justify-space-between>
        <div class="text-xs-center">
          <v-rating v-model="readableItem.rating"></v-rating>
        </div>
      </v-layout>
      <v-divider style="margin-top:20px;margin-bottom:20px;"></v-divider>
      <v-layout row justify-space-between>
        <v-flex xs12 align-end flexbox>
          <v-subheader>{{ $t("article.content") }}</v-subheader>
          <v-card-text id="pdf" ref="pdf" style="padding:55px;">
            <div v-html="readableItem.article_content"></div>
          </v-card-text>
        </v-flex>
      </v-layout>
      <v-divider style="margin-top:20px;margin-bottom:20px;"></v-divider>
      <v-subheader>{{ $t("messages.extra_meta_data") }}</v-subheader>
      <v-tabs v-model="activetab" icons-and-text centered>
        <v-tabs-slider color="yellow"></v-tabs-slider>
        <v-tab href="#tab-1">
          {{ $t("linkedata.title") }}
          <v-icon>blur_on</v-icon>
        </v-tab>
        <v-tab href="#tab-2">
          {{ $t("article.species") }}
          <v-icon>search</v-icon>
        </v-tab>
        <v-tab href="#tab-3">
          {{ $t("article.comments") }}
          <v-icon>people</v-icon>
        </v-tab>
        <v-tab-item value="tab-1">
          <v-card flat>
            <v-layout row justify-space-between>
              <v-flex xs12 align-end flexbox>
                <v-container grid-list-xl>
                  <v-layout row wrap align-center>
                    <v-flex class="xs3" v-for="(item, i) in linkedata" :key="'tab-' + (i + 1)">
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
              </v-flex>
            </v-layout>
          </v-card>
        </v-tab-item>
        <v-tab-item value="tab-2">
          <v-card flat>
            <v-layout row justify-space-between>
              <v-flex xs12 align-end flexbox>
                <v-container grid-list-xl>
                  <v-layout row wrap align-center>
                    <v-flex class="xs3" v-for="(item, i) in species" :key="'specie_' + i">
                      <v-card>
                        <v-img :src="item.species_detail.figure_path" height="300px"></v-img>
                        <v-card-actions>
                          <v-btn color="purple lighten-3" @click="getPicturesFor(item.species_detail.taxonomy_group.specie)">{{ $t("linkedata.load") }}</v-btn>
                          <v-btn color="blue lighten-3" @click.native.stop="taxonomy_dialog = true" @click="showTaxonomy(item.species_detail.taxonomy_group)">{{ $t("linkedata.show_taxonomy") }}</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-flex>
            </v-layout>
          </v-card>
        </v-tab-item>
        <v-tab-item value="tab-3">
          <div id="disqus_thread"></div>
        </v-tab-item>
      </v-tabs>
    </v-container>
  </v-card>
</template>

<script>
import * as jsPDF from 'jspdf';
import moment from 'moment';

export default {
  data () {
    return {
      applocale: 'pt-br',
      taxonomy_dialog: false,
      taxonomy_info_display: '',
      linkedata: [],
      fauna: [],
      flora: [],
      species: [],
      activetab: 'linkedata_0',
      readableItem: {
        title: '',
        subtitle: '',
        article_content: '',
        publication_date: '',
        figure_path: '',
        active: false,
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
    pdf(item) {
      let margins = {
        top: 20,
        bottom: 20,
        right: 20,
        left: 20,
        width: 842 - 20,
        height: 540
      };

      let pdfName = item.title;
      var options = {orientation: 'l', unit: 'px', format: 'a3'};
      var doc = new jsPDF(options);

      var img = new Image();
      img.src = item.figure_path;

      doc.addImage(img, 0, 0);
      doc.addPage();

      doc.setFontSize(52);
      doc.text(margins.right, margins.height - 80, item.title);
      doc.setFontSize(22);
      doc.text(margins.right, margins.height - 40, item.subtitle);
      doc.setFontSize(12);
      doc.setFontType("italic");
      doc.text(margins.right, margins.height - 10, moment(String(item.publication_date), "YYYY-MM-DD").locale(document.documentElement.lang).format('LL'));

      doc.addPage();

      doc.fromHTML(item.article_content, margins.left, margins.top, {
        width: margins.width
      }, function(cb) {
         doc.save(item.title + '_' + item.publication_date + '.pdf');
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

    getPicturesFor(specie) {
      this.goToLinkedDataTab();
    },

    getSplinkContent(subspecie) {
      var app = this;
      console.log('/api/v1/splink/' + subspecie + '/2/10')
      axios.get('/api/v1/splink/' + subspecie + '/2/10').then(function(resp) {
        app.linkedata = resp.data;
        console.log(app.linkedata);
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
      });
      this.goToLinkedDataTab();
    },

    getArkiveContent(subspecie) {
      var app = this;
      console.log('/api/v1/arkive/' + subspecie + '/10')
      axios.get('/api/v1/arkive/' + subspecie + '/10').then(function(resp) {
        console.log(resp.data);
        app.linkedata = resp.data;
        console.log(app.linkedata);
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
      });
      this.goToLinkedDataTab();
    },

    goToLinkedDataTab() {
      this.activetab = 'tab-1';
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
