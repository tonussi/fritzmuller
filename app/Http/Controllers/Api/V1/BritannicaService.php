<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

class BritannicaService extends Controller
{
    public function index($taxon, $limit = 10)
    {
        $url = "https://www.britannica.com/search?query=" . urlencode($taxon);
        
        $matches_more_info = array();
        $str = CurlHelper::get_remote_data($url);
        $re_more_info = "/(https\:\/\/www\.britannica\.com\/animal\/[\s-()a-zA-Z0-9]+)/";
        preg_match_all($re_more_info, $str, $matches_more_info, PREG_OFFSET_CAPTURE);
        $matches_more_info = array_slice($matches_more_info[0], 0, $limit);
        
        $matches_photos = array();
        $str2 = CurlHelper::get_remote_data($matches_more_info[0][0]);
        $re_more_info2 = "/(https\:\/\/cdn\.britannica\.com\/\d+\/[\s-()a-zA-Z0-9.jpg]+)/";
        preg_match_all($re_more_info2, $str2, $matches_photos, PREG_OFFSET_CAPTURE);
        $matches_photos = array_slice($matches_photos[0], 0, $limit);

        for ($i=0; $i < sizeof($matches_photos); $i++) {
            $matches_photos[$i]['img'] = $matches_photos[$i][0];
            $matches_photos[$i]['info'] = $matches_more_info[0][0];
        }

        return $matches_photos;
    }
}
