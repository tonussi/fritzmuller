const currencyCodes = [
 {
     "name": "US Dollar",
     "code": "USD"
 },
 {
     "name": "Canadian Dollar",
     "code": "CAD"
 },
 {
     "name": "Euro",
     "code": "EUR"
 },
 {
     "name": "Real Brasileiro",
     "code": "BRL"
 }
];

var getSystemCurrency = function() {
  var aux = localStorage.getItem('currency');

  if (aux === null) {
    localStorage.setItem('currency', 'BRL');
    return 'BRL';
  }

  return aux;
}

var setSystemCurrency = function(v) {
  localStorage.setItem('currency', v);
}

const currencymanager = {
  "currencyCodes": currencyCodes,
  "getSystemCurrency": getSystemCurrency,
  "setSystemCurrency": setSystemCurrency
}

export default currencymanager;
