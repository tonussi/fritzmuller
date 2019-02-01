function increaseFontSize(id, increaseFactor) {
  txt = document.getElementById(id);
  style = window.getComputedStyle(txt, null).getPropertyValue('font-size');
  currentSize = parseFloat(style);
  txt.style.fontSize = (currentSize + increaseFactor) + 'px';
}

module.exports = {
  increaseFontSize
}
