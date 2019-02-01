function submit() {
  // this.status = "submitting";
  this.$refs.recaptcha.execute();
}

function onCaptchaVerified(recaptchaToken) {
  const self = this;
  self.status = "submitting";
  self.$refs.recaptcha.reset();

  axios.post('/api/login', {

    email: self.email,
    password: self.password,
    recaptchaToken: recaptchaToken

  }).then((response) => {

    self.sucessfulServerResponse = response.data.message;

  }).catch((err) => {

    self.serverError = getErrorMessage(err);

    function getErrorMessage(err) {

      let responseBody;
      responseBody = err.response;
      if (!responseBody) {
        responseBody = err;
      } else {
        responseBody = err.response.data || responseBody;
      }

      return responseBody.message || JSON.stringify(responseBody);

    }

  }).then(() => {

    self.status = "";

  });
}

function onCaptchaExpired() {
  this.$refs.recaptcha.reset();
}
