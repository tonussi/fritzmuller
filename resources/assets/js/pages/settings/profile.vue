<template>
  <v-container>
    <v-layout>
      <v-flex>
        <v-card-text style="margin-top: 120px;">
          <v-card class="pa-4" :title="$t('your_info')">
            <v-form @submit.prevent="update" @keydown="form.onKeydown($event)">
              <alert-success :form="form" :message="$t('messages.info_updated')"/>

              <!-- Name -->
              <div class="form-group row">
                <v-subheader class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</v-subheader>
                  <v-text-field v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name"></v-text-field>
                  <has-error :form="form" field="name"/>
              </div>

              <!-- Email -->
              <div class="form-group row">
                <v-subheader class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</v-subheader>
                  <v-text-field v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email"></v-text-field>
                  <has-error :form="form" field="email" />
              </div>

              <!-- Submit Button -->
              <div class="form-group row">
                  <v-btn block color="pink lighten-3" :loading="form.busy" type="success">{{ $t('update') }}</v-btn>
              </div>
            </v-form>
          </v-card>
        </v-card-text>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('messages.settings') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/api/settings/profile')

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>
