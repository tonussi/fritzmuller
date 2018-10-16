console.log(localStorage.getItem('locale'))

var getSystemLang = function(locales) {
 var lang = document.documentElement.lang;
 if (localStorage.getItem('locale') === undefined) {
   return lang;
 }
 const localesList = Object.keys(locales);
 // console.log(localStorage.getItem('locale'));
 // console.log(localesList);
 // console.log(localStorage.getItem('locale') in localesList);
 var aux = localStorage.getItem('locale');
 for(var key in localesList) {
   if (aux === localesList[key]) {
     return aux;
   } else {
     return lang;
   }
 }
}

export default {
  getSystemLang
}
