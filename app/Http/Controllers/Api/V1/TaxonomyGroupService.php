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
        return TaxonomyRankKingdom::where('rank_name', 'LIKE', '%' . $value . '%')->get();
    }

    public function byphylum($value)
    {
        return TaxonomyRankPhylum::where('rank_name', 'LIKE', '%' . $value . '%')->get();
    }

    public function byclass($value)
    {
        return TaxonomyRankClass::where('rank_name', 'LIKE', '%' . $value . '%')->get();
    }

    public function byorder($value)
    {
        return TaxonomyRankOrder::where('rank_name', 'LIKE', '%' . $value . '%')->get();
    }

    public function byfamily($value)
    {
        return TaxonomyRankFamily::where('rank_name', 'LIKE', '%' . $value . '%')->get();
    }

    public function bygenus($value)
    {
        return TaxonomyRankGenus::where('rank_name', 'LIKE', '%' . $value . '%')->get();
    }

    public function byspecie($value)
    {
        return TaxonomyRankSpecie::where('rank_name', 'LIKE', '%' . $value . '%')->get();
    }

    private function findOrCreateKingdom($rank_name)
    {
        $rank = TaxonomyRankKingdom::where('rank_name', '=', $rank_name)->get()->first();
        if ($rank === null) $rank = TaxonomyRankKingdom::create(['rank_name' => $rank_name]);
        return $rank;
    }

    private function findOrCreatePhylum($rank_name)
    {
        $rank = TaxonomyRankPhylum::where('rank_name', '=', $rank_name)->get()->first();
        if ($rank === null) return TaxonomyRankPhylum::create(['rank_name' => $rank_name]);
        return $rank;
    }

    private function findOrCreateClass($rank_name)
    {
        $rank = TaxonomyRankClass::where('rank_name', '=', $rank_name)->get()->first();
        if ($rank === null) return TaxonomyRankClass::create(['rank_name' => $rank_name]);
        return $rank;
    }

    private function findOrCreateOrder($rank_name)
    {
        $rank = TaxonomyRankOrder::where('rank_name', '=', $rank_name)->get()->first();
        if ($rank === null) return TaxonomyRankOrder::create(['rank_name' => $rank_name]);
        return $rank;
    }

    private function findOrCreateFamily($rank_name)
    {
        $rank = TaxonomyRankFamily::where('rank_name', '=', $rank_name)->get()->first();
        if ($rank === null) return TaxonomyRankFamily::create(['rank_name' => $rank_name]);
        return $rank;
    }

    private function findOrCreateGenus($rank_name)
    {
        $rank = TaxonomyRankGenus::where('rank_name', '=', $rank_name)->get()->first();
        if ($rank === null) return TaxonomyRankGenus::create(['rank_name' => $rank_name]);
        return $rank;
    }

    private function findOrCreateSpecie($rank_name)
    {
        $rank = TaxonomyRankSpecie::where('rank_name', '=', $rank_name)->get()->first();
        if ($rank === null) return TaxonomyRankSpecie::create(['rank_name' => $rank_name]);
        return $rank;
    }

    private function findOrCreateKingdomById($id, $new_rank_name)
    {
        $rank = TaxonomyRankKingdom::findOrFail($id);
        return $rank->update(['rank_name' => $new_rank_name]);
    }

    private function findOrCreatePhylumById($id, $new_rank_name)
    {
        $rank = TaxonomyRankPhylum::findOrFail($id);
        return $rank->update(['rank_name' => $new_rank_name]);
    }

    private function findOrCreateClassById($id, $new_rank_name)
    {
        $rank = TaxonomyRankClass::findOrFail($id);
        return $rank->update(['rank_name' => $new_rank_name]);
    }

    private function findOrCreateOrderById($id, $new_rank_name)
    {
        $rank = TaxonomyRankOrder::findOrFail($id);
        return $rank->update(['rank_name' => $new_rank_name]);
    }

    private function findOrCreateFamilyById($id, $new_rank_name)
    {
        $rank = TaxonomyRankFamily::findOrFail($id);
        return $rank->update(['rank_name' => $new_rank_name]);
    }

    private function findOrCreateGenusById($id, $new_rank_name)
    {
        $rank = TaxonomyRankGenus::findOrFail($id);
        return $rank->update(['rank_name' => $new_rank_name]);
    }

    private function findOrCreateSpecieById($id, $new_rank_name)
    {
        $rank = TaxonomyRankSpecie::findOrFail($id);
        return $rank->update(['rank_name' => $new_rank_name]);
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
        $kingdom = $this->findOrCreateKingdom(
            $request['taxonomy_rank_kingdom']['rank_name']
        );

        $phylum = $this->findOrCreatePhylum(
            $request['taxonomy_rank_phylum']['rank_name']
        );

        $class = $this->findOrCreateClass(
            $request['taxonomy_rank_class']['rank_name']
        );

        $order = $this->findOrCreateOrder(
            $request['taxonomy_rank_order']['rank_name']
        );

        $family = $this->findOrCreateFamily(
            $request['taxonomy_rank_family']['rank_name']
        );

        $genus = $this->findOrCreateGenus(
            $request['taxonomy_rank_genus']['rank_name']
        );

        $specie = $this->findOrCreateSpecie(
            $request['taxonomy_rank_specie']['rank_name']
        );

        TaxonomyGroup::create([
            'kingdom_id' => $kingdom->id,
            'phylum_id' => $phylum->id,
            'class_id' => $class->id,
            'order_id' => $order->id,
            'family_id' => $family->id,
            'genus_id' => $genus->id,
            'specie_id' => $specie->id
        ]);
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

        $obj_kingdom = $this->findOrCreateKingdomById(
            $request['kingdom_id'],
            $request['taxonomy_rank_kingdom']['rank_name']
        );

        $obj_phylum = $this->findOrCreatePhylumById(
            $request['phylum_id'],
            $request['taxonomy_rank_phylum']['rank_name']
        );

        $obj_class = $this->findOrCreateClassById(
            $request['class_id'],
            $request['taxonomy_rank_class']['rank_name']
        );

        $obj_order = $this->findOrCreateOrderById(
            $request['order_id'],
            $request['taxonomy_rank_order']['rank_name']
        );

        $obj_family = $this->findOrCreateFamilyById(
            $request['family_id'],
            $request['taxonomy_rank_family']['rank_name']
        );

        $obj_genus = $this->findOrCreateGenusById(
            $request['genus_id'],
            $request['taxonomy_rank_genus']['rank_name']
        );

        $obj_specie = $this->findOrCreateSpecieById(
            $request['specie_id'],
            $request['taxonomy_rank_specie']['rank_name']
        );


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
        $object = TaxonomyGroup::findOrFail($id);
        $object->delete();
        return;
    }
}
