<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CardComment;
use Illuminate\Http\Request;

class CardCommentController extends Controller
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
        // return response($form) ;
        if($comment = CardComment::create($form))
            return response([
                'message' => 'Comentário Publicado ',
                'comment' => $comment->load('user')
            ], 200) ;
        else return response([
            'message' => $this->return_messages['error']
        ], 400) ;
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
    public function update(Request $request, CardComment $comment)
    {
        $form = $request->all() ;

        if($comment->update($form))
            return response([
                'message' => 'Comentário Editado',
                'comment' => $comment->load('user')
            ], 200) ;
        else return response([
            'message' => $this->return_messages['error']
        ], 400) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardComment $comment)
    {
        if($comment->delete())
            return response([
                'message' => 'Comentário Removido',
            ], 200) ;
        else return response([
            'message' => $this->return_messages['error']
        ], 400) ;
    }
}
