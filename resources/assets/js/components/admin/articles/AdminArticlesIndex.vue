<template>
  <v-card style="padding-top:60px;">
    <v-dialog v-model="dialog_article" persistent>
      <v-btn color="primary" slot="activator" mb-2 @click.native="clean">
        <v-icon>brush</v-icon>
        {{ $t("article.create") }}
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_article">
              <v-layout>
                <v-flex xs6>
                  <v-flex xs6>
                    <v-subheader>{{ $t("article.rating") }}</v-subheader>
                    <span class="display-3 font-weight-light" v-text="editedItem.rating"></span>
                    <v-slider min="0" max="5" v-model="editedItem.rating"></v-slider>
                  </v-flex>
                  <v-flex xs6>
                    <v-subheader>{{ $t("messages.donate") }}</v-subheader>
                    <span class="display-3 font-weight-light">{{editedItem.price | currencyi18n}}</span>
                    <v-text-field v-model="editedItem.price"></v-text-field>
                    <v-slider min="0" max="99" v-model="price_fraction_left_part"></v-slider>
                    <v-slider min="0" max="99" v-model="price_fraction_right_part"></v-slider>
                  </v-flex>
                  <v-flex xs6>
                    <v-subheader>{{ $t("article.title") }}</v-subheader>
                    <v-text-field v-model="editedItem.title"></v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-subheader>{{ $t("article.subtitle") }}</v-subheader>
                    <v-text-field v-model="editedItem.subtitle"></v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-subheader>{{ $t("article.figure_path") }}</v-subheader>
                    <v-text-field :title="$t('messages.pick_an_image')"
                        @click="setNewFigurePath(editedItem);"
                        v-model="editedItem.figure_path">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-subheader>{{ $t("article.publication_date") }}</v-subheader>
                    <v-dialog ref="dialog_date"
                      persistent
                      v-model="editedItem.modal_date_check"
                      width="300px"
                      :return-value.sync="editedItem.publication_date">
                      <v-text-field slot="activator"
                        v-model="editedItem.publication_date"
                        prepend-icon="event"
                        readonly>
                      </v-text-field>
                      <v-date-picker :locale="applocale" v-model="editedItem.publication_date" scrollable>
                        <v-spacer></v-spacer>
                        <v-btn flat color="primary" @click="editedItem.modal_date_check = false">{{ $t("messages.cancel") }}</v-btn>
                        <v-btn flat color="primary" @click="$refs.dialog_date.save(editedItem.publication_date)">{{ $t("messages.ok") }}</v-btn>
                      </v-date-picker>
                    </v-dialog>
                  </v-flex>
                  <v-flex xs6>
                    <!-- <v-subheader>{{ $t("article.active") }}</v-subheader> -->
                    <!-- <v-text-field v-model="editedItem.active"></v-text-field> -->
                    <v-subheader>{{ $t( 'messages.open_closed') }}</v-subheader>
                    <v-switch v-model="editedItem.active"></v-switch>
                  </v-flex>
                </v-flex>
                <v-flex xs6>
                  <v-subheader>{{ $t("article.content") }}</v-subheader>
                  <tinymce id="article_content"
                    v-model="editedItem.article_content"
                    :content='editedItem.article_content_reflection'
                    :options='editor_tiny_mce.options'>
                  </tinymce>
                </v-flex>
              </v-layout>
              <v-card-actions>
                <v-btn block color="green lighten-2" @click.native="save">{{ $t("messages.ok") }}</v-btn>
                <v-btn block color="blue lighten-2" @click.native="close">{{ $t("messages.cancel") }}</v-btn>
              </v-card-actions>
            </v-form>
          </v-container>
        </v-card-text>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialog_species_taxonomy" persistent>
      <v-card>
        <v-card-title>
          <span class="headline">{{ $t("article.selecting_species_taxonomy") }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_fauna_flora_tax">
              <v-container fluid>
                <v-layout>
                  <v-flex>
                    <v-autocomplete @keydown.enter.native.prevent
                      :loading="specie_selector.loading"
                      :items="specie_selector.items"
                      :search-input.sync="searchable_specie_rank_name"
                      v-model="editedItem.new_species"
                      :label="$t('article.species_selector')"
                      multiple
                      chips>
                    </v-autocomplete>
                  </v-flex>
                </v-layout>
                <v-layout row wrap>
                  <v-flex xs4 order-md2 order-xs1
                    v-for="(data, idx) in editedItem.article_species"
                    :key="'current_specie_idx_' + idx">
                    <v-chip color="cyan lighten-4">
                      <v-avatar>
                        <img :src="data.species_detail.figure_path">
                      </v-avatar>
                      <span>{{data.species_detail.taxonomy_group.taxonomy_rank_specie.rank_name}}</span>
                    </v-chip>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn block color="green lighten-2" @click.native="save">{{ $t("messages.ok") }}</v-btn>
          <v-btn block color="blue lighten-2" @click.native="close">{{ $t("messages.cancel") }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-card-title>
      {{ $t("article.show") }}
      <v-spacer></v-spacer>
      <v-text-field
        append-icon="search"
        :label="$t('messages.search_by_title_subtitle_only')"
        single-line
        hide-details
        v-model="search">
      </v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="items"
      :search="search"
      hide-actions>
      <template slot="items" slot-scope="props">
        <td class="text-xs-center">{{ props.item.title }}</td>
        <td class="text-xs-center">{{ props.item.subtitle }}</td>
        <td class="text-xs-center">{{ props.item.article_content.slice(0, 50) + ' ...' }}</td>
        <td class="text-xs-center">{{ props.item.publication_date | datei18n }}</td>
        <td class="text-xs-center" width="50px">
          <v-img :src="props.item.figure_path" height="60px"></v-img>
        </td>
        <td class="text-xs-center">
          <div v-if="props.item.active">
            <v-icon>far fa-eye</v-icon>
          </div>
          <div v-else>
            <v-icon>far fa-eye-slash</v-icon>
          </div>
        </td>
        <td class="text-xs-center">
          <v-btn icon class="mx-0" @click="selectTaxonomy(props.item)">
            <v-icon color="blue">fas fa-fish</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="teal">fas fa-edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">fas fa-trash-alt</v-icon>
          </v-btn>
        </td>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        {{ $t("messages.search_failed_part1") }} "{{ search }}" {{ $t("messages.search_failed_part2") }}.
      </v-alert>
    </v-data-table>
    <div class="text-xs-center pt-2">
      <v-pagination @input="nextPage" v-model="pagination.page" :length="pages"></v-pagination>
    </div>
  </v-card>
</template>

<script>
export default {
  middleware: 'auth',

  data() {
    return {
      applocale: 'pt-br',
      search: '',
      items: [],
      dialog_article: false,
      dialog_species_taxonomy: false,
      editedIndex: -1,
      pages: 0,
      searchable_specie_rank_name: null,
      price_fraction_left_part: 0,
      price_fraction_right_part: 0,
      specie_selector: {
        loading: false,
        items: []
      },
      default_specie_selector: {
        loading: false,
        items: []
      },
      pagination: {
        page: null,
        totalItems: null,
        rowsPerPage: null
      },
      editor_tiny_mce: {
        options: {
          selector: "#article_content",
          browser_spellcheck : true,
          forced_root_block: false,
          force_p_newlines: false,
          force_br_newlines: true,
          plugins: [
            "advlist lists link image hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons paste textcolor colorpicker textpattern"
          ],
          toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
          relative_urls: false,
          file_browser_callback : function(field_name, url, type, win) {
            var x = window.innerWidth  ||
                    document.documentElement.clientWidth  ||
                    document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight ||
                    document.documentElement.clientHeight ||
                    document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = '/laravel-filemanager?field_name=' + field_name;

            if (type == 'image') {
              cmsURL = cmsURL + "&type=Images";
            } else {
              cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
              file : cmsURL,
              title : 'Filemanager',
              width : x * 0.8,
              height : y * 0.8,
              resizable : "yes",
              close_previous : "no"
            });
          }
        }
      },
      headers: [
        {
          text: this.$i18n.t('article.title'),
          value: 'title',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('article.subtitle'),
          value: 'subtitle',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('article.content'),
          sortable: false,
          align: 'center'
        },
        {
          text: this.$i18n.t('article.publication_date'),
          value: 'publication_date',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('article.figure_path'),
          sortable: false,
          align: 'center'
        },
        {
          text: this.$i18n.t('article.active'),
          sortable: false,
          align: 'center'
        },
        {
          text: this.$i18n.t('messages.actions'),
          sortable: false,
          align: 'center'
        }
      ],
      editedItem: {
        title: '',
        subtitle: '',
        figure_path: '',
        article_content: '',
        article_content_reflection: '',
        publication_date: '',
        active: false,
        price: 0.0,
        rating: 0,
        new_species: [],
        article_species: [],
        modal_date_check: false
      },
      defaultItem: {
        title: '',
        subtitle: '',
        figure_path: '',
        article_content: '',
        article_content_reflection: '',
        publication_date: '',
        active: false,
        price: 0.0,
        rating: 0,
        new_species: [],
        article_species: [],
        modal_date_check: false
      }
    }
  },

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? this.$i18n.t('article.creating') : this.$i18n.t('article.editing')
    }
  },

  watch: {
    dialog_article(val) {
      val || this.close()
    },
    dialog_species_taxonomy(val) {
      val || this.close()
    },
    searchable_specie_rank_name(val) {
      val && this.querySpecieRanks(val)
    },
    price_fraction_left_part(val) {
      val && this.buildDonationPrice(val, this.price_fraction_right_part)
    },
    price_fraction_right_part(val) {
      val && this.buildDonationPrice(this.price_fraction_left_part, val)
    }
  },

  created() {
    this.initialize();
    const lang = document.documentElement.lang;
    this.applocale = lang;
  },

  methods: {
    initialize() {
      var app = this;
      axios.get('/api/v1/articles').then(function(resp) {
        app.items = resp.data.data;
        app.pagination.page = resp.data.current_page;
        app.pagination.totalItems = resp.data.total;
        app.pagination.rowsPerPage = resp.data.per_page;
        app.pages = resp.data.last_page;
      });
    },

    buildDonationPrice(left, right) {
      if (right < 10) {
        this.editedItem.price = left + (right/10);
      } else {
        this.editedItem.price = left + (right/100);
      }
    },

    querySelections(v) {
      var app = this;
      app.species_selectors.loading = true;
      setTimeout(() => {
        app.species_selectors.loading = false;
      }, 500);
    },

    nextPage(page) {
      var app = this;
      axios.get('/api/v1/articles?page=' + page).then(function(resp) {
        app.items = resp.data.data;
      });
    },

    selectTaxonomy(item) {
      this.dialog_species_taxonomy = true;
      this.editedIndex = this.items.indexOf(item);
      Object.assign(this.editedItem, item);
      this.editedItem.article_content_reflection = this.editedItem.article_content;
      this.assignSpeciesToArticle(item.id);
    },

    saveTaxonomy(event) {
      event.preventDefault();
      var app = this;
      if (this.editedIndex > -1) {
        this.updateTaxonomyForm(this.items[this.editedIndex]);
      }
      this.close();
    },

    assignSpeciesToArticle(id) {
      var app = this;
      axios.get('/api/v1/articles/' + id + '/all_species').then(function (resp) {
        app.editedItem.article_species = resp.data;
      });
      console.log(app.editedItem.article_species);
    },

    updateTaxonomyForm(item) {
      var app = this;
      axios.patch('/api/v1/articles/species/' + item.id, item.article_species).then(function (resp) {
        app.$router.replace('/admin/articles');
      });
    },

    async queryRankName(link, val, sel) {
      var app = this;
      axios.get(link + val).then(function(resp) {
        sel.loading = true;
        setTimeout(() => {
          if (resp.data[0]) {
            sel.items = [resp.data[0].rank_name];
          }
          sel.loading = false;
        }, 100);
      });
    },

    querySpecieRanks(val) {
      this.queryRankName('/api/v1/species/search/', val, this.specie_selector);
    },

    // getAllSpecies() {
    //   var app = this;
    //   axios.get('/api/v1/species/parcial/all').then(function(resp) {
    //     app.species_selectors.species = resp.data;
    //   });
    // },

    editItem(item) {
      this.dialog_article = true;
      this.editedIndex = this.items.indexOf(item);
      Object.assign(this.editedItem, item);
      this.editedItem.article_content_reflection = this.editedItem.article_content;
    },

    deleteItem(item) {
      var app = this;
      const index = this.items.indexOf(item);
      if (confirm(this.$i18n.t('messages.sure_delete_question'))) {
        axios.delete('/api/v1/articles/' + item.id).then(function (resp) {
          app.items.splice(index, 1);
        });
      }
    },

    close() {
      this.dialog_article = false;
      this.dialog_species_taxonomy = false;
      setTimeout(() => {
        this.editedIndex = -1;
      }, 300);
      this.initialize();
    },

    clean() {
      Object.assign(this.editedItem, this.defaultItem);
      Object.assign(this.specie_selector, this.default_specie_selector);
    },

    save(event) {
      event.preventDefault();
      if (this.editedIndex > -1) {
        Object.assign(this.items[this.editedIndex], this.editedItem);
        this.updateForm(this.items[this.editedIndex].id);
      } else {
        this.items.push(this.editedItem);
        this.createForm();
      }
      this.close();
    },

    createForm() {
      var app = this;
      axios.post('/api/v1/articles', this.editedItem).then(function (resp) {
        app.$router.push({path: '/admin/articles'});
      });
    },

    updateForm(articleId) {
      var app = this;
      axios.patch('/api/v1/articles/' + articleId, this.editedItem).then(function (resp) {
        app.$router.replace('/admin/articles');
      });
    },

    setNewFigurePath(item) {
      this.lfm({type: 'image', prefix: '/laravel-filemanager'}, function(url, path) {
        item.figure_path = path;
      });
    },

    lfm(options, cb) {
      var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
      window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
      window.SetUrl = cb;
    }
  }
}
</script>
