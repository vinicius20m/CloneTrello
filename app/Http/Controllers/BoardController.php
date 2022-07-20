<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Http\Requests\BoardRequest;
use App\Models\BoardPermission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $boards = Board::where('user_id', Auth::id())->get() ;
        $user = User::find(Auth::id()) ;
        $boards = $user->enabledBoards ;
        // dd($boards->count()) ;

        if($boards->count()>0)
            return Redirect::route('board-show', $boards->first()->id) ;

        return Inertia::render('Board/index', [

            'boards' => $boards,
            'routes' => [

                'show' => route('board-show', ''). '/',
                'create' => route('board-create'),
                'edit' => route('board-edit', ''). '/',
                'destroy' => route('board-destroy', ''). '/',
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

        return Inertia::render('Board/create', [
            'formRoute' => route('board-create'),
        ]) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BoardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoardRequest $request)
    {

        $form = $request->all() ;
        $form['user_id'] = Auth::id() ;
        if($board = Board::create($form)){

            BoardPermission::create([
                'board_id' => $board->id,
                'user_id' => Auth::id(),
            ]) ;

            return Redirect::route('board-show', $board->id)->with([

                'success' => true,
                'message' => 'Great. Your Board was successfully created.'
            ]) ;
        }else return Redirect::route('board-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {

        return Inertia::render('Board/edit', [

            'board' => $board,
            'formRoute' => route('board-edit', $board->id),
        ]) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BoardRequest  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(BoardRequest $request, Board $board)
    {

        $form = $request->all() ;

        if($board->update($form))
            return Redirect::route('board-index')->with([

                'success' => true,
                'message' => 'Great!! The Board was successfully updated.'
            ]) ;
        else return Redirect::route('board-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {

        if($board->delete())
            return Redirect::route('board-index')->with([

                'success' => true,
                'message' => 'Great!! The Board was successfully deleted.'
            ]) ;
        else return Redirect::route('board-index')->with([

            'error' => true,
            'message' => 'Sorry. Something gone wrong.'
        ]) ;
    }
}
