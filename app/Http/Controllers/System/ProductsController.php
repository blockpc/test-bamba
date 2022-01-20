<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Blockpc\Traits\AuthorizesRoleOrPermission;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use AuthorizesRoleOrPermission;
    
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->authorizeRoleOrPermission('product list');
        return view('system.products.index');
    }
}
