<template>
  <v-card style="padding-top:60px;">
    <v-dialog fullscreen transition="dialog-bottom-transition" :overlay="false" scrollable v-model="dialog_article" max-width="500px">
      <v-btn color="primary" dark slot="activator" class="mb-2" @click.native="clean">
        <v-icon>brush</v-icon>
        {{ $t("article.create") }}
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_article" lazy-validation>
              <v-flex xs6>
                <v-subheader>{{ $t("article.title") }}</v-subheader>
                <v-text-field required v-model="editedItem.title"></v-text-field>
              </v-flex>
              <v-flex xs6>
                <v-subheader>{{ $t("article.subtitle") }}</v-subheader>
                <v-text-field required v-model="editedItem.subtitle"></v-text-field>
              </v-flex>
              <v-flex xs6>
                <v-subheader>{{ $t("article.figure_path") }}</v-subheader>
                <v-text-field required :title="$t('messages.pick_an_image')"
                              @click="setNewFigurePath(editedItem);"
                              v-model="editedItem.figure_path">
                </v-text-field>
              </v-flex>
              <v-flex xs6>
                <v-subheader>{{ $t("article.content") }}</v-subheader>
                <tinymce required id="article_content"
                         v-model="editedItem.article_content"
                         :content='editedItem.article_content_reflection'
                         :options='editor_tiny_mce.options'>
                </tinymce>
              </v-flex>
              <v-flex xs6>
                <v-subheader>{{ $t("article.publication_date") }}</v-subheader>
                <v-dialog
                  ref="dialog_date"
                  persistent
                  v-model="editedItem.modal_date_check"
                  lazy
                  full-width
                  width="300px"
                  :return-value.sync="editedItem.publication_date">
                  <v-text-field
                    required
                    slot="activator"
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
                <v-switch required v-model="editedItem.active"></v-switch>
              </v-flex>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green lighten-2" @click.native="save">{{ $t("messages.ok") }}</v-btn>
          <v-btn color="blue lighten-2" @click.native="close">{{ $t("messages.cancel") }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog fullscreen transition="dialog-bottom-transition"
              :overlay="false" scrollable v-model="dialog_species_taxonomy" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ $t("article.selecting_species_taxonomy") }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_fauna_flora_tax" lazy-validation>
              <v-container fluid>
                <v-layout>
                  <v-flex>
                    <v-autocomplete
                      :loading="species_selectors.loading_species"
                      :items="species_selectors.species"
                      :search-input.sync="search_species"
                      v-model="editedItem.articleSpecies"
                      :label="$t('article.species_selector')"
                      multiple
                      cache-items
                      chips
                      required>
                    </v-autocomplete>
                  </v-flex>
                </v-layout>
                <v-layout row wrap>
                  <v-flex xs4 order-md2 order-xs1
                          v-for="(data, idx) in editedItem.articleSpecies"
                          :key="'current_ones_chosen_specie_idx_' + idx">
                    <v-chip color="cyan lighten-4">
                      <v-avatar>
                        <img :src="data.figure_path">
                      </v-avatar>
                      <span>{{data}}</span>
                    </v-chip>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green lighten-2" @click.native="saveTaxonomy">{{ $t("messages.ok") }}</v-btn>
          <v-btn color="blue lighten-2" @click.native="close">{{ $t("messages.cancel") }}</v-btn>
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
        <td class="text-xs-left">{{ props.item.title }}</td>
        <td class="text-xs-left">{{ props.item.subtitle }}</td>
        <td width="50px" class="text-xs-left">
          <v-img :src="props.item.figure_path" height="60px"></v-img>
        </td>
        <td class="text-xs-left">{{ props.item.article_content.slice(0, 50) + ' ...' }}</td>
        <td class="text-xs-left">{{ props.item.publication_date }}</td>
        <td class="text-xs-right">
          <div v-if="props.item.active">
            <v-icon>far fa-eye</v-icon>
          </div>
          <div v-else>
            <v-icon>far fa-eye-slash</v-icon>
          </div>
        </td>
        <td class="justify-center layout px-0">
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
      search_species: null,
      species_selectors: {
        loading_species: false,
        species: []
      },
      pagination: {
        page: null,
        totalItems: null,
        rowsPerPage: null
      },
      editor_tiny_mce: {
        options: {
          selector: "#article_content",
          width: 842,
          height: 1191,
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
          value: 'title'
        },
        {
          text: this.$i18n.t('article.subtitle'),
          value: 'subtitle'
        },
        {
          text: this.$i18n.t('article.figure_path'),
          value: 'figure_path',
          sortable: false
        },
        {
          text: this.$i18n.t('article.content'),
          value: 'content',
          sortable: false
        },
        {
          text: this.$i18n.t('article.publication_date'),
          value: 'date',
          sortable: false
        },
        {
          text: this.$i18n.t('article.active'),
          value: 'active',
          sortable: false
        },
        {
          text: this.$i18n.t('messages.actions'),
          value: 'action',
          sortable: false
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
        modal_date_check: false,
        articleSpecies: []
      },
      defaultItem: {
        title: '',
        subtitle: '',
        figure_path: '',
        article_content: '',
        article_content_reflection: '',
        publication_date: '',
        active: false,
        modal_date_check: false,
        articleSpecies: []
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
    search_species(val) {
      val && this.querySelections(val)
    }
  },

  created() {
    this.initialize();
    this.getAllSpecies();
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
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.articles'));
      });
    },

    querySelections(v) {
      var app = this;
      app.species_selectors.loading_species = true;
      setTimeout(() => {
        app.species_selectors.loading_species = false;
      }, 500);
    },

    nextPage(page) {
      var app = this;
      axios.get('/api/v1/articles?page=' + page).then(function(resp) {
        app.items = resp.data.data;
      }).catch(error => {
        console.log(error);
      });
    },

    selectTaxonomy(item) {
      var app = this;
      app.dialog_species_taxonomy = true;
      app.editedIndex = app.items.indexOf(item);
      Object.assign(app.editedItem, item);
      app.assignSpeciesToArticle(item.id);
    },

    saveTaxonomy(event) {
      var app = this;
      event.preventDefault();
      if (app.editedIndex > -1) {
        Object.assign(app.items[app.editedIndex], app.editedItem);
        app.updateTaxonomyForm(app.items[app.editedIndex]);
      }
      app.close();
    },

    assignSpeciesToArticle(id) {
      var app = this;
      console.log('/api/v1/articles/' + id + '/all_species');
      axios.get('/api/v1/articles/' + id + '/all_species').then(function (resp) {
        app.editedItem.articleSpecies = resp.data;
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
      });
      console.log(app.editedItem.articleSpecies);
    },

    updateTaxonomyForm(item) {
      var app = this;
      axios.patch('/api/v1/articles/species/' + item.id, item.articleSpecies).then(function (resp) {
        app.$router.replace('/admin/articles');
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
      });
    },

    getAllSpecies() {
      var app = this;
      axios.get('/api/v1/species/parcial/all').then(function(resp) {
        app.species_selectors.species = resp.data;
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.articles'));
      });
    },

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
        }).catch(function (resp) {
          alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
        });
      }
    },

    close() {
      this.dialog_article = false;
      this.dialog_species_taxonomy = false;
      setTimeout(() => {
        this.clean();
        this.editedIndex = -1;
      }, 300);
      this.initialize();
    },

    clean() {
      Object.assign(this.editedItem, this.defaultItem);
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

    clean() {
      var app = this;
      Object.assign(app.editedItem, app.defaultItem);
    },

    createForm() {
      var app = this;
      axios.post('/api/v1/articles', this.editedItem).then(function (resp) {
        app.$router.push({path: '/admin/articles'});
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
      });
    },

    updateForm(articleId) {
      var app = this;
      axios.patch('/api/v1/articles/' + articleId, this.editedItem).then(function (resp) {
        app.$router.replace('/admin/articles');
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.article'));
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
