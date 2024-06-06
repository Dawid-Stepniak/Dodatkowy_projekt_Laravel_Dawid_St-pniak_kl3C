<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GateController extends Controller
{
    function AddGate(Request $req){
        $req->validate(
            [
                'gateName'=>'required|min:5',
                'authDegreeRequired'=>'required'
            ],
            [
                'gateName.required' => 'Nazwa bramy jest wymagana!',
                'gateName.min'=>'Nazwa bramy musi mieć długość min.:min znaków!',
                'authDegreeRequired.required'=>'Zaznacz wymagany poziom autoryzacji!'
            ]
        );

        $gate = [
            'gateName'=>$req->input('gateName'),
            'authDegreeRequired'=>$req->input('authDegreeRequired')
        ];
        $gateName=$req->input('gateName');
        $authDegreeRequired=$req->input('authDegreeRequired');
        DB::INSERT('INSERT INTO gates(id,name,authDegreeReq) VALUES(null,?,?)',[$gateName,$authDegreeRequired]);
        return view('pages.add_gate',['gate'=>$gate]);
    }

    function CheckAuthDegree(Request $req){
        $gateId = $req->input('selectGate');
        Session::put('selectedGate',$gateId);
        return view('pages.gates_array',['gateId'=>$gateId]);

    }
}
