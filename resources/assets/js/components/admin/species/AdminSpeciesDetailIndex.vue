<template>
  <v-card style="padding-top:60px;">
    <v-dialog fullscreen transition="dialog-bottom-transition" :overlay="false" scrollable v-model="dialog_species_taxonomy" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ $t("species.selecting_species_taxonomy") }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_species_tax" lazy-validation>
              <v-container fluid>
                <v-layout>
                  <v-flex>
                    <v-autocomplete
                      :loading="species_selectors.loading_species"
                      :items="species_selectors.species"
                      :search-input.sync="search_species"
                      :label="$t('species.species_selector')"
                      v-model="editedItem.taxonomy_group"
                      cache-items
                      chips
                      required>
                    </v-autocomplete>
                    <v-card>
                      <v-layout row wrap>
                        <v-subheader>{{$t('species.new_specie_to_swap')}}</v-subheader>
                        <v-flex v-for="(value, key, index) in editedItem.taxonomy_group" :key="'new_specie_to_swap'+index">
                          <v-flex xs1 order-xs1>
                            <v-chip color="pink lighten-4">
                              {{key}}: {{value}}
                            </v-chip>
                          </v-flex>
                        </v-flex>
                      </v-layout>
                      <v-divider></v-divider>
                      <v-layout row wrap>
                        <v-subheader>{{$t('species.current_specie_associated')}}</v-subheader>
                        <v-flex v-for="(value, key, index) in editedItem.taxonomy_group" :key="'current_specie_associated'+index">
                          <v-flex xs1 order-xs1>
                            <v-chip color="green lighten-4">
                              {{key}}: {{value}}
                            </v-chip>
                          </v-flex>
                        </v-flex>
                      </v-layout>
                    </v-card>
                  </v-flex>
                </v-layout>
              </v-container>
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
    <v-dialog fullscreen transition="dialog-bottom-transition" :overlay="false" scrollable v-model="dialog_species" max-width="500px">
      <v-btn color="primary" dark slot="activator" class="mb-2" @click.native="clean">
        <v-icon>brush</v-icon>
        {{ $t("species.create") }}
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_species" lazy-validation>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t('species.popular_name') }}</v-subheader>
                  <v-combobox
                    v-model="editedItem.popular_names"
                    :label="$t('species.popular_names_creator')"
                    chips
                    clearable
                    prepend-icon="filter_list"
                    solo
                    multiple>
                    <template slot="selection" slot-scope="data">
                      <v-chip
                        :selected="data.selected"
                        close
                        @input="remove(data.item.popular_name)">
                        <strong>{{ data.item.popular_name }}</strong>&nbsp;
                      </v-chip>
                    </template>
                  </v-combobox>
                  <!-- <v-flex v-for="(value, key, index) in editedItem.popular_names" :key="'popular_name_associated' + index">
                    <v-text-field v-model="editedItem.popular_names[key].popular_name"></v-text-field>
                  </v-flex> -->
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t("species.figure_path") }}</v-subheader>
                <v-text-field :title="$t('messages.pick_an_image')"
                              @click="setNewFigurePath(editedItem);"
                              v-model="editedItem.figure_path">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t("species.description") }}</v-subheader>
                <tinymce id="species_description" v-model="editedItem.species_description"
                         :content="editedItem.species_description_content_reflection"
                         :options="editor_tiny_mce.options">
                </tinymce>
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
    <v-card-title>
      {{ $t("species.show") }}
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
        <td width="150px" class="text-xs-left">
          <v-layout row wrap>
            <v-flex v-for="(value, key, index) in props.item.popular_names" :key="value.popular_name.toLowerCase() + index">
              <v-chip color="blue lighten-3">
                {{value.popular_name}}
              </v-chip>
            </v-flex>
          </v-layout>
        </td>
        <td width="50px" class="text-xs-left">
          <v-img :src="props.item.figure_path" height="60px"></v-img>
        </td>
        <td class="text-xs-left">{{ props.item.species_description.slice(0, 50) + ' ...' }}</td>
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="selectTaxonomy(props.item)">
            <v-icon color="blue">fas fa-crow</v-icon>
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
      search: '',
      items: [],
      dialog_species: false,
      editedIndex: -1,
      applocale: 'pt-br',
      pages: 0,
      dialog_species_taxonomy: false,
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
          selector: "#species_description",
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

            // console.log(field_name);
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
          text: this.$i18n.t('species.popular_name'),
          value: 'popular_name'
        },
        {
          text: this.$i18n.t('species.figure_path'),
          value: 'figure_path',
          sortable: false
        },
        {
          text: this.$i18n.t('species.description'),
          value: 'description',
          sortable: false
        },
        {
          text: this.$i18n.t('messages.actions'),
          value: 'action',
          sortable: false
        }
      ],
      editedItem: {
        popular_name: '',
        figure_path: '',
        species_description: '',
        species_description_content_reflection: '',
        modal_date_check: false,
        species_tax_id: undefined,
        taxonomy_group: undefined,
        popular_names: []
      },
      defaultItem: {
        popular_name: '',
        figure_path: '',
        species_description: '',
        species_description_content_reflection: '',
        modal_date_check: false,
        species_tax_id: undefined,
        taxonomy_group: undefined,
        popular_names: []
      }
    }
  },

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? this.$i18n.t('species.creating') : this.$i18n.t('species.editing')
    }
  },

  watch: {
    dialog_species(val) {
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
    const lang = document.documentElement.lang;
    this.applocale = lang;
  },

  methods: {
    initialize() {
      var app = this;
      axios.get('/api/v1/species').then(function(resp) {
        app.items = resp.data.data;
        app.pagination.page = resp.data.current_page;
        app.pagination.totalItems = resp.data.total;
        app.pagination.rowsPerPage = resp.data.per_page;
        app.pages = resp.data.last_page;
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.species'));
      });
    },

    nextPage(page) {
      var app = this;
      axios.get('/api/v1/species?page=' + page).then(function(resp) {
        app.items = resp.data.data;
      }).catch(error => {
        console.log(error);
      });
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      Object.assign(this.editedItem, item);
      this.editedItem.species_description_content_reflection = this.editedItem.species_description;
      this.dialog_species = true;
    },

    deleteItem(item) {
      var app = this;
      const index = this.items.indexOf(item)
      if (confirm(this.$i18n.t('messages.sure_delete_question'))) {
        axios.delete('/api/v1/species/' + item.id).then(function (resp) {
          app.items.splice(index, 1);
        }).catch(function (resp) {
          alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.specie'));
        });
      }
    },

    selectTaxonomy(item) {
      this.dialog_species_taxonomy = true;
      this.editedIndex = this.items.indexOf(item);
      Object.assign(this.editedItem, item);
    },

    querySelections(v) {
      var app = this;
      app.species_selectors.loading_species = true;
      setTimeout(() => {
        if (v.split(" ").length > 1) {
          this.searchForAvailableTaxonomyInfo(v);
          app.species_selectors.loading_species = false;
        }
      }, 500)
    },

    searchForAvailableTaxonomyInfo(v) {
      var app = this;
      axios.get('/api/v1/species/search/' + v).then(function(resp) {
        console.log(resp.data);
        app.species_selectors.species = resp.data;
      }).catch(function(resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.species'));
      });
    },

    close() {
      this.dialog_species = false;
      this.dialog_species_taxonomy = false;
      setTimeout(() => {
        Object.assign(this.editedItem, this.defaultItem);
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
        this.editedItem.species_tax_id = this.editedItem.taxonomy_group.id;
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
      axios.post('/api/v1/species', this.editedItem).then(function (resp) {
        app.$router.push({path: '/admin/species'});
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.specie'));
      });
    },

    updateForm(speciesId) {
      var app = this;
      axios.patch('/api/v1/species/' + speciesId, this.editedItem).then(function (resp) {
        app.$router.replace('/admin/species');
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.specie'));
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
