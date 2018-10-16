<?php
namespace App\Http\Controllers\Api\V1;

header("Access-Control-Allow-Origin: *");

use App\Http\Controllers\Controller;

class SplinkService extends Controller
{
    public function index($taxon, $offset = 0, $limit = 10)
    {
        $matches_source_imgs = array();
        $matches_viewers = array();
        $url = "http://www.splink.org.br/showImages?ts_any=" . urlencode($taxon) . "&extra=withImages&search_id=2&search_seq=8&size=thumb&offset=" . $offset;
        $str = $this->get_remote_data($url);
        preg_match_all('/http:\/\/reflora.cria.org.br\/inct\/exsiccatae\/image\/imagecode\/[a-zA-Z0-9\-\.]+\/size\/huge\/format\/jpeg/', $str, $matches_source_imgs, PREG_OFFSET_CAPTURE);
        preg_match_all('/http:\/\/reflora.cria.org.br\/inct\/exsiccatae\/viewer\/imagecode\/[a-zA-Z0-9\-\.]+\/style\/inct\/format\/slide/', $str, $matches_viewers, PREG_OFFSET_CAPTURE);
        $matches_source_imgs = array_splice($matches_source_imgs[0], 0, $limit);
        $matches_viewers = array_splice($matches_viewers[0], 0, $limit);
        $arr = array();
        foreach ($matches_source_imgs as $key => $value) {
            array_push($arr, ['img' => $matches_source_imgs[$key][0], 'info' => $matches_viewers[$key][0]]);
        }
        $matches_source_imgs = NULL;
        $matches_viewers = NULL;
        return $arr;
    }

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
