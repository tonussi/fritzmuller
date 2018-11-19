var localeCodes = [
  {
    "code": 'en-US',
    "name": 'English (United States)'
  },
  {
    "code": 'pt-BR',
    "name": 'Português (Brasileiro)'
  }
]

var getSystemLocale = function() {
  var aux = localStorage.getItem('locale');

  if (aux === null) {
    localStorage.setItem('locale', 'pt-BR');
    return 'pt-BR';
  }

  return aux;
}

var setSystemLocale = function(v) {
  return localStorage.setItem('locale', v);
}

const localemanage = {
  "localeCodes": localeCodes,
  "getSystemLocale": getSystemLocale,
  "setSystemLocale": setSystemLocale
}

export default localemanage;
