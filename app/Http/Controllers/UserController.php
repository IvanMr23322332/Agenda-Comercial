<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Models\Users;

use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    function verificationLogIn(Request $request){
        $credentials = $request->all();


        $consulta = DB::table('users')
           -> select ('user_name','user_mail','user_pass')
           -> where ('user_mail','=',$credentials['email'])
           -> where ('user_pass','=',$credentials['password'])
           -> first();

        dd($consulta);
        if ($consulta != NULL) {
            // if ($consulta[])
        }
        else {

        }
    }
}
