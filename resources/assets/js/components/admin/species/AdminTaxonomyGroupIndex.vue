<template>
  <v-card style="padding-top:60px;">
    <v-dialog fullscreen transition="dialog-bottom-transition" :overlay="false" scrollable v-model="dialog_fauna" max-width="500px">
      <v-btn color="primary" dark slot="activator" class="mb-2" @click.native="clean">
        <v-icon>brush</v-icon>
        {{ $t("taxonomy.create") }}
      </v-btn>
      <v-card>
        <v-card-title>
          <span class="headline">{{ formTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form ref="form_taxonomy_group" lazy-validation>
              <v-layout row wrap>
                <v-flex xs12 sm6 md4>
                  <v-header>{{ editedItem.taxonomy_rank_kingdom }}</v-header>
                  <v-text-field v-model="editedItem.kingdom_id"
                    :label="$t('taxonomy.kingdom') + ': ' +  editedItem.taxonomy_rank_kingdom">
                  </v-text-field>
                  <v-autocomplete
                    :loading="taxonomy_rank_selector.taxonomy_rank_kingdom.loading_rank_names" 
                    :items="taxonomy_rank_selector.taxonomy_rank_kingdom.items" 
                    :search-input.sync="taxonomy_rank_selector.taxonomy_rank_kingdom.searchable_rank_names" 
                    v-model="taxonomy_rank_selector.taxonomy_rank_kingdom.rank_name"
                    :label="$t('taxonomy.kingdom')" 
                    cache-items chips required>
                  </v-autocomplete>
                </v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs12 sm6 md4>
                  <v-header>{{ editedItem.taxonomy_rank_phylum }}</v-header>
                  <v-text-field v-model="editedItem.phylum_id"
                    :label="$t('taxonomy.phylum') + ': ' +  editedItem.taxonomy_rank_phylum">
                  </v-text-field>
                  <v-autocomplete
                    :loading="taxonomy_rank_selector.taxonomy_rank_phylum.loading_rank_names" 
                    :items="taxonomy_rank_selector.taxonomy_rank_phylum.items" 
                    :search-input.sync="taxonomy_rank_selector.taxonomy_rank_phylum.searchable_rank_names" 
                    v-model="taxonomy_rank_selector.taxonomy_rank_phylum.rank_name"
                    :label="$t('taxonomy.phylum')"
                    cache-items 
                    chips
                    required>
                  </v-autocomplete>
                </v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs12 sm6 md4>
                  <v-header>{{ editedItem.taxonomy_rank_class }}</v-header>
                  <v-text-field v-model="editedItem.class_id"
                    :label="$t('taxonomy.class') + ': ' +  editedItem.taxonomy_rank_class">
                  </v-text-field>
                  <v-autocomplete
                    :loading="taxonomy_rank_selector.taxonomy_rank_class.loading_rank_names" 
                    :items="taxonomy_rank_selector.taxonomy_rank_class.items" 
                    :search-input.sync="taxonomy_rank_selector.taxonomy_rank_class.searchable_rank_names" 
                    v-model="taxonomy_rank_selector.taxonomy_rank_class.rank_name"
                    :label="$t('taxonomy.class')"
                    cache-items
                    chips 
                    required>
                  </v-autocomplete>
                </v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs12 sm6 md4>
                  <v-header>{{ editedItem.taxonomy_rank_order }}</v-header>
                  <v-text-field v-model="editedItem.order_id"
                    :label="$t('taxonomy.order') + ': ' +  editedItem.taxonomy_rank_order">
                  </v-text-field>
                  <v-autocomplete
                    :loading="taxonomy_rank_selector.taxonomy_rank_order.loading_rank_names" 
                    :items="taxonomy_rank_selector.taxonomy_rank_order.items" 
                    :search-input.sync="taxonomy_rank_selector.taxonomy_rank_order.searchable_rank_names" 
                    v-model="taxonomy_rank_selector.taxonomy_rank_order.rank_name"
                    :label="$t('taxonomy.order')"
                    cache-items
                    chips 
                    required>
                  </v-autocomplete>
                </v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs12 sm6 md4>
                  <v-header>{{ editedItem.taxonomy_rank_family }}</v-header>
                  <v-text-field v-model="editedItem.family_id"
                    :label="$t('taxonomy.family') + ': ' +  editedItem.taxonomy_rank_family">
                  </v-text-field>
                  <v-autocomplete
                    :loading="taxonomy_rank_selector.taxonomy_rank_family.loading_rank_names" 
                    :items="taxonomy_rank_selector.taxonomy_rank_family.items" 
                    :search-input.sync="taxonomy_rank_selector.taxonomy_rank_family.searchable_rank_names" 
                    v-model="taxonomy_rank_selector.taxonomy_rank_family.rank_name"
                    :label="$t('taxonomy.family')"
                    cache-items 
                    chips
                    required>
                  </v-autocomplete>
                </v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs12 sm6 md4>
                  <v-header>{{ editedItem.taxonomy_rank_genus }}</v-header>
                  <v-text-field v-model="editedItem.genus_id"
                    :label="$t('taxonomy.genus') + ': ' +  editedItem.taxonomy_rank_genus">
                  </v-text-field>
                  <v-autocomplete
                    :loading="taxonomy_rank_selector.taxonomy_rank_genus.loading_rank_names" 
                    :items="taxonomy_rank_selector.taxonomy_rank_genus.items" 
                    :search-input.sync="taxonomy_rank_selector.taxonomy_rank_genus.searchable_rank_names" 
                    v-model="taxonomy_rank_selector.taxonomy_rank_genus.rank_name"
                    :label="$t('taxonomy.genus')"
                    cache-items
                    chips 
                    required>
                  </v-autocomplete>
                </v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs12 sm6 md4>
                  <v-header>{{ editedItem.taxonomy_rank_specie }}</v-header>
                  <v-text-field v-model="editedItem.specie_id"
                    :label="$t('taxonomy.species') + ': ' +  editedItem.taxonomy_rank_specie">
                  </v-text-field>
                  <v-autocomplete
                    :loading="taxonomy_rank_selector.taxonomy_rank_specie.loading_rank_names" 
                    :items="taxonomy_rank_selector.taxonomy_rank_specie.items" 
                    :search-input.sync="taxonomy_rank_selector.taxonomy_rank_specie.searchable_rank_names" 
                    v-model="taxonomy_rank_selector.taxonomy_rank_specie.rank_name"
                    :label="$t('taxonomy.species')"
                    autocomplete 
                    cache-items
                    chips
                    required>
                  </v-autocomplete>
                </v-flex>
              </v-layout>
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
      {{ $t("taxonomy.show") }}
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
        <td class="text-xs-center">{{ props.item.taxonomy_rank_kingdom.rank_name }}</td>
        <td class="text-xs-center">{{ props.item.taxonomy_rank_phylum.rank_name }}</td>
        <td class="text-xs-center">{{ props.item.taxonomy_rank_class.rank_name }}</td>
        <td class="text-xs-center">{{ props.item.taxonomy_rank_order.rank_name }}</td>
        <td class="text-xs-center">{{ props.item.taxonomy_rank_family.rank_name }}</td>
        <td class="text-xs-center">{{ props.item.taxonomy_rank_genus.rank_name }}</td>
        <td class="text-xs-center">{{ props.item.taxonomy_rank_specie.rank_name }}</td>
        <td class="justify-center layout px-0">
          <v-btn icon class="mx-0" @click="editItem(props.item)">
            <v-icon color="teal">edit</v-icon>
          </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink">delete</v-icon>
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
      dialog_fauna: false,
      editedIndex: -1,
      applocale: 'pt-br',
      pages: 0,
      dialog_species_taxonomy: false,
      fauna_search_subspecies: null,
      searchable_kingdom_rank_name: null,
      searchable_phylum_rank_name: null,
      searchable_class_rank_name: null,
      searchable_order_rank_name: null,
      searchable_family_rank_name: null,
      searchable_genus_rank_name: null,
      searchable_specie_rank_name: null,
      taxonomy_rank_selector: {
        taxonomy_rank_kingdom: {
          loading_rank_names: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_phylum: {
          loading_rank_names: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_class: {
          loading_rank_names: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_order: {
          loading_rank_names: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_family: {
          loading_rank_names: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_genus: {
          loading_rank_names: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_specie: {
          loading_rank_names: false,
          rank_name: '',
          items: []
        },
      },
      pagination: {
        page: null,
        totalItems: null,
        rowsPerPage: null
      },
      headers: [
        {
          text: this.$i18n.t('taxonomy.kingdom'),
          value: 'kingdom',
          sortable: true
        },
        {
          text: this.$i18n.t('taxonomy.phylum'),
          value: 'phylum',
          sortable: true
        },
        {
          text: this.$i18n.t('taxonomy.class'),
          value: 'class',
          sortable: true
        },
        {
          text: this.$i18n.t('taxonomy.order'),
          value: 'order',
          sortable: true
        },
        {
          text: this.$i18n.t('taxonomy.family'),
          value: 'family',
          sortable: true
        },
        {
          text: this.$i18n.t('taxonomy.genus'),
          value: 'genus',
          sortable: true
        },
        {
          text: this.$i18n.t('taxonomy.species'),
          value: 'species',
          sortable: true
        },
        {
          text: this.$i18n.t('messages.actions'),
          value: 'action',
          sortable: false
        }
      ],
      editedItem: {
        kingdom: undefined,
        phylum: undefined,
        class: undefined,
        order: undefined,
        family: undefined,
        genus: undefined,
        species: undefined
      },
      defaultItem: {
        kingdom: undefined,
        phylum: undefined,
        class: undefined,
        order: undefined,
        family: undefined,
        genus: undefined,
        species: undefined
      }
    }
  },

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? this.$i18n.t('taxonomy.creating') : this.$i18n.t('taxonomy.editing')
    }
  },

  watch: {
    dialog_fauna(val) {
      val || this.close()
    },

    searchable_kingdom_rank_name(val) {
      val && this.queryKingdomRanks(val)
    },

    searchable_phylum_rank_name(val) {
      val && this.queryPhylumRanks(val)
    },

    searchable_class_rank_name(val) {
      val && this.queryClassRanks(val)
    },

    searchable_order_rank_name(val) {
      val && this.queryOrderRanks(val)
    },

    searchable_family_rank_name(val) {
      val && this.queryFamilyRanks(val)
    },

    searchable_genus_rank_name(val) {
      val && this.queryGenusRanks(val)
    },

    searchable_specie_rank_name(val) {
      val && this.querySpecieRanks(val)
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
      axios.get('/api/v1/taxonomy/groups').then(function(resp) {
        app.items = resp.data.data;
        app.pagination.page = resp.data.current_page;
        app.pagination.totalItems = resp.data.total;
        app.pagination.rowsPerPage = resp.data.per_page;
        app.pages = resp.data.last_page;
      }).catch(function(resp) {
        console.log(resp);
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.animals'));
      });
    },

    queryKingdomRanks() {
      var app = this;
      axios.get('/api/v1/rank/search/kingdom/' + val).then(function(resp) {
        taxonomy_rank_selector.taxonomy_rank_kingdom.items = resp.data;
      }).catch(error => {
        console.log(error);
      });
    },

    queryPhylumRanks() {
      var app = this;
      axios.get('/api/v1/rank/search/phylum/' + val).then(function(resp) {
        taxonomy_rank_selector.taxonomy_rank_phylum.items = resp.data;
      }).catch(error => {
        console.log(error);
      });
    },

    queryClassRanks() {
      var app = this;
      axios.get('/api/v1/rank/search/class/' + val).then(function(resp) {
        taxonomy_rank_selector.taxonomy_rank_class.items = resp.data;
      }).catch(error => {
        console.log(error);
      });
    },

    queryOrderRanks() {
      var app = this;
      axios.get('/api/v1/rank/search/order/' + val).then(function(resp) {
        taxonomy_rank_selector.taxonomy_rank_order.items = resp.data;
      }).catch(error => {
        console.log(error);
      });
    },

    queryFamilyRanks() {
      var app = this;
      axios.get('/api/v1/rank/search/family/' + val).then(function(resp) {
        taxonomy_rank_selector.taxonomy_rank_family.items = resp.data;
      }).catch(error => {
        console.log(error);
      });
    },

    queryGenusRanks() {
      var app = this;
      axios.get('/api/v1/rank/search/genus/' + val).then(function(resp) {
        taxonomy_rank_selector.taxonomy_rank_genus.items = resp.data;
      }).catch(error => {
        console.log(error);
      });
    },

    querySpecieRanks() {
      var app = this;
      axios.get('/api/v1/rank/search/specie/' + val).then(function(resp) {
        taxonomy_rank_selector.taxonomy_rank_specie.items = resp.data;
      }).catch(error => {
        console.log(error);
      });
    },

    nextPage(page) {
      var app = this;
      axios.get('/api/v1/taxonomy/groups?page=' + page).then(function(resp) {
        app.items = resp.data.data;
      }).catch(error => {
        console.log(error);
      });
    },

    editItem(item) {
      console.log(item);
      this.editedIndex = this.items.indexOf(item);
      Object.assign(this.editedItem, item);
      this.dialog_fauna = true;
    },

    deleteItem(item) {
      var app = this;
      const index = this.items.indexOf(item)
      if (confirm(this.$i18n.t('messages.sure_delete_question'))) {
        axios.delete('/api/v1/taxonomy/groups/' + item.id).then(function (resp) {
          app.items.splice(index, 1);
        }).catch(function (resp) {
          alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.animal'));
        });
      }
    },

    close() {
      this.dialog_fauna = false;
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

    clean() {
      Object.assign(this.editedItem, this.defaultItem);
    },

    createForm() {
      var app = this;
      axios.post('/api/v1/taxonomy/groups', this.editedItem).then(function (resp) {
        app.$router.push({path: '/admin/taxonomy/groups'});
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.animal'));
      });
    },

    updateForm(animalId) {
      var app = this;
      axios.patch('/api/v1/taxonomy/groups/' + animalId, this.editedItem).then(function (resp) {
        app.$router.replace('/admin/taxonomy/groups/');
      }).catch(function (resp) {
        alert(this.$i18n.t('alerts.could_not_load') + ' ' + this.$i18n.t('alerts.animal'));
      });
    }
  }
}
</script>
