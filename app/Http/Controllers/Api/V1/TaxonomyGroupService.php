<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\TaxonomyGroup;
use App\TaxonomyRankKingdom;
use App\TaxonomyRankPhylum;
use App\TaxonomyRankClass;
use App\TaxonomyRankOrder;
use App\TaxonomyRankFamily;
use App\TaxonomyRankGenus;
use App\TaxonomyRankSpecie;

class TaxonomyGroupService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objects = TaxonomyGroup::orderBy('updated_at', 'DESC')->paginate(15);
        foreach ($objects as $key => $value) {
            $value->taxonomyRankKingdom;
            $value->taxonomyRankPhylum;
            $value->taxonomyRankClass;
            $value->taxonomyRankOrder;
            $value->taxonomyRankFamily;
            $value->taxonomyRankGenus;
            $value->taxonomyRankSpecie;
        }
        return $objects;
    }

    public function bykingdom($value)
    {
        return TaxonomyRankKingdom::where('rank_name', 'LIKE', $value . '%')->get();
    }

    public function byphylum($value)
    {
        return TaxonomyRankPhylum::where('rank_name', 'LIKE', $value . '%')->get();
    }

    public function byclass($value)
    {
        return TaxonomyRankClass::where('rank_name', 'LIKE', $value . '%')->get();
    }

    public function byorder($value)
    {
        return TaxonomyRankOrder::where('rank_name', 'LIKE', $value . '%')->get();
    }

    public function byfamily($value)
    {
        return TaxonomyRankFamily::where('rank_name', 'LIKE', $value . '%')->get();
    }

    public function bygenus($value)
    {
        return TaxonomyRankGenus::where('rank_name', 'LIKE', $value . '%')->get();
    }

    public function byspecie($value)
    {
        return TaxonomyRankSpecie::where('rank_name', 'LIKE', $value . '%')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return;
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TaxonomyGroup::create($request->all());
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
        return TaxonomyGroup::findOrFail($id);
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
        //
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
        $object = TaxonomyGroup::findOrFail($id);
        $object->update($request->all());
        return $object;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = TaxonomyGroup::findOrFail($id);
        $object->delete();
        return;
    }
}
