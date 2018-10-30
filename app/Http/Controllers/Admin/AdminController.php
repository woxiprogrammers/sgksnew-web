<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }

    public function viewLogin(Request $request){
        try{
            return view('admin.login');
        }catch(\Exception $e){
            $data = [
                'action' => 'View Login Page',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}
