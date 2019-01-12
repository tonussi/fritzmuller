<template>
  <v-container grid-list-xl text-xs-center>
    <v-layout row wrap>
      <v-flex xs4 offset-xs4>
        <v-card-text style="margin-top: 120px;">

          <v-card class="pa-4" :title="$t('auth.register')">
            <v-form @submit.prevent="register" @keydown="form.onKeydown($event)">
              <div class="form-group row">
                <div class="col-md-7">
                  <v-text-field :label="$t('auth.your_name')" v-model="form.name"
                    :class="{ 'is-invalid': form.errors.has('auth.your_name') }"
                    class="form-control" type="text" name="name">
                  </v-text-field>
                  <has-error :form="form" field="name"/>
                </div>
              </div>

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

              <!-- Ticket -->
              <div class="form-group row">
                <div class="col-md-7">
                  <v-text-field :label="$t('auth.ticket')" v-model="form.ticket_number"
                    :class="{ 'is-invalid': form.errors.has('ticket_number') }"
                    class="form-control" type="ticket_number" name="ticket_number">
                  </v-text-field>
                  <has-error :form="form" field="ticket_number"/>
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

              <!-- Password Confirmation -->
              <div class="form-group row">
                <div class="col-md-7">
                  <v-text-field :label="$t('auth.confirm_pass')" v-model="form.password_confirmation"
                    :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                    class="form-control" type="password" name="password_confirmation">
                  </v-text-field>
                  <has-error :form="form" field="password_confirmation"/>
                </div>
              </div>

              <div class="form-group row pt-5 pb-5">
                <div class="col-md-9 ml-md-auto">
                  <vue-recaptcha sitekey="6LdgDBYTAAAAAN6RpxiDWiK8GML7LaUdNZHrQLWS"></vue-recaptcha>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-7 offset-md-3 d-flex">
                  <!-- Submit Button -->
                  <v-btn @click="register" block color="cyan lighten-3" :loading="form.busy">
                    {{ $t('auth.register') }}
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
    return { title: this.$t('auth.register') }
  },

  data: () => ({
    form: new Form({
      name: '',
      email: '',
      ticket_number: '',
      password: '',
      password_confirmation: ''
    })
  }),

  components: { VueRecaptcha },

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Log in the user.
      const { data: { token } } = await this.form.post('/api/login')

      // Save the token.
      this.$store.dispatch('auth/saveToken', { token })

      // Update the user.
      await this.$store.dispatch('auth/updateUser', { user: data })

      // Redirect home.
      this.$router.push({ name: 'guestWelcomeIndex' })
    }
  }
}
</script>
