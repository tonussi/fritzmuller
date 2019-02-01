<?php
namespace App\Http\Controllers\Api\V1;

header("Access-Control-Allow-Origin: *");

use App\Http\Controllers\Controller;

class CatalogOfLifeService extends Controller
{
    public function index($taxon, $limit = 10) {
        $url = "http://webservice.catalogueoflife.org/col/webservice?name=" . urlencode($taxon);
        $str = $this->get_remote_data($url);
        $xml = simplexml_load_string($str);
        return json_encode($xml);
    }

    // public function index($taxon, $limit = 10)
    // {
    //     $aux = explode(" ", $taxon);
    //     $matches_more_info = array();
    //     $matches_photos = array();
    //     $url = "http://www.catalogueoflife.org/col/search/all/key/" . urlencode($aux[0]) . "/fossil/1/match/1";
    //     $str = $this->get_remote_data($url);
    //     $re_more_info = '/\/col\/details\/species\/id\/([a-zA-Z0-9\-]+)\/([a-zA-Z0-9\-]+)/m';
    //     preg_match_all($re_more_info, $str, $matches_more_info, PREG_OFFSET_CAPTURE);
    //     $matches_more_info = array_slice($matches_more_info[0], 0, $limit);
    //     $arr = array();
    //     foreach ($matches_more_info as $key => $value) {
    //         array_push($arr, ['info' => 'http://www.catalogueoflife.org' . $matches_more_info[$key][0]]);
    //     }
    //     return $arr;
    // }

    public function get_remote_data($url, $post_paramtrs = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        if ($post_paramtrs) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "var1=bla&" . $post_paramtrs);
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
        curl_setopt($curl, CURLOPT_COOKIE, 'CookieName1=Value;');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);

        $follow_allowed = (ini_get('open_basedir') || ini_get('safe_mode')) ? false : true;

        if ($follow_allowed) {
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        }

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 9);
        curl_setopt($curl, CURLOPT_REFERER, $url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');

        $data = curl_exec($curl);
        $status = curl_getinfo($curl);

        curl_close($curl);
        preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si', $status['url'], $link);

        $data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si', '$1=$2' . $link[0] . '$3$4$5', $data);
        $data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si', '$1=$2' . $link[1] . '://' . $link[3] . '$3$4$5', $data);

        if ($status['http_code'] == 200) {
            return $data;
        } elseif ($status['http_code'] == 301 || $status['http_code'] == 302) {
            if (!$follow_allowed) {

                if (empty($redirURL)) {
                    if (!empty($status['redirect_url'])) {
                        $redirURL = $status['redirect_url'];
                    }
                }

                if (empty($redirURL)) {
                    preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
                    if (!empty($m[2])) {
                        $redirURL = $m[2];
                    }
                }

                if (empty($redirURL)) {
                    preg_match('/href\=\"(.*?)\"(.*?)here\<\/a\>/si', $data, $m);
                    if (!empty($m[1])) {
                        $redirURL = $m[1];
                    }
                }

                if (!empty($redirURL)) {
                    $t = debug_backtrace();
                    return call_user_func($t[0]["function"], trim($redirURL), $post_paramtrs);
                }
            }
        }
        return "ERRORCODE22 with $url!!<br/>Last status codes<b/>:" . json_encode($status) . "<br/><br/>Last data got<br/>:$data";
    }
}
