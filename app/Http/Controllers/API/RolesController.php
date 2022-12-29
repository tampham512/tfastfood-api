<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles=Role::all();
        return response()->json([
            'status'=>200,
            'roles'=>$roles,
        ]);
    }
}