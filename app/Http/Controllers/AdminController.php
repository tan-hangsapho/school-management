<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.admin_index');
    }

    public function Profile(){
        $id = Auth::user()->id;

        $user = User::find($id);

        return view('admin.admin_dashbaord',compact('user'));

    }
}
