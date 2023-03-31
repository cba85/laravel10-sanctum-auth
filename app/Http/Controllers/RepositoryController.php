<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    public function index(Request $request)
    {
        /*
        // Abilities
        if (!$request->user()->tokenCan("repo:view")) {
            return response()->json(['error' => "Forbidden"], 403);
        }
        */

        return response()->json(['message' => 'repo:view']);
    }

    public function store(Request $request)
    {
        /*
        // Abilities
        if (!$request->user()->tokenCan("repo:create")) {
            return response()->json(['error' => "Forbidden"], 403);
        }
        */

        return response()->json(['message' => 'repo:create']);
    }
}
