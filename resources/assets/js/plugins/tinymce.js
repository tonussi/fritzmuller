import Vue from 'vue';
import tinymce from 'tinymce/tinymce';
import VueTinymce from 'vue-tinymce';

import 'tinymce/themes/modern';
import 'tinymce/plugins/advlist';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/link';
import 'tinymce/plugins/image';
import 'tinymce/plugins/hr';
import 'tinymce/plugins/anchor';
import 'tinymce/plugins/pagebreak';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/wordcount';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/visualchars';
import 'tinymce/plugins/code';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/insertdatetime';
import 'tinymce/plugins/media';
import 'tinymce/plugins/nonbreaking';
import 'tinymce/plugins/save';
import 'tinymce/plugins/table';
import 'tinymce/plugins/contextmenu';
import 'tinymce/plugins/directionality';
import 'tinymce/plugins/emoticons';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/textcolor';
import 'tinymce/plugins/colorpicker';
import 'tinymce/plugins/textpattern';

import 'tinymce/skins/lightgray/skin.min.css';
import 'tinymce/skins/lightgray/content.min.css';

Vue.use(tinymce);
Vue.use(VueTinymce);

function setupTinyMceConfig(selector_id) {
 var editor_tiny_mce = {
  options: {
   selector: selector_id,
   width: 842,
   height: 1191,
   browser_spellcheck: true,
   forced_root_block: false,
   force_p_newlines: false,
   force_br_newlines: true,
   plugins: [
    "advlist lists link image hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen",
    "insertdatetime media nonbreaking save table contextmenu directionality",
    "emoticons paste textcolor colorpicker textpattern"
   ],
   toolbar: "insertfile undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
   relative_urls: false,
   file_browser_callback: function (field_name, url, type, win) {
    var x = window.innerWidth ||
     document.documentElement.clientWidth ||
     document.getElementsByTagName('body')[0].clientWidth;
    var y = window.innerHeight ||
     document.documentElement.clientHeight ||
     document.getElementsByTagName('body')[0].clientHeight;

    var cmsURL = '/laravel-filemanager?field_name=' + field_name;

    if (type == 'image') {
     cmsURL = cmsURL + "&type=Images";
    } else {
     cmsURL = cmsURL + "&type=Files";
    }

    tinyMCE.activeEditor.windowManager.open({
     file: cmsURL,
     title: 'Filemanager',
     width: x * 0.8,
     height: y * 0.8,
     resizable: "yes",
     close_previous: "no"
    });
   }
  }
 }
 return editor_tiny_mce;
}

export default setupTinyMceConfig;
