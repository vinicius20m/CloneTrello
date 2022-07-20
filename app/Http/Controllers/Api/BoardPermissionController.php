<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\BoardPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class BoardPermissionController extends Controller
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

        foreach($form['permissions'] as $permission)
            $form[$permission] = true
        ;
        // return response($form) ;

        if($permission = BoardPermission::create($form))
            return response([
                'message' => 'Convite Enviado',
                'permission' => $permission->load('user')
            ], 200) ;
        else return response([
            'message' => 'Sorry! Something gone wrong.'
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
    public function update(Request $request, BoardPermission $user_permission)
    {
        $form = $request->all() ;
        $form['can_create'] = false ;
        $form['can_edit'] = false ;
        $form['can_delete'] = false ;
        $form['can_move'] = false ;
        $form['can_add_member'] = false ;
        $form['can_remove_member'] = false ;

        foreach($form['permissions'] as $permission)
            $form[$permission] = true
        ;

        // return response($user_permission) ;

        if($user_permission->update($form))
            return response([
                'message' => 'Permissões Alteradas',
                'permission' => $user_permission->load('user')
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
    public function destroy(BoardPermission $user_permission)
    {
        if($user_permission->delete())
            return response([
                'message' => 'Membro Removido do Quadro',
                'permission' => $user_permission->load('user')
            ], 200) ;
        else return response([
            'message' => $this->return_messages['error']
        ], 400) ;
    }

    public function invite(Request $request)
    {
        $form = $request->all() ;

        foreach($form['permissions'] as $permission)
            $form[$permission] = true
        ;

        if($permission = BoardPermission::create($form)){

            $form['invite_url'] = route('accept-invite', Crypt::encryptString((string) $permission->id)) ;
            $form['board_title'] = Board::find($form['board_id'])->title ;

            Mail::send('Mail.boardInvite', [
                'form' => $form
            ], function($m){
                // $m->from('vmcmendes16@gmail.com', 'Clone Trello') ;
                $m->to('vmcmendes17@hotmail.com') ;
                $m->subject('Convite para o Quadro') ;
            }) ;

            return response([
                'message' => 'Convite Enviado',
                'permission' => $permission->load('user')
            ], 200) ;
        }else return response([
            'message' => $this->return_messages['error']
        ], 400) ;
    }

    public function acceptInvite(string $permission)
    {

        $permission_id = Crypt::decryptString($permission) ;
        $permission = BoardPermission::findOrFail($permission_id) ;

        $permission->update([
            'accepted' => true,
        ]) ;

        return view('Mail.inviteAccepted') ;
    }
}
