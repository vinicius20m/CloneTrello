<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;

class ChecklistItemController extends Controller
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

        if($item = ChecklistItem::create($form))
            return response([
                'message' => 'Item Criado',
                'item' => $item
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
    public function update(Request $request, ChecklistItem $checklist_item)
    {
        $form = $request->all() ;

        if($checklist_item->update($form))
            return response([
                'message' => 'Item Editado',
                'item' => $checklist_item
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
    public function destroy(ChecklistItem $checklist_item)
    {
        if($checklist_item->delete())
            return response([
                'message' => 'Item Removido',
            ], 200) ;
        else return response([
            'message' => $this->return_messages['error']
        ], 400) ;
    }

    public function check(Request $request, ChecklistItem $checklist_item)
    {
        $form = $request->all() ;
        // return response($form) ;
        if($checklist_item->update($form))
            return response([
                'message' => 'Item Concluido',
            ], 200) ;
        else return response([
            'message' => $this->return_messages['error']
        ], 400) ;
    }
}
