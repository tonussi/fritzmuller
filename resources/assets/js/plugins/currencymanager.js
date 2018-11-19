const currencyCodes = [
 {
     "symbol": "$",
     "name": "US Dollar",
     "symbol_native": "$",
     "decimal_digits": 2,
     "rounding": 0,
     "code": "USD",
     "name_plural": "US dollars"
 },
 {
     "symbol": "CA$",
     "name": "Canadian Dollar",
     "symbol_native": "$",
     "decimal_digits": 2,
     "rounding": 0,
     "code": "CAD",
     "name_plural": "Canadian dollars"
 },
 {
     "symbol": "€",
     "name": "Euro",
     "symbol_native": "€",
     "decimal_digits": 2,
     "rounding": 0,
     "code": "EUR",
     "name_plural": "euros"
 },
 {
     "symbol": "R$",
     "name": "Real Brasileiro",
     "symbol_native": "R$",
     "decimal_digits": 2,
     "rounding": 0,
     "code": "BRL",
     "name_plural": "Brazilian reals"
}];

var getSystemCurrency = function() {
  return localStorage.getItem('currency');
}

var setSystemCurrency = function(v) {
  return localStorage.setItem('currency', v);
}

const currencymanager = {
  "currencyCodes": currencyCodes,
  "getSystemCurrency": getSystemCurrency,
  "setSystemCurrency": setSystemCurrency
}

export default currencymanager;
