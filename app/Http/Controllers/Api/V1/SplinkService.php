<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

class SplinkService extends Controller
{
    public function index($taxon, $offset = 0, $limit = 10)
    {
        $matches_source_imgs = array();
        $matches_viewers = array();
        $url = "http://www.splink.org.br/showImages?ts_any=" . urlencode($taxon) . "&extra=withImages&search_id=2&search_seq=8&size=thumb&offset=" . $offset;
        $str = CurlHelper::get_remote_data($url);
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
}
