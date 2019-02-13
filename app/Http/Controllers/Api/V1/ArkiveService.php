<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

class ArkiveService extends Controller
{
    public function index($taxon, $limit = 10)
    {
        $matches_more_info = array();
        $matches_photos = array();
        $url = "https://www.arkive.org/explore/images?q=" . urlencode($taxon);
        $str = CurlHelper::get_remote_data($url);
        $re_more_info = '/\/([a-zA-Z0-9\-]+)\/([a-zA-Z0-9\-]+)\/(image\-[a-zA-Z0-9\-]+)/m';
        $re_photos = '/[https\:\/\/]([^\"\']*\.jpe?g)/';
        preg_match_all($re_more_info, $str, $matches_more_info, PREG_OFFSET_CAPTURE);
        preg_match_all($re_photos, $str, $matches_photos, PREG_OFFSET_CAPTURE);
        $matches_more_info = array_slice($matches_more_info[0], 0, $limit);
        $matches_photos = array_slice($matches_photos[0], 0, $limit);
        $arr = array();
        foreach ($matches_more_info as $key => $value) {
            try {
                array_push($arr, ['img' => $matches_photos[$key][0],
                    'info' => 'https://www.arkive.org' . $matches_more_info[$key][0]
                ]);
            } catch (\Throwable $th) {
                continue;
            }
        }
        return $arr;
    }
}
