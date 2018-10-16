<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Article;

class ArticleService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objects = Article::orderBy('updated_at', 'DESC')->paginate(15);
        // foreach ($objects as $key => $object_value) {
        //     $animals = $object_value->articlesanimals;
        //     foreach ($animals as $key2 => $species) {
        //         $animal = $species->animal;
        //     }
        //     $plants = $object_value->articlesplants;
        //     foreach ($plants as $key3 => $species) {
        //         $plant = $species->plant;
        //     }
        // }
        return $objects;
    }

    public function newest($limit=10)
    {
        $begin_date = (new \DateTime('2012-10-16'))->format('Y-m-d');
        $end_date = (new \DateTime())->format('Y-m-d');
        $range_array = array($begin_date, $end_date);
        return Article::whereBetween('publication_date', $range_array)->where('active', '=', true)->limit($limit)->get();
    }

    public function byid($id)
    {
        return Article::where('id', '=', $id)->where('active', '=', true)->get()->first();
    }

    public function advanced($begindate, $enddate)
    {
        $formated_begin_date = (new \DateTime($begindate))->format('Y-m-d');
        $formated_end_date = (new \DateTime($enddate))->format('Y-m-d');
        $range_array = array($formated_begin_date, $formated_end_date);
        return Article::whereBetween('publication_date', $range_array)->where('active', '=', true)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Article::create($request->all());
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Article::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $object = Article::findOrFail($id);
        $object->update($request->all());
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = Article::findOrFail($id);
        $object->delete();
        return;
    }
}
