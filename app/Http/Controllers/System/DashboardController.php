<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $auth = current_user();

        if ( $auth->hasRole('sudo') ) {
            return view('system.dashboards.sudo');
        }

        if ( $auth->hasRole('admin') ) {
            return view('system.dashboards.admin');
        }
        
        return view('system.dashboards.user');
    }
}
