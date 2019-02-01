<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ArticleSpecie;
use App\Article;
use App\TaxonomyRankSpecie;

class ArticleSpecieService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ArticleSpecie::orderBy('updated_at', 'DESC')->paginate(15);
    }

    public function species($id)
    {
        $article = Article::findOrFail($id);
        $as = $article->articleSpecies;
        foreach ($as as $key => $value) {
            $tax = $value->speciesDetail->taxonomyGroup;
            $tax->taxonomyRankKingdom;
            $tax->taxonomyRankPhylum;
            $tax->taxonomyRankClass;
            $tax->taxonomyRankOrder;
            $tax->taxonomyRankFamily;
            $tax->taxonomyRankGenus;
            $tax->taxonomyRankSpecie;
        }
        return $as;
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
        ArticleSpecie::create($request->all());
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
        return ArticleSpecie::findOrFail($id);
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

    private function findTaxonomyGroups($names) {
        $species = TaxonomyRankSpecie::whereIn('rank_name', $names);

        if ($names !== null) {
            return ArticleSpecie::join('article_specie', 'tax.specie_id', '=', 'taxonomy_rank_specie.id')
            ->whereIn('taxonomy_rank_specie.rank_name', '=', $names)->get();
        }

        return null;
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
        \Log::info($request);
        if ($request->has('new_species')) {
            $this->findTaxonomyGroups($request['new_species']);
        }
        $object = ArticleSpecie::findOrFail($id);
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
        $object = ArticleSpecie::findOrFail($id);
        $object->delete();
        return;
    }
}
