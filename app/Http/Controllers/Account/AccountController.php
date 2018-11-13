<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 5/11/18
 * Time: 11:00 AM
 */
namespace App\Http\Controllers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Countries;
use App\States;
use App\Cities;
use Illuminate\Support\Facades\File;


class AccountController extends Controller
{
    public function manage(Request $request){
        try{
            return view('admin.accounts.manage');
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Members View page',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createView(Request $request){
        try{
            $countries = Countries::get();
            return view('admin.accounts.create')->with(compact('countries'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create members View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

}