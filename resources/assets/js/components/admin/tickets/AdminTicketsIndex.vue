<template>
  <v-card style="padding-top:60px;">
    <v-dialog fullscreen transition="dialog-bottom-transition" :overlay="false" scrollable v-model="dialog" max-width="500px">
      <v-btn color="primary" slot="activator" mb-2 @click.native="clean">
        <v-icon>brush</v-icon>
        {{ $t("ticket.create") }}
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form" lazy-validation>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t("ticket.ticket_number") }}</v-subheader>
                <v-chip>{{ editedItem.ticket_number }}</v-chip>
                <v-btn @click="generateRandomTicket(editedItem)" color="primary">{{ $t("ticket.generate_number") }}</v-btn>
              </v-flex>
              <v-flex xs12 sm6 md4>
                <v-subheader>{{ $t("ticket.user_creator_id") }}</v-subheader>
                <v-chip color="teal" text-color="white">{{ editedItem.user_creator_id }}
                  <v-avatar>
                    <v-icon>check_circle</v-icon>
                  </v-avatar>
                  {{ user.email }}
                </v-chip>
              </v-flex>
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
      {{ $t("ticket.show") }}
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
        <td class="text-xs-center">{{ props.item.ticket_number }}</td>
        <td class="text-xs-center">{{ props.item.user_creator_id }}</td>
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
      user: null,
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
      headers: [
        {
          text: this.$i18n.t('ticket.ticket_number'),
          value: 'ticket_number',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('ticket.user_creator_id'),
          value: 'user_creator_id',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('messages.actions'),
          sortable: false,
          align: 'center'
        }
      ],
      editedItem: {
        ticket_number: 0,
        user_creator_id: 0,
        modal_date_check: false
      },
      defaultItem: {
        ticket_number: 0,
        user_creator_id: 0,
        modal_date_check: false
      }
    }
  },

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? this.$i18n.t('ticket.creating') : this.$i18n.t('ticket.editing')
    }
  },

  watch: {
    dialog(val) {
      val || this.close()
    }
  },

  created() {
    this.initialize();
    this.getCurrentUser();
    const lang = document.documentElement.lang;
    this.applocale = lang;
  },

  methods: {
    initialize() {
      var app = this;
      axios.get('/api/v1/tickets').then(function(resp) {
        app.items = resp.data.data;
        app.pagination.page = resp.data.current_page;
        app.pagination.totalItems = resp.data.total;
        app.pagination.rowsPerPage = resp.data.per_page;
        app.pages = resp.data.last_page;
        console.log(resp.data);
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.tickets'));
      });
    },

    getCurrentUser() {
      var app = this;
      axios.get('/api/user').then(function(resp) {
        console.log(resp.data);
        app.user = resp.data;
      }).catch(function(resp) {
        console.log(resp);
      });
    },
  
    generateRandomTicket(item) {
      item.ticket_number = parseInt(Math.random() * 100000);
    },

    nextPage(page) {
      var app = this;
      axios.get('/api/v1/tickets?page=' + page).then(function(resp) {
        app.items = resp.data.data;
        console.log(app.items);
      }).catch(error => {
        console.log(error);
      });
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item)
      Object.assign(this.editedItem, item)
      this.editedItem.ticket_description_reflection = this.editedItem.ticket_description;
      this.dialog = true
    },
   
    deleteItem(item) {
      var app = this;
      const index = this.items.indexOf(item)
      if (confirm(this.$i18n.t('messages.sure_delete_question'))) {
        axios.delete('/api/v1/tickets/' + item.id).then(function (resp) {
          app.items.splice(index, 1);
        }).catch(function (resp) {
          alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.ticket'));
        });
      }
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        Object.assign(this.editedItem, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
      this.initialize();
    },

    clean() {
      this.defaultItem.user_creator_id = this.user.id;
      this.generateRandomTicket(this.defaultItem);
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
      axios.post('/api/v1/tickets', this.editedItem).then(function (resp) {
        app.$router.push({path: '/admin/tickets'});
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.ticket'));
      });
    },

    updateForm(articleId) {
      var app = this;
      axios.patch('/api/v1/tickets/' + articleId, this.editedItem).then(function (resp) {
          app.$router.replace('/admin/tickets');
      }).catch(function (resp) {
          alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.ticket'));
      });
    }
  }
}
</script>
