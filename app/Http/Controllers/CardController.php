<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Lane;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = Card::all()->load('lane') ;

        return Inertia::render('Card/index', [

            'cards' => $cards,
            'routes' => [
                'create' => route('card-create'),
                'edit' => route('card-edit', ''). '/',
                'destroy' => route('card-destroy', ''). '/',
            ]
        ]) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $lanes = Lane::all() ;
        return Inertia::render('Card/create', [
            'lanes' => $lanes,
            'formRoute' => route('card-create'),
        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCardRequest $request)
    {
        // dd($request->all()) ;

        $form = $request->all() ;
        $form['author_id'] = Auth::id() ;

        if(Card::where('lane_id', $form['lane_id'])->count() == 0)
            $form['index'] = 0 ;
        else
            $form['index'] = Card::where('lane_id', $form['lane_id'])->latest('index')->get()->first()->index + 1
        ;

        if(Card::create($form))
            return Redirect::route('card-index')->with([

                'success' => true,
                'message' => 'Great. Your Card was successfully created.'
            ]) ;
        else return Redirect::route('card-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        // dd($card) ;

        $lanes = Lane::all() ;
        return Inertia::render('Card/edit', [

            'lanes' => $lanes,
            'card' => $card,
            'formRoute' => route('card-edit', $card->id),
        ]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCardRequest  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        // dd($card) ;

        $form = $request->all() ;

        if($card->update($form))
            return Redirect::route('card-index')->with([

                'success' => true,
                'message' => 'Great!! The Card was successfully updated.'
            ]) ;
        else return Redirect::route('card-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        if($card->delete())
            return Redirect::route('card-index')->with([

                'success' => true,
                'message' => 'Great!! The Card was successfully deleted.'
            ]) ;
        else return Redirect::route('card-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }
}
