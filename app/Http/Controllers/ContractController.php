<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(){

        return view('pages.contract.index');
    }

    public function create(){

        return view('pages.contract.create');
    }


    public function renewal($id){

        $contract = \App\Models\Contract::findOrFail($id);

        return view('pages.contract.renewal', compact('contract'));
    }


    public function show($id){
        
        return view('pages.contract.show', ['contract' => \App\Models\Contract::findOrFail($id)]);
    }
}
