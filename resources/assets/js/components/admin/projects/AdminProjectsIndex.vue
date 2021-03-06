<template>
  <v-card style="padding-top:60px;">
    <v-dialog v-model="dialog" persistent>
      <v-btn color="primary" slot="activator" mb-2 @click.native="clean">
        <v-icon>brush</v-icon>
        {{ $t("project.create") }}
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form" lazy-validation>
              <v-layout>
                <v-flex xs6>
                  <v-flex xs6>
                    <v-subheader>{{ $t("project.project_name") }}</v-subheader>
                    <v-text-field v-model="editedItem.project_name"></v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-subheader>{{ $t("project.figure_path") }}</v-subheader>
                    <v-text-field :title="$t('messages.pick_an_image')"
                                  @click="setNewFigurePath(editedItem);"
                                  v-model="editedItem.figure_path">
                    </v-text-field>
                  </v-flex>
                </v-flex>
                <v-flex xs6>
                  <v-subheader>{{ $t("project.project_description") }}</v-subheader>
                  <tinymce id="project_description"
                          v-model="editedItem.project_description"
                          :content='editedItem.project_description_reflection'
                          :options='editor_tiny_mce.options'>
                  </tinymce>
                </v-flex>
              </v-layout>
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
      {{ $t("project.show") }}
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
      :items="items"
      :search="search"
      hide-actions>
      <template slot="items" slot-scope="props">
        <td class="text-xs-center">{{ props.item.project_name }}</td>
        <td class="text-xs-center">{{ props.item.project_description.slice(0, 50) + ' ...' }}</td>
        <td class="text-xs-center" width="50px">
          <v-img :src="props.item.figure_path" height="60px"></v-img>
        </td>
        <td class="text-xs-center">
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
      dialog: false,
      editedIndex: -1,
      applocale: 'pt-br',
      pages: 0,
      pagination: {
        page: null,
        totalItems: null,
        rowsPerPage: null
      },
      editor_tiny_mce: {
        options: {
          selector: "#project_description",
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
          text: this.$i18n.t('project.project_name'),
          value: 'project_name',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('project.project_description'),
          sortable: false,
          align: 'center'
        },
        {
          text: this.$i18n.t('project.figure_path'),
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
        project_name: '',
        figure_path: '',
        project_description: '',
        project_description_reflection: '',
        modal_date_check: false
      },
      defaultItem: {
        project_name: '',
        figure_path: '',
        project_description: '',
        project_description_reflection: '',
        modal_date_check: false
      }
    }
  },

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? this.$i18n.t('project.creating') : this.$i18n.t('project.editing')
    }
  },

  watch: {
    dialog(val) {
      val || this.close()
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
      axios.get('/api/v1/projects').then(function(resp) {
        app.items = resp.data.data;
        app.pagination.page = resp.data.current_page;
        app.pagination.totalItems = resp.data.total;
        app.pagination.rowsPerPage = resp.data.per_page;
        app.pages = resp.data.last_page;
      });
    },

    nextPage(page) {
      var app = this;
      axios.get('/api/v1/projects?page=' + page).then(function(resp) {
        app.items = resp.data.data;
      });
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item)
      Object.assign(this.editedItem, item)
      this.editedItem.project_description_reflection = this.editedItem.project_description;
      this.dialog = true
    },

    deleteItem(item) {
      var app = this;
      const index = this.items.indexOf(item);
      if (confirm(this.$i18n.t('messages.sure_delete_question'))) {
        axios.delete('/api/v1/projects/' + item.id).then(function (resp) {
          app.items.splice(index, 1);
        });
      }
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        Object.assign(this.editedItem, this.defaultItem);
        this.editedIndex = -1;
      }, 300)
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
      axios.post('/api/v1/projects', this.editedItem).then(function (resp) {
        app.$router.push({path: '/admin/projects'});
      });
    },

    updateForm(articleId) {
      var app = this;
      axios.patch('/api/v1/projects/' + articleId, this.editedItem).then(function (resp) {
          app.$router.replace('/admin/projects');
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
