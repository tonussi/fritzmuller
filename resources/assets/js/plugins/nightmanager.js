var getSystemNightMode = function() {
  var aux = parseInt(localStorage.getItem('nightmode'));
  if (aux == NaN) {
    localStorage.setItem('nightmode', 0);
    aux = false;
  } else if (aux == 1) {
    aux = true;
  } else if (aux == 0) {
    aux = false;
  } else {
    aux = false;
  }
  return aux;
}

var setSystemNightMode = function(v) {
  if (v) localStorage.setItem('nightmode', 1);
  else localStorage.setItem('nightmode', 0);
}

const nightmanager = {
  "getSystemNightMode": getSystemNightMode,
  "setSystemNightMode": setSystemNightMode
}

export default nightmanager;
