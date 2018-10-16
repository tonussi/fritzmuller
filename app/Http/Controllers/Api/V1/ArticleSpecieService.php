<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ArticleSpecie;
use App\Article;

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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // \Debugbar::info($request);
        // \Debugbar::info($request->all());

        $new_animals_config = $request->all();
        $aux_new_animals_config = array();

        $original_set_animal_ids = ArticleSpecie::where('id', '=', $id)->get()->pluck('animal_id');
        // \Debugbar::info($original_set_animal_ids);

        foreach ($new_animals_config as $key => $value) {
            $object = ArticleSpecie::where('id', '=', $id)->where('animal_id', '=', $value['id'])->first();
            if ($object === NULL) {
                ArticleSpecie::create(['id' => $id, 'animal_id' => $value['id']]);
            }
            if ($original_set_animal_ids->contains($value['id'])) {
                array_push($aux_new_animals_config, $value['id']);
            }
        }

        $diff_original_set_animal_ids = $original_set_animal_ids->diff($aux_new_animals_config);
        // \Debugbar::info($diff_original_set_animal_ids);

        foreach ($diff_original_set_animal_ids as $animal_id) {
            ArticleSpecie::where('id', '=', $id)->where('animal_id', '=', $animal_id)->delete();
        }
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
