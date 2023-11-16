<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class MachineToMachineController extends Controller
{
    public function index(Request $request)
    {


        return response()->json(['message' => 'M2M kimlik doğrulaması başarılı', 'data' => []]);
    }
}
