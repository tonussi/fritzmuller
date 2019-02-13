<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Article;
use App\ArticleSpecie;
use App\SpecieDetail;
use App\TaxonomyGroup;

class ArticleService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::paginate(15);
    }

    public function newest($limit=10)
    {
        $begin_date = (new \DateTime('2012-10-16'))->format('Y-m-d');
        $end_date = (new \DateTime())->format('Y-m-d');
        $range_array = array($begin_date, $end_date);
        return Article::whereBetween('publication_date', $range_array)->where('active', '=', true)
        ->select('id', 'publication_date', 'active', 'title', 'price', 'rating', 'subtitle', 'figure_path', 'created_at', 'updated_at')
        ->limit($limit)->orderBy('publication_date', 'DESC')->get();
    }

    public function search($value, $limit=20)
    {
        return Article::where('title', 'LIKE', "%$value%")->orWhere('subtitle', 'LIKE', "%$value%")->where('active', '=', true)->limit($limit)->get();
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

    private function findTaxonomyGroups($names) {
        if ($names !== null) {
            return SpecieDetail::join('taxonomy_group', 'specie_detail.taxonomy_group_id', '=', 'taxonomy_group.id')
            ->join('taxonomy_rank_specie', 'taxonomy_group.specie_id', '=', 'taxonomy_rank_specie.id')
            ->join('article_specie', 'article_specie.specie_id', '<>', 'taxonomy_rank_specie.id')
            ->whereIn('taxonomy_rank_specie.rank_name', array_values($names))->get();
        }
        return null;
    }

    public function compareTaxonomyIdsWithin($a, $b)
    {
        if ($a->id === $b->id) return 0;
        return ($a->id > $b->id) ? 1 : -1;
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
        \Log::info("ArticleServiceUpdate");
        \Log::info($request);

        if ($request->has('new_species')) {
            $taxonomyGroupFound = $this->findTaxonomyGroups($request['new_species']);
        }

        \Log::info($taxonomyGroupFound);

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
