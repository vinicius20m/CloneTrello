<?php

namespace App\Http\Controllers;

use App\Models\Lane;
use App\Http\Requests\StoreLaneRequest;
use App\Http\Requests\UpdateLaneRequest;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LaneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lanes = Lane::all()->load('board') ;

        return Inertia::render('Lane/index', [

            'lanes' => $lanes,
            'routes' => [
                'create' => route('lane-create'),
                'edit' => route('lane-edit', ''). '/',
                'destroy' => route('lane-destroy', ''). '/',
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
        $boards = Board::whereUser_id(Auth::id())->get() ;

        return Inertia::render('Lane/create', [

            'boards' => $boards,
            'formRoute' => route('lane-create'),
        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLaneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLaneRequest $request)
    {

        $form = $request->all() ;
        $form['author_id'] = Auth::id() ;

        if(Lane::where('board_id', $form['board_id'])->count() == 0)
            $form['index'] = 0 ;
        else
            $form['index'] = Lane::where('board_id', $form['board_id'])->latest('index')->get()->first()->index + 1
        ;

        if(Lane::create($form))
            return Redirect::route('lane-index')->with([

                'success' => true,
                'message' => 'Great. Your Lane was successfully created.'
            ]) ;
        else return Redirect::route('lane-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lane  $lane
     * @return \Illuminate\Http\Response
     */
    public function show(Lane $lane)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lane  $lane
     * @return \Illuminate\Http\Response
     */
    public function edit(Lane $lane)
    {
        $boards = Board::whereUser_id(Auth::id())->get() ;

        return Inertia::render('Lane/edit', [

            'boards' => $boards,
            'lane' => $lane,
            'formRoute' => route('lane-edit', $lane->id),
        ]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLaneRequest  $request
     * @param  \App\Models\Lane  $lane
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLaneRequest $request, Lane $lane)
    {

        $form = $request->all() ;

        if($lane->update($form))
            return Redirect::route('lane-index')->with([

                'success' => true,
                'message' => 'Great!! The Lane was successfully updated.'
            ]) ;
        else return Redirect::route('lane-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lane  $lane
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lane $lane)
    {

        if($lane->delete())
            return Redirect::route('lane-index')->with([

                'success' => true,
                'message' => 'Great!! The Lane was successfully deleted.'
            ]) ;
        else return Redirect::route('lane-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }
}
