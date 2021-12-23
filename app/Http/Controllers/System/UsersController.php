<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Blockpc\Traits\AuthorizesRoleOrPermission;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use AuthorizesRoleOrPermission;
    
    public function index()
    {
        $this->authorizeRoleOrPermission('user list');
        return view('system.users.index');
    }
}
