function cookieAgreementDialogChecker() {
  const aux = localStorage.getItem('cookie_concernment_and_agreement_law')
  if (aux === undefined) {
    return false;
  } else if (aux === "true") {
    return true;
  } else {
    return false;
  }
}

localStorage.setItem('cookie_concernment_and_agreement_law', true);

this.cookieLaw.dialog = !cookieAgreementDialogChecker();

export default (cookieLaw = {
  dialog: !cookieAgreementDialogChecker()
});
