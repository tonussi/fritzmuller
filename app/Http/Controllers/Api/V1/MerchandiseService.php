<?php
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Merchandise;

class MerchandiseService extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Merchandise::orderBy('updated_at', 'DESC')->paginate(15);
    }

    public function newest($limit=5)
    {
        // $begin_date = (new \DateTime('2012-10-16'))->format('Y-m-d');
        // $end_date = (new \DateTime())->format('Y-m-d');
        // $range_array = array($begin_date, $end_date);
        // return Merchandise::whereBetween('created_at', $range_array)->limit(10)->where('active', '=', true)->get();
        return Merchandise::where('active', '=', true)->limit($limit)->get();
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
        Merchandise::create($request->all());
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
        return Merchandise::findOrFail($id);
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
        $object = Merchandise::findOrFail($id);
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
        $object = Merchandise::findOrFail($id);
        $object->delete();
        return;
    }
}
