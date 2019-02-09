<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\SpecieDetail;
use App\TaxonomyGroup;

class SpecieDetailService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objects = SpecieDetail::orderBy('updated_at', 'DESC')->paginate(15);
        foreach ($objects as $key => $value) {
            $value->taxonomyGroup->taxonomyRankSpecie;
        }
        return $objects;
    }

    public function byid($id)
    {
        $specie = SpecieDetail::where('id', '=', $id)->get()->first();
        $specie->taxonomyGroup->taxonomyRankKingdom;
        $specie->taxonomyGroup->taxonomyRankPhylum;
        $specie->taxonomyGroup->taxonomyRankClass;
        $specie->taxonomyGroup->taxonomyRankOrder;
        $specie->taxonomyGroup->taxonomyRankFamily;
        $specie->taxonomyGroup->taxonomyRankGenus;
        $specie->taxonomyGroup->taxonomyRankSpecie;
        return $specie;
    }

    public function newest($limit=10)
    {
        $objects = SpecieDetail::limit($limit)->
        select('id', 'taxonomy_group_id', 'figure_path', 'created_at', 'updated_at')->get();
        foreach ($objects as $key => $specie) {
            $specie->taxonomyGroup->taxonomyRankKingdom;
            $specie->taxonomyGroup->taxonomyRankPhylum;
            $specie->taxonomyGroup->taxonomyRankClass;
            $specie->taxonomyGroup->taxonomyRankOrder;
            $specie->taxonomyGroup->taxonomyRankFamily;
            $specie->taxonomyGroup->taxonomyRankGenus;
            $specie->taxonomyGroup->taxonomyRankSpecie;
        }
        return $objects;
    }

    public function advanced($begindate, $enddate)
    {
        $formated_begin_date = (new \DateTime($begindate))->format('Y-m-d');
        $formated_end_date = (new \DateTime($enddate))->format('Y-m-d');
        $range_array = array($formated_begin_date, $formated_end_date);
        return SpecieDetail::whereBetween('created_at', $range_array)->get();
    }

    public function search($value)
    {
        return TaxonomyGroup::join('specie_detail', 'taxonomy_group.id', '=', 'specie_detail.taxonomy_group_id')
        ->join('taxonomy_rank_specie', 'taxonomy_group.specie_id', '=', 'taxonomy_rank_specie.id')
        ->where('taxonomy_rank_specie.rank_name', 'LIKE', '%' . $value . '%')->get();
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

    private function findTaxonomyGroupId($new_specie_rank_name) {
        // SELECT * FROM taxonomy_group INNER JOIN taxonomy_rank_specie ON
        // (taxonomy_group.specie_id = taxonomy_rank_specie.id)
        // where (rank_name = 'Lasiodora parahybanaAAA');
        return TaxonomyGroup::join(
            'taxonomy_rank_specie',
            'taxonomy_group.specie_id',
            '=',
            'taxonomy_rank_specie.id'
        )->where('rank_name', '=', $new_specie_rank_name)->get()->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // \Log::info('Storing');
        // \Log::info($request);

        if ($request['new_specie_rank_name'] !== null or $request['new_specie_rank_name'] !== '') {
            $tg = $this->findTaxonomyGroupId($request['new_specie_rank_name']);
            $request["taxonomy_group_id"] = $tg["id"];
            SpecieDetail::create($request->all());
        }

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
        return SpecieDetail::findOrFail($id);
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
        // \Log::info('Updating');
        // \Log::info($request);

        $object = SpecieDetail::findOrFail($id);

        if ($request['new_specie_rank_name'] != null) {
            $tg = $this->findTaxonomyGroupId($request['new_specie_rank_name']);
            $request["taxonomy_group_id"] = $tg["id"];
        }

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
        $object = SpecieDetail::findOrFail($id);
        $object->delete();
        return;
    }
}
