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
  return localStorage.getItem('locale');
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
