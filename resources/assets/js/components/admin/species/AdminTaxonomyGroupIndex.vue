<template>
  <v-card style="padding-top:60px;">
    <v-dialog v-model="dialog_editing_taxonomy" persistent>
      <v-btn color="primary" slot="activator" mb-2 @click.native="clean">
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
              <v-layout>
                <v-flex xs6>
                  <v-flex xs6>
                    <v-text-field v-model="editedItem.taxonomy_rank_kingdom.rank_name"
                      :label="$t('taxonomy.kingdom') + ': ' +  editedItem.taxonomy_rank_kingdom.rank_name">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field v-model="editedItem.taxonomy_rank_phylum.rank_name"
                      :label="$t('taxonomy.phylum') + ': ' +  editedItem.taxonomy_rank_phylum.rank_name">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field v-model="editedItem.taxonomy_rank_class.rank_name"
                      :label="$t('taxonomy.class') + ': ' +  editedItem.taxonomy_rank_class.rank_name">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field v-model="editedItem.taxonomy_rank_order.rank_name"
                      :label="$t('taxonomy.order') + ': ' +  editedItem.taxonomy_rank_order.rank_name">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field v-model="editedItem.taxonomy_rank_family.rank_name"
                      :label="$t('taxonomy.family') + ': ' +  editedItem.taxonomy_rank_family.rank_name">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field v-model="editedItem.taxonomy_rank_genus.rank_name"
                      :label="$t('taxonomy.genus') + ': ' +  editedItem.taxonomy_rank_genus.rank_name">
                    </v-text-field>
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field v-model="editedItem.taxonomy_rank_specie.rank_name"
                      :label="$t('taxonomy.species') + ': ' +  editedItem.taxonomy_rank_specie.rank_name">
                    </v-text-field>
                    <v-btn @click="get_catalog_of_life(editedItem.taxonomy_rank_specie.rank_name)">
                      {{ $t('messages.search_catalog_of_life') }}
                    </v-btn>
                    <v-card-text>
                      <a :href="catalog_of_life_link" target="_blank">{{catalog_of_life_link}}</a>
                    </v-card-text>
                  </v-flex>
                </v-flex>

                <v-flex xs6>
                  <h1>{{ $t('messages.help_search_fill') }}</h1> 
                  <v-flex xs6>
                    <v-autocomplete
                      :loading="taxonomy_rank_selector.taxonomy_rank_kingdom.loading"
                      :items="taxonomy_rank_selector.taxonomy_rank_kingdom.items"
                      :search-input.sync="searchable_kingdom_rank_name"
                      v-model="editedItem.taxonomy_rank_kingdom.rank_name"
                      :label="$t('taxonomy.kingdom')">
                    </v-autocomplete>
                  </v-flex>
                  <v-flex xs6>
                    <v-autocomplete
                      :loading="taxonomy_rank_selector.taxonomy_rank_phylum.loading"
                      :items="taxonomy_rank_selector.taxonomy_rank_phylum.items"
                      :search-input.sync="searchable_phylum_rank_name"
                      v-model="editedItem.taxonomy_rank_phylum.rank_name"
                      :label="$t('taxonomy.phylum')">
                    </v-autocomplete>
                  </v-flex>
                  <v-flex xs6>
                    <v-autocomplete
                      :loading="taxonomy_rank_selector.taxonomy_rank_class.loading"
                      :items="taxonomy_rank_selector.taxonomy_rank_class.items"
                      :search-input.sync="searchable_class_rank_name"
                      v-model="editedItem.taxonomy_rank_class.rank_name"
                      :label="$t('taxonomy.class')">
                    </v-autocomplete>
                  </v-flex>
                  <v-flex xs6>
                    <v-autocomplete
                      :loading="taxonomy_rank_selector.taxonomy_rank_order.loading"
                      :items="taxonomy_rank_selector.taxonomy_rank_order.items"
                      :search-input.sync="searchable_order_rank_name"
                      v-model="editedItem.taxonomy_rank_order.rank_name"
                      :label="$t('taxonomy.order')">
                    </v-autocomplete>
                  </v-flex>
                  <v-flex xs6>
                    <v-autocomplete
                      :loading="taxonomy_rank_selector.taxonomy_rank_family.loading"
                      :items="taxonomy_rank_selector.taxonomy_rank_family.items"
                      :search-input.sync="searchable_family_rank_name"
                      v-model="editedItem.taxonomy_rank_family.rank_name"
                      :label="$t('taxonomy.family')">
                    </v-autocomplete>
                  </v-flex>
                  <v-flex xs6>
                    <v-autocomplete
                      :loading="taxonomy_rank_selector.taxonomy_rank_genus.loading"
                      :items="taxonomy_rank_selector.taxonomy_rank_genus.items"
                      :search-input.sync="searchable_genus_rank_name"
                      v-model="editedItem.taxonomy_rank_genus.rank_name"
                      :label="$t('taxonomy.genus')">
                    </v-autocomplete>
                  </v-flex>
                  <v-flex xs6>
                    <v-autocomplete
                      :loading="taxonomy_rank_selector.taxonomy_rank_specie.loading"
                      :items="taxonomy_rank_selector.taxonomy_rank_specie.items"
                      :search-input.sync="searchable_specie_rank_name"
                      v-model="editedItem.taxonomy_rank_specie.rank_name"
                      :label="$t('taxonomy.species')">
                    </v-autocomplete>
                  </v-flex>
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
      dialog_editing_taxonomy: false,
      editedIndex: -1,
      applocale: 'pt-br',
      pages: 0,
      catalog_of_life_link: "",
      fauna_search_subspecies: null,
      searchable_kingdom_rank_name: '',
      searchable_phylum_rank_name: '',
      searchable_class_rank_name: '',
      searchable_order_rank_name: '',
      searchable_family_rank_name: '',
      searchable_genus_rank_name: '',
      searchable_specie_rank_name: '',
      taxonomy_rank_selector: {
        taxonomy_rank_kingdom: {
          loading: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_phylum: {
          loading: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_class: {
          loading: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_order: {
          loading: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_family: {
          loading: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_genus: {
          loading: false,
          rank_name: '',
          items: []
        },
        taxonomy_rank_specie: {
          loading: false,
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
          value: 'taxonomy_rank_kingdom.rank_name',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('taxonomy.phylum'),
          value: 'taxonomy_rank_phylum.rank_name',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('taxonomy.class'),
          value: 'taxonomy_rank_class.rank_name',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('taxonomy.order'),
          value: 'taxonomy_rank_order.rank_name',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('taxonomy.family'),
          value: 'taxonomy_rank_family.rank_name',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('taxonomy.genus'),
          value: 'taxonomy_rank_genus.rank_name',
          sortable: true,
          align: 'center'
        },
        {
          text: this.$i18n.t('taxonomy.species'),
          value: 'taxonomy_rank_species.rank_name',
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
        taxonomy_rank_kingdom: { rank_name: '' },
        taxonomy_rank_phylum: { rank_name: '' },
        taxonomy_rank_class: { rank_name: '' },
        taxonomy_rank_order: { rank_name: '' },
        taxonomy_rank_family: { rank_name: '' },
        taxonomy_rank_genus: { rank_name: '' },
        taxonomy_rank_specie: { rank_name: '' }
      },
      defaultItem: {
        taxonomy_rank_kingdom: { rank_name: 'Plantae' },
        taxonomy_rank_phylum: { rank_name: 'Tracheophyta' },
        taxonomy_rank_class: { rank_name: 'Magnoliopsida' },
        taxonomy_rank_order: { rank_name: 'Sapindales' },
        taxonomy_rank_family: { rank_name: 'Sapindaceae' },
        taxonomy_rank_genus: { rank_name: 'Litchi' },
        taxonomy_rank_specie: { rank_name: 'Litchi chinensis' }
      }
    }
  },

  computed: {
    formTitle () {
      return this.editedIndex === -1 ? this.$i18n.t('taxonomy.creating') : this.$i18n.t('taxonomy.editing')
    }
  },

  watch: {
    dialog_editing_taxonomy(val) {
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
      axios.get('/api/v1/taxonomy/group').then(function(resp) {
        app.items = resp.data.data;
        app.pagination.page = resp.data.current_page;
        app.pagination.totalItems = resp.data.total;
        app.pagination.rowsPerPage = resp.data.per_page;
        app.pages = resp.data.last_page;
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

    get_catalog_of_life(rank_name) {
      var app = this;
      axios.get('/api/v1/col/' + rank_name + '/1').then(function(resp) {
        app.catalog_of_life_link = resp.data.result[0].url;
      });
    },

    queryKingdomRanks(val) {
      this.queryRankName('/api/v1/rank/search/kingdom/', val, this.taxonomy_rank_selector.taxonomy_rank_kingdom)
    },

    queryPhylumRanks(val) {
      this.queryRankName('/api/v1/rank/search/phylum/', val, this.taxonomy_rank_selector.taxonomy_rank_phylum);
    },

    queryClassRanks(val) {
      this.queryRankName('/api/v1/rank/search/class/', val, this.taxonomy_rank_selector.taxonomy_rank_class);
    },

    queryOrderRanks(val) {
      this.queryRankName('/api/v1/rank/search/order/', val, this.taxonomy_rank_selector.taxonomy_rank_order);
    },

    queryFamilyRanks(val) {
      this.queryRankName('/api/v1/rank/search/family/', val, this.taxonomy_rank_selector.taxonomy_rank_family);
    },

    queryGenusRanks(val) {
      this.queryRankName('/api/v1/rank/search/genus/', val, this.taxonomy_rank_selector.taxonomy_rank_genus);
    },

    querySpecieRanks(val) {
      this.queryRankName('/api/v1/rank/search/specie/', val, this.taxonomy_rank_selector.taxonomy_rank_specie);
    },

    nextPage(page) {
      var app = this;
      axios.get('/api/v1/taxonomy/group?page=' + page).then(function(resp) {
        app.items = resp.data.data;
      });
    },

    editItem(item) {
      this.editedIndex = this.items.indexOf(item);
      this.catalog_of_life_link = '';
      Object.assign(this.editedItem, item);
      this.dialog_editing_taxonomy = true;
    },

    deleteItem(item) {
      var app = this;
      const index = this.items.indexOf(item);
      if (confirm(this.$i18n.t('messages.sure_delete_question'))) {
        axios.delete('/api/v1/taxonomy/group/' + item.id).then(function (resp) {
          app.items.splice(index, 1);
        });
      }
    },

    close() {
      this.dialog_editing_taxonomy = false;
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
        this.createForm();
        this.items.push(this.editedItem);
      }
      this.close();
    },

    createForm() {
      var app = this;
      axios.post('/api/v1/taxonomy/group', this.editedItem).then(function (resp) {
        app.$router.replace('/admin/taxonomy');
      });
    },

    updateForm(id) {
      var app = this;
      axios.patch('/api/v1/taxonomy/group/' + id, this.editedItem).then(function (resp) {
        app.$router.replace('/admin/taxonomy');
      });
    }
  }
}
</script>
