<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show(Request $request){
        $company = Company::findOrFail(1);
        return view('company')->with('company',$company);
    }

    public function update(request $request){

        $validation = $request->validate([
            'phone' => 'required|numeric|digits:10',
            'email' => 'required|email|unique:companies,id',
            'address' => 'required|string',
        ]);

        $company = Company::findOrFail(1);
        $company->name = $request->name;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->save();

        return redirect( 'company')->with('status','registro actualizado');

    }
}
