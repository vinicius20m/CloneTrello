<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
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

        if(Card::where('lane_id', $form['lane_id'])->count() == 0)
            $form['index'] = 0 ;
        else
            $form['index'] = Card::where('lane_id', $form['lane_id'])->latest('index')->get()->first()->index + 1
        ;

        $card = Card::create($form) ;

        return response([

            'message' => 'Cartão Criado',
            'card' => $card->load(['author', 'checklists', 'comments'])
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
    public function update(Request $request, Card $card)
    {
        $form = $request->all() ;

        if($card->update($form))
            return response([

                'message' => 'Cartão Editado',
                'card' => $card->load(['author', 'checklists', 'comments']),
            ], 200) ;
        else return response([

            'message' => $this->return_messages['error'],
        ], 400) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        if($card->delete()){

            $modifiedIndexes = Card::where('lane_id', $card->lane_id)->where('index', '>', $card->index)->get() ;
            foreach($modifiedIndexes as $modifiedIndex)
                $modifiedIndex->update(['index' => $modifiedIndex->index -1])
            ;
            return response([

                'card' => $card,
                'message' => 'Cartão Removido'
            ], 200) ;
        }else return response([

            'message' => $this->return_messages['error'],
        ], 400) ;
    }
}
