<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lane;
use Illuminate\Http\Request;

class LaneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $request->all() ;

        if(Lane::where('board_id', $form['board_id'])->count() == 0)
            $form['index'] = 0 ;
        else
            $form['index'] = Lane::where('board_id', $form['board_id'])->latest('index')->get()->first()->index + 1
        ;

        $lane = Lane::create($form) ;

        return response([

            'message' => 'Lista Criada',
            'lane' => $lane->load(['cards', 'author'])
        ], 200) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lane $lane)
    {
        $form = $request->all() ;

        if($lane->update($form))
            return response([

                'message' => 'Lista Editada.',
                'lane' => $lane,
            ], 200) ;
        else return response([

            'message' => $this->return_messages['error'],
            'lane' => $lane,
        ], 400) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lane $lane)
    {
        if($lane->delete()){

            $modifiedIndexes = Lane::where('board_id', $lane->board_id)->where('index', '>', $lane->index)->get() ;
            foreach($modifiedIndexes as $modifiedIndex)
                $modifiedIndex->update(['index' => $modifiedIndex->index -1])
            ;
            return response([

                'lane' => $lane,
                'message' => 'Lista Removida'
            ], 200) ;
        }else return response([

            'message' => $this->return_messages['error'],
            'lane' => $lane,
        ], 400) ;
    }
}
