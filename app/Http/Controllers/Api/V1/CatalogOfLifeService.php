<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

class CatalogOfLifeService extends Controller
{
    public function index($taxon, $limit = 10) {
        $url = "http://webservice.catalogueoflife.org/col/webservice?name=" . urlencode($taxon);
        $str = CurlHelper::get_remote_data($url);
        $xml = simplexml_load_string($str);
        return json_encode($xml);
    }
}
