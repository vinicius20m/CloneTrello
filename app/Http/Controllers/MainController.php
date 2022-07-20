<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\BoardPermission;
use App\Models\Card;
use App\Models\Lane;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MainController extends Controller
{

    protected $routes;

    public function __construct()
    {
        $this->routes = [
            'card' => [

                'move' => route('api-move-card', ''). '/',
                'create' => route('api-create-card'),
                'edit' => route('api-edit-card', ''). '/',
                'destroy' => route('api-destroy-card', ''). '/',
                'comment' => [

                    'create' => route('api-create-comment'),
                    'edit' => route('api-edit-comment', ''). '/',
                    'destroy' => route('api-destroy-comment', ''). '/',
                ],
                'checklist' => [

                    'create' => route('api-create-checklist'),
                    'edit' => route('api-edit-checklist', ''). '/',
                    'destroy' => route('api-destroy-checklist', ''). '/',
                ],
                'checklist_item' => [

                    'create' => route('api-create-checklist_item'),
                    'edit' => route('api-edit-checklist_item', ''). '/',
                    'destroy' => route('api-destroy-checklist_item', ''). '/',
                    'check' => route('api-check-checklist_item', ''). '/',
                ],
            ] ,
            'lane' => [

                'move' => route('api-move-lane', ''). '/',
                'create' => route('api-create-lane'),
                'edit' => route('api-edit-lane', ''). '/',
                'destroy' => route('api-destroy-lane', ''). '/',
            ] ,
            'permission' => [

                'create' => route('api-create-permission'),
                'invite' => route('api-invite-permission'),
                'edit' => route('api-edit-permission', ''). '/',
                'destroy' => route('api-destroy-permission', ''). '/',
            ] ,
            'board' => [

                'show' => route('board-show', ''). '/',
                'create' => route('board-create'),
            ],
        ] ;
        return parent::__construct() ;
    }

    public function index(Board $board)
    {

        $lanes = Lane::where('board_id', $board->id)->orderBy('index', 'asc')->with([
            'cards' => function($query){
                $query->orderBy('index', 'asc')->with([
                    'author',
                    'comments' => function($q){
                        $q->with('user') ;
                    },
                    'checklists' => function($q){
                        $q->with(['items']) ;
                    },
                ]);
            },
            'author',
        ])->get() ;

        // dd($lanes->toArray()) ;
        $users = User::all() ;
        $boards = Auth::user()->enabledBoards ;
        $permissions = BoardPermission::whereBoardId($board->id)->with('user')->get() ;
        $user_permissions = BoardPermission::where([['user_id', Auth::id()], ['board_id', $board->id]])->get()->first() ;

        return Inertia::render('home', [

            'board' => $board ,
            'boards' => $boards ,
            'permissions' => $permissions ,
            'user_permissions' => $user_permissions ,
            'users' => $users ,
            'board_id' => $board->id,
            'lanes' => $lanes,
            'routes' => $this->routes
        ]) ;
    }
}
