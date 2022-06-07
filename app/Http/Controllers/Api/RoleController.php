<?php

namespace App\Http\Controllers\Api;

use App\Models\{Role, User};

class RoleController extends Controller
{
    public function index()
    {
        $middleman_id = Role::where('name', 'middleman')->pluck('id')->first();
        $withdraw_manager_id = Role::where('name', 'withdraw_manager')->pluck('id')->first();

        $ids = [];

        if (User::where('role_id', $middleman_id)->first()) $ids[] = $middleman_id;
        if (User::where('role_id', $withdraw_manager_id)->first()) $ids[] = $withdraw_manager_id;

        $roles = Role::whereNotIn('id', $ids)->get();

        return response()->json($roles, 200);
    }
}
