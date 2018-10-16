<template>
  <v-container grid-list-xl text-xs-center>
    <v-layout row wrap>
      <v-flex xs4 offset-xs4>
        <v-card-text ma-3 style="margin-top: 120px;">

          <v-card class="pa-4" :title="$t('auth.reset_pass')">
            <v-form @submit.prevent="send" @keydown="form.onKeydown($event)">
              <alert-success :form="form" :message="status"/>

              <!-- Email -->
              <div class="form-group row">
                <div class="col-md-7">
                  <v-text-field :label="$t('auth.email_addr')" v-model="form.email"
                    :class="{ 'is-invalid': form.errors.has('email') }"
                    class="form-control" type="email" name="email">
                  </v-text-field>
                  <has-error :form="form" field="email"/>
                </div>
              </div>

              <div class="form-group row pt-5 pb-5">
                <div class="col-md-9 ml-md-auto">
                  <vue-recaptcha sitekey="6LdgDBYTAAAAAN6RpxiDWiK8GML7LaUdNZHrQLWS"></vue-recaptcha>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="form-group row">
                <div class="col-md-9 ml-md-auto">
                  <v-btn block color="cyan lighten-3" :loading="form.busy">
                    {{ $t('auth.send_pass_reset_link') }}
                  </v-btn>
                </div>
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
import VueRecaptcha from 'vue-recaptcha';

export default {
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('auth.reset_pass') }
  },

  data: () => ({
    status: '',
    form: new Form({
      email: ''
    })
  }),

  components: { VueRecaptcha },

  methods: {
    async send () {
      const { data } = await this.form.post('/api/password/email')

      this.status = data.status

      this.form.reset()
    }
  }
}
</script>
