<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CardChecklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;

class CardChecklistController extends Controller
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

        if($checklist = CardChecklist::create($form))
            return response([
                'message' => 'CheckList Criada',
                'checklist' => $checklist->load('items')
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
    public function update(Request $request, CardChecklist $checklist)
    {
        $form = $request->all() ;

        if($checklist->update($form))
            return response([
                'message' => 'CheckList Editada',
                'checklist' => $checklist->load('items')
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
    public function destroy(CardChecklist $checklist)
    {
        if($checklist->delete())
            return response([
                'message' => 'Checklist Removida',
            ], 200) ;
        else return response([
            'message' => $this->return_messages['error']
        ], 400) ;
    }
}
