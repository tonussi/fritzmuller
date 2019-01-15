import VueI18n from 'vue-i18n';
import Locales from '../vue-i18n-locales.generated.js';

const i18n = new VueI18n({
  locale: localStorage.getItem('locale'),
  messages: Locales
});

var elem = document.createElement('script');
elem.src = 'https://quantcast.mgr.consensu.org/cmp.js';
elem.async = true;
elem.type = "text/javascript";
var scpt = document.getElementsByTagName('script')[0];
scpt.parentNode.insertBefore(elem, scpt);
(function () {
  var gdprAppliesGlobally = true;
  function addFrame() {
    if (!window.frames['__cmpLocator']) {
      if (document.body) {
        var body = document.body,
          iframe = document.createElement('iframe');
        iframe.style = 'display:none';
        iframe.name = '__cmpLocator';
        body.appendChild(iframe);
      } else {
        // In the case where this stub is located in the head,
        // this allows us to inject the iframe more quickly than
        // relying on DOMContentLoaded or other events.
        setTimeout(addFrame, 5);
      }
    }
  }
  addFrame();
  function cmpMsgHandler(event) {
    var msgIsString = typeof event.data === "string";
    var json;
    if (msgIsString) {
      json = event.data.indexOf("__cmpCall") != -1 ? JSON.parse(event.data) : {};
    } else {
      json = event.data;
    }
    if (json.__cmpCall) {
      var i = json.__cmpCall;
      window.__cmp(i.command, i.parameter, function (retValue, success) {
        var returnMsg = {
          "__cmpReturn": {
            "returnValue": retValue,
            "success": success,
            "callId": i.callId
          }
        };
        event.source.postMessage(msgIsString ?
          JSON.stringify(returnMsg) : returnMsg, '*');
      });
    }
  }
  window.__cmp = function (c) {
    var b = arguments;
    if (!b.length) {
      return __cmp.a;
    }
    else if (b[0] === 'ping') {
      b[2]({
        "gdprAppliesGlobally": gdprAppliesGlobally,
        "cmpLoaded": false
      }, true);
    } else if (c == '__cmp')
      return false;
    else {
      if (typeof __cmp.a === 'undefined') {
        __cmp.a = [];
      }
      __cmp.a.push([].slice.apply(b));
    }
  }
  window.__cmp.gdprAppliesGlobally = gdprAppliesGlobally;
  window.__cmp.msgHandler = cmpMsgHandler;
  if (window.addEventListener) {
    window.addEventListener('message', cmpMsgHandler, false);
  }
  else {
    window.attachEvent('onmessage', cmpMsgHandler);
  }
})();
window.__cmp('init', {
  'Language': i18n.locale,
  'Initial Screen Title Text': i18n.t('consensu.initial_screen_title_text'),
  'Initial Screen Reject Button Text': i18n.t('consensu.initial_screen_reject_button_text'),
  'Initial Screen Accept Button Text': i18n.t('consensu.initial_screen_accept_button_text'),
  'Initial Screen Purpose Link Text': i18n.t('consensu.initial_screen_purpose_link_text'),
  'Purpose Screen Title Text': i18n.t('consensu.purpose_screen_title_text'),
  'Purpose Screen Body Text': i18n.t('consensu.purpose_screen_body_text'),
  'Purpose Screen Vendor Link Text': i18n.t('consensu.purpose_screen_vendor_link_text'),
  'Purpose Screen Cancel Button Text': i18n.t('consensu.purpose_screen_cancel_button_text'),
  'Purpose Screen Save and Exit Button Text': i18n.t('consensu.purpose_screen_save_and_exit_button_text'),
  'Vendor Screen Title Text': i18n.t('consensu.vendor_screen_title_text'),
  'Vendor Screen Body Text': i18n.t('consensu.vendor_screen_body_text'),
  'Vendor Screen Accept All Button Text': i18n.t('consensu.vendor_screen_accept_all_button_text'),
  'Vendor Screen Reject All Button Text': i18n.t('consensu.vendor_screen_reject_all_button_text'),
  'Vendor Screen Purposes Link Text': i18n.t('consensu.vendor_screen_purposes_link_text'),
  'Vendor Screen Cancel Button Text': i18n.t('consensu.vendor_screen_cancel_button_text'),
  'Vendor Screen Save and Exit Button Text': i18n.t('consensu.vendor_screen_save_and_exit_button_text'),
  'Initial Screen Body Text': i18n.t('consensu.initial_screen_body_text'),
  'Publisher Name': i18n.t('consensu.publisher_name'),

  'Initial Screen Body Text Option': 1,
  'Display UI': 'always',
  'Publisher Purpose IDs': [1, 5],
  'Consent Scope': 'service',
  'UI Layout': 'banner'
});
