<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 15/11/18
 * Time: 1:38 PM
 */
namespace App\Http\Controllers\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Countries;
use App\States;
use App\Cities;
use App\Languages;
use Illuminate\Support\Facades\File;

class MessageController extends Controller
{

    public function manage(Request $request){
        try{
            return view('admin.messages.manage');
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Messages View page',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createView(Request $request){
        try{
            $countries = Countries::get();
            return view('admin.messages.create')->with(compact('countries'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create Message View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
    public function getAllStates(Request $request,$id){
        try{
            $states = States::where('country_id',$id)->get();
            return $states;
        }catch(\Exception $exception){
            $data = [
                'action' => 'listing of states',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }


    public function getAllCities(Request $request,$id){
        try{
            $cities = Cities::where('state_id',$id)->get();
            return $cities;
        }catch(\Exception $exception){
            $data = [
                'action' => 'listing of states',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

}