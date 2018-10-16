<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SpeciesDetail;

class SpeciesDetailService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objects = SpeciesDetail::orderBy('updated_at', 'DESC')->paginate(15);
        foreach ($objects as $key => $value) {
            $value->taxonomyGroup;
            $value->popularNames;
        }
        return $objects;
    }

    public function animalInfo($id)
    {
        $arr = array();
        $object = SpeciesDetail::where('id', '=', $id)->get();
        array_push($arr, [
            'info' => $object,
            'taxonomy' => $object->faunataxonomy()
        ]);
        return $arr;
    }

    public function parcial()
    {
        return SpeciesDetail::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        SpeciesDetail::create($request->all());
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
        return SpeciesDetail::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $object = SpeciesDetail::findOrFail($id);
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
        $object = SpeciesDetail::findOrFail($id);
        $object->delete();
        return;
    }
}
