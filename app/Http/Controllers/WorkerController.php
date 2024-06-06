<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WorkerController extends Controller
{
    function AddWorker(Request $req){
        
        $req->validate( //walidacja danych z formularza dodającego pracownika
            [
                'firstName'=>'max:40|required',
                'lastName'=>'max:60|required',
                'email'=>'max:60|email|required',
                'departament'=>'max:60|required',
                'authDegree'=>'required',
                'sex'=>'required|in:male,female'
            ],
            [
                'firstName.max'=>'Imię może mieć max::max znaków!',
                'firstName.required'=>'Imię jest wymagane!',
                'lastName.max'=>'Nazwisko może mieć max::max znaków!',
                'lastName.required'=>'Nazwisko jest wymagane!',
                'email.max'=>'Pole :attribute może mieć max::max znaków!',
                'email.required'=>'Pole :attribute jest wymagane!',
                'email.email'=>'Pole :attribute musi być typu email!',
                'departament.max'=>'Pole oddział może mieć max::max znaków!',
                'departament.required'=>'Pole oddział jest wymagane!',
                'authDegree.required'=>'Poziom autoryzacji jest wymagany!',
                'sex.required'=>'Wybierz płeć!'

                
            ]
        );

        $worker = [
            'firstName' => $req->input('firstName'),
            'lastName' => $req->input('lastName'),
            'email' => $req->input('email'),
            'departament' => $req->input('departament'),
            'authDegree' => $req->input('authDegree'),
            'sex' => $req->input('sex')
            ];

        $firstName = $req->input('firstName');
        $lastName = $req->input('lastName');
        $email = $req->input('email');
        $departament = $req->input('departament');
        $authDegree = $req->input('authDegree');
        $sex = $req->input('sex');

        //dodawanie pracownika do bazy danych
        DB::INSERT('INSERT INTO workers(id,firstName,lastName,sex,email,departament,authDegree) VALUES(null,?,?,?,?,?,?)',[$firstName, $lastName,$sex,$email,$departament,$authDegree]);
        
        return view('pages.worker_added',['worker'=>$worker]);
    }

    function CheckAuthDegree(Request $req){
        
        

        $workerId = $req->input('selectWorker');
        Session::put('selectedWorker',$workerId); //zapisujemy id wybranego pracownika w sesji aby był on domyślnie wybrany w formularzu po przekierowaniu
        return view('pages.workers_array',['workerId'=>$workerId]);
    }
}
