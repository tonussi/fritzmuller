<template>
  <v-card style="padding-top:60px;">
    <v-dialog fullscreen transition="dialog-bottom-transition" :overlay="false" scrollable v-model="dialog_merchan" max-width="500px">
      <v-btn color="primary" dark slot="activator" class="mb-2" @click.native="clean">
        <v-icon>brush</v-icon>
        {{ $t("runningactivities.create") }}
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form" lazy-validation>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t("runningactivities.title") }}</v-subheader>
                <v-text-field v-model="editedItem.title"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t("runningactivities.activity_description") }}</v-subheader>
                <v-text-field v-model="editedItem.activity_description"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t("runningactivities.link") }}</v-subheader>
                <v-text-field v-model="editedItem.target_url"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t("runningactivities.figure_path") }}</v-subheader>
                <v-text-field :title="$t('messages.pick_an_image')"
                              @click="setNewFirstLook(editedItem);"
                              v-model="editedItem.figure_path">
                </v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <!-- <v-subheader>{{ $t("runningactivities.active") }}</v-subheader> -->
                <!-- <v-text-field v-model="editedItem.active"></v-text-field> -->
                <v-subheader>{{ $t('messages.open_closed') }}</v-subheader>
                <v-switch v-model="editedItem.active"></v-switch>
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
      {{ $t("runningactivities.show") }}
      <v-spacer></v-spacer>
      <v-text-field
        append-icon="search"
        :label="$t('messages.search_by_title_description_only')"
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
        <td class="text-xs-left">{{ props.item.activity_description }}</td>
        <td class="text-xs-left">{{ props.item.target_url }}</td>
        <td width="50px" class="text-xs-left">
          <v-img :src="props.item.figure_path" height="60px"></v-img>
        </td>
        <td class="text-xs-right">
          <div v-if="props.item.active">
            <v-icon>far fa-eye</v-icon>
          </div>
          <div v-else>
            <v-icon>far fa-eye-slash</v-icon>
          </div>
        </td>
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" v-on:click="editItem(props.item, $event)">
            <v-icon color="teal">fas fa-edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" v-on:click="deleteItem(props.item, $event)">
            <v-icon color="pink">fas fa-trash-alt</v-icon>
          </v-btn>
        </td>
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
        {{ $t("messages.search_failed_part1") }} "{{ search }}" {{ $t("messages.search_failed_part2") }}.
      </v-alert>
    </v-data-table>
    <div class="text-xs-center pt-2">
      <v-pagination @input="nextpage" v-model="pagination.page" :length="pages"></v-pagination>
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
      dialog_merchan: false,
      editedIndex: -1,
      applocale: 'pt-br',
      pages: 0,
      urlobj: undefined,
      pagination: {
        page: null,
        totalItems: null,
        rowsPerPage: null
      },
      editor_tiny_mce: {
        options: {
          selector: "#activity_description",
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
          text: this.$i18n.t('runningactivities.title'),
          value: 'title'
        },
        {
          text: this.$i18n.t('runningactivities.activity_description'),
          value: 'description',
          sortable: false
        },
        {
          text: this.$i18n.t('runningactivities.link'),
          value: 'target_url'
        },
        {
          text: this.$i18n.t('runningactivities.figure_path'),
          value: 'date',
          sortable: false
        },
        {
          text: this.$i18n.t('runningactivities.active'),
          value: 'active',
          sortable: false
        },
        {
          text: this.$i18n.t('messages.actions'),
          value: 'actions',
          sortable: false
        }
      ],
      editedItem: {
        title: '',
        activity_description: '',
        target_url: '',
        figure_path: '',
        active: false,
        modal_date_check: false
      },
      defaultItem: {
        title: '',
        activity_description: '',
        target_url: '',
        figure_path: '',
        active: false,
        modal_date_check: false
      }
    }
  },

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? this.$i18n.t('runningactivities.creating') : this.$i18n.t('runningactivities.editing')
    }
  },

  watch: {
    dialog_merchan(val) {
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
      axios.get('/api/v1/merchandise').then(function(resp) {
        app.items = resp.data.data;
        app.pagination.page = resp.data.current_page;
        app.pagination.totalItems = resp.data.total;
        app.pagination.rowsPerPage = resp.data.per_page;
        app.pages = resp.data.last_page;
        console.log(resp.data);
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.merchandises'));
      });
    },

    nextpage(page) {
      var app = this;
      axios.get('/api/v1/merchandise?page=' + page).then(function(resp) {
        app.items = resp.data.data;
        console.log(app.items);
      }).catch(error => {
        console.log(error);
      });
    },

    editItem(item, event) {
      var app = this;
      event.preventDefault();
      this.editedIndex = app.items.indexOf(item)
      Object.assign(this.editedItem, item)
      this.dialog_merchan = true
    },

    deleteItem(item, event) {
      var app = this;
      event.preventDefault();
      const index = this.items.indexOf(item)
      if (confirm(this.$i18n.t('messages.sure_delete_question'))) {
        axios.delete('/api/v1/merchandise/' + item.id).then(function (resp) {
          app.items.splice(index, 1);
        }).catch(function (resp) {
          alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.merchandise'));
        });
      }
    },

    close() {
      this.dialog_merchan = false;
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

    createForm() {
      var app = this;
      console.log("create");
      axios.post('/api/v1/merchandise', this.editedItem).then(function (resp) {
        app.$router.push({path: '/admin/merchandise'});
      }).catch(function (resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.merchandise'));
      });
    },

    updateForm(objectId) {
      var app = this;
      console.log("update");
      axios.patch('/api/v1/merchandise/' + objectId, this.editedItem).then(function (resp) {
        app.$router.replace('/admin/merchandise');
      }).catch(function (resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.merchandise'));
      });
    },

    setNewFirstLook(item) {
      this.lfm({type: 'image', prefix: '/laravel-filemanager'}, function(url, path) {
        console.log(url);
        console.log(path);
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
