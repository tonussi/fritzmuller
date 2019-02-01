<template>
  <v-container>
    <v-layout>
      <v-flex>
        <v-card-text style="margin-top: 120px;">
          <v-card class="pa-4" :title="$t('your_password')">
            <v-form @submit.prevent="update" @keydown="form.onKeydown($event)">
              <alert-success :form="form" :message="$t('password_updated')"/>

              <!-- Password -->
              <div class="form-group row">
                <v-subheader class="col-md-3 col-form-label text-md-right">{{ $t('auth.new_password') }}</v-subheader>
                  <v-text-field v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password"></v-text-field>
                  <has-error :form="form" field="password"/>
              </div>

              <!-- Password Confirmation -->
              <div class="form-group row">
                <v-subheader class="col-md-3 col-form-label text-md-right">{{ $t('auth.confirm_pass') }}</v-subheader>
                  <v-text-field v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation"></v-text-field>
                  <has-error :form="form" field="password_confirmation"/>
              </div>

              <!-- Submit Button -->
              <div class="form-group row">
                  <v-btn block color="pink lighten-3" :loading="form.busy">{{ $t('update') }}</v-btn>
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

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('messages.settings') }
  },

  data: () => ({
    form: new Form({
      password: '',
      password_confirmation: ''
    })
  }),

  methods: {
    async update () {
      await this.form.patch('/api/settings/password')

      this.form.reset()
    }
  }
}
</script>
