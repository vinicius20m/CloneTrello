<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $return_messages = [
        // 'create' => '',
        // 'edit' => '',
        // 'destroy' => '',
        'error' => 'Algo deu Errado.'
    ] ;

    function __construct() {
        // parent::__construct() ;

        // Inertia::setRootView('root') ;
    }
}
