<template>
  <v-container grid-list-xl text-xs-center>
    <v-layout row wrap>
      <v-flex xs4 offset-xs4>
        <v-card-text ma-3 style="margin-top: 120px;">

          <v-card class="pa-4" :title="$t('auth.reset_password')">
            <v-form @submit.prevent="submit" @keydown="form.onKeydown($event)">
              <alert-success :form="form" :message="status"/>

              <div class="form-group row">
                <div class="col-md-7">
                  <v-text-field :label="$t('auth.email_addr')" v-model="form.email"
                    :class="{ 'is-invalid': form.errors.has('email') }"
                    class="form-control" type="email" name="email" readonly>
                  </v-text-field>
                  <has-error :form="form" field="email"/>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-7">
                  <v-text-field :label="$t('auth.password')" v-model="form.password"
                    :class="{ 'is-invalid': form.errors.has('auth.password') }"
                    class="form-control" type="password" name="password">
                  </v-text-field>
                  <has-error :form="form" field="password"/>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-7">
                  <v-text-field :label="$t('auth.confirm_password')" v-model="form.password_confirmation"
                    :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                    class="form-control" type="password" name="password_confirmation">
                  </v-text-field>
                  <has-error :form="form" field="password_confirmation"/>
                </div>
              </div>

              <div class="form-group row pt-5 pb-5">
                <div class="col-md-9 ml-md-auto">
                  <vue-recaptcha
                    ref="recaptcha"
                    @verify="onCaptchaVerified"
                    @expired="onCaptchaExpired"
                    size="invisible"
                    sitekey="GRECAPTCHA_SITE_KEY">
                  </vue-recaptcha>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-9 ml-md-auto">
                  <v-btn @click="submit" block color="cyan lighten-3" :loading="form.busy">
                    {{ $t('auth.reset_password') }}
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
import Form from 'vform';

export default {
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('reset_password') }
  },

  data: () => ({
    status: '',
    form: new Form({
      token: '',
      email: '',
      password: '',
      password_confirmation: '',
      recaptchaToken: null
    })
  }),

  created () {
    this.form.email = this.$route.query.email
    this.form.token = this.$route.params.token
  },

  methods: {
    async reset () {
      const { data } = await this.form.post('/api/password/reset')

      this.status = data.status

      this.form.reset()
    },

    submit () {
      this.$refs.recaptcha.execute()
    },

    onCaptchaVerified (recaptchaToken) {
      const self = this
      self.status = "submitting"
      self.$refs.recaptcha.reset()

      this.form.recaptchaToken = recaptchaToken
      this.reset().then((response) => {

        self.sucessfulServerResponse = response.data.message

      }).catch((err) => {

        self.serverError = getErrorMessage(err)

        // helper to get a displayable message to the user

        function getErrorMessage(err) {
          let responseBody

          responseBody = err.response

          if (!responseBody) {
            responseBody = err
          } else {
            responseBody = err.response.data || responseBody
          }

          return responseBody.message || JSON.stringify(responseBody)
        }

      }).then(() => {
        self.status = ""
      })
    },

    onCaptchaExpired () {
      this.$refs.recaptcha.reset()
      this.form.recaptchaToken = null
    }

  }
}
</script>
