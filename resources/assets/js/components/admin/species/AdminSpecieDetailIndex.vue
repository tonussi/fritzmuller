<template>
  <v-card style="padding-top:60px;">
    <v-dialog v-model="dialog_species_taxonomy" persistent>
      <v-card>
        <v-card-title>
          <h1>{{ $t("species.selecting_species_taxonomy") }}</h1>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_tax_group" lazy-validation>
              <v-container fluid>
                <v-layout>
                  <v-flex>
                    <v-autocomplete
                      @keydown.enter.native.prevent
                      :loading="specie_selector.loading"
                      :items="specie_selector.items"
                      :search-input.sync="searchable_specie_rank_name"
                      :label="$t('species.species_selector')"
                      v-model="editedItem.new_specie_rank_name">
                    </v-autocomplete>
                    <v-card>
                      <v-layout row wrap>
                        <v-subheader>{{$t('species.new_specie_to_swap')}}</v-subheader>
                        <v-chip color="pink lighten-4">
                          {{editedItem.new_specie_rank_name}}
                        </v-chip>
                      </v-layout>
                      <v-divider></v-divider>
                      <v-layout row wrap>
                        <v-subheader>{{$t('species.current_specie_associated')}}</v-subheader>
                          <v-chip color="green lighten-4">
                            {{editedItem.taxonomy_group.taxonomy_rank_specie.rank_name}}
                          </v-chip>
                      </v-layout>
                    </v-card>
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
    <v-dialog v-model="dialog_species" persistent>
      <v-btn color="primary" slot="activator" mb-2 @click.native="clean">
        <v-icon>brush</v-icon>
        {{ $t("species.create") }}
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_species">
              <v-layout>
                <v-flex xs6>
                  <v-flex xs6>
                    <v-autocomplete
                      @keydown.enter.native.prevent
                      :loading="specie_selector.loading"
                      :items="specie_selector.items"
                      :search-input.sync="searchable_specie_rank_name"
                      :label="$t('species.species_selector')"
                      v-model="editedItem.new_specie_rank_name"
                      cache-items>
                    </v-autocomplete>
                    <v-card>
                      <v-flex>
                        <v-subheader>{{$t('species.new_specie_to_swap')}}</v-subheader>
                        <v-chip color="pink lighten-4">
                          {{editedItem.new_specie_rank_name}}
                        </v-chip>
                      </v-flex>
                    </v-card>
                  </v-flex>
                  <v-flex xs6>
                    <v-subheader>{{ $t("species.figure_path") }}</v-subheader>
                    <v-text-field @keydown.enter.native.prevent
                      @click="setNewFigurePath(editedItem);"
                      :title="$t('messages.pick_an_image')"
                      v-model="editedItem.figure_path">
                    </v-text-field>
                  </v-flex>
                </v-flex>
                <v-flex xs6>
                  <v-subheader>{{ $t("species.description") }}</v-subheader>
                  <tinymce id="specie_description" v-model="editedItem.specie_description"
                          :content="editedItem.specie_description_content_reflection"
                          :options="editor_tiny_mce.options">
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
        <td class="text-xs-center">{{ props.item.taxonomy_group.taxonomy_rank_specie.rank_name }}</td>
        <td class="text-xs-center">{{ props.item.specie_description.slice(0, 150) + ' ...' }}</td>
        <td width="50px" class="text-xs-center">
          <v-img :src="props.item.figure_path" height="60px"></v-img>
        </td>
        <td class="text-xs-center">
          <v-btn icon @click="selectTaxonomy(props.item)">
            <v-icon color="blue">fas fa-crow</v-icon>
          </v-btn>
          <v-btn icon @click="editItem(props.item)">
            <v-icon color="teal">fas fa-edit</v-icon>
          </v-btn>
          <v-btn icon @click="deleteItem(props.item)">
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
      searchable_specie_rank_name: '',
      specie_selector: {
        loading: false,
        rank_name: '',
        items: []
      },
      pagination: {
        page: null,
        totalItems: null,
        rowsPerPage: null
      },
      editor_tiny_mce: {
        options: {
          selector: "#specie_description",
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
          text: this.$i18n.t('taxonomy.species'),
          value: 'taxonomy_group.taxonomy_rank_specie.rank_name',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('species.description'),
          sortable: false,
          align: 'center'
        },
        {
          text: this.$i18n.t('species.figure_path'),
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
        figure_path: '',
        specie_description: '',
        specie_description_content_reflection: '',
        species_tax_id: undefined,
        taxonomy_group: { taxonomy_rank_specie: {} },
        new_specie_rank_name: '',
        modal_date_check: false
      },
      defaultItem: {
        figure_path: '',
        specie_description: '',
        specie_description_content_reflection: '',
        species_tax_id: undefined,
        taxonomy_group: { taxonomy_rank_specie: {} },
        new_specie_rank_name: '',
        modal_date_check: false
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
    searchable_specie_rank_name(val) {
      val && val !== this.editedItem.new_specie_rank_name && this.querySpecieRanks(val)
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
      });
    },

    nextPage(page) {
      var app = this;
      axios.get('/api/v1/species?page=' + page).then(function(resp) {
        app.items = resp.data.data;
      });
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      Object.assign(this.editedItem, item);
      this.editedItem.specie_description_content_reflection = this.editedItem.specie_description;
      this.dialog_species = true;
    },

    deleteItem(item) {
      var app = this;
      const index = this.items.indexOf(item)
      if (confirm(this.$i18n.t('messages.sure_delete_question'))) {
        axios.delete('/api/v1/species/' + item.id).then(function (resp) {
          app.items.splice(index, 1);
        });
      }
    },

    selectTaxonomy(item) {
      this.dialog_species_taxonomy = true;
      this.editedIndex = this.items.indexOf(item);
      Object.assign(this.editedItem, item);
    },

    async queryRankName(link, val, sel) {
      var app = this;
      axios.get(link + val).then(function(resp) {
        sel.loading = true;
        setTimeout(() => {
          if (resp.data[0]) {
            for (let index = 0; index < resp.data.length; index++) {
              const element = resp.data[index].rank_name;
              sel.items.push(element);
            }
          }
          sel.loading = false;
        }, 500);
      });
    },

    querySpecieRanks(val) {
      this.queryRankName('/api/v1/rank/search/specie/', val, this.specie_selector);
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
      });
    },

    updateForm(id) {
      var app = this;
      axios.patch('/api/v1/species/' + id, this.editedItem).then(function (resp) {
        app.$router.replace('/admin/species');
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
