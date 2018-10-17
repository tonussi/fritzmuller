<template>
  <v-container grid-list-xl text-xs-center>
    <v-layout row wrap>
      <v-flex xs4 offset-xs4>
        <v-card-text style="margin-top: 120px;">

          <v-card class="pa-4" :title="$t('auth.login')">
            <v-form @submit.prevent="login" @keydown="form.onKeydown($event)">

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

              <!-- Password -->
              <div class="form-group row">
                <div class="col-md-7">
                  <v-text-field :label="$t('auth.password')" v-model="form.password"
                    :class="{ 'is-invalid': form.errors.has('password') }"
                    class="form-control" type="password" name="password">
                  </v-text-field>
                  <has-error :form="form" field="password"/>
                </div>
              </div>

              <!-- Remember Me -->
              <div class="form-group row">
                <div class="col-md-3"/>
                <div class="col-md-7 d-flex">
                  <v-checkbox v-model="remember" name="remember" :label="$t('auth.remember_me')">
                  </v-checkbox>
                </div>
              </div>

              <div class="form-group row pt-5 pb-5">
                <div class="col-md-9 ml-md-auto">
                  <vue-recaptcha
                    ref="recaptcha"
                    @verify="onCaptchaVerified"
                    @expired="onCaptchaExpired"
                    size="invisible"
                    sitekey="6LdgDBYTAAAAAN6RpxiDWiK8GML7LaUdNZHrQLWS"></vue-recaptcha>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-7 d-flex">
                  <!-- Submit Button -->
                  <v-btn @click="login" block color="cyan lighten-3">
                    {{ $t('auth.login') }}
                  </v-btn>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-7 d-flex">
                  <!-- Recover Button -->
                  <v-btn block color="pink lighten-3" :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                    {{ $t('auth.forgot_your_pass') }}
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
    return { title: this.$t('auth.login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  components: { VueRecaptcha },

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login')

      console.log(data)

      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })

      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.$router.push({ name: 'guestWelcomeIndex' })
    }
  }
}
</script>
