<?php

namespace App\Http\Controllers\Committee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Cities;
use App\Countries;
use App\States;
use Illuminate\Support\Facades\File;


class committeeController extends Controller
{
    public function manageCommittee(Request $request){
        try{
            return view('admin.committee.view');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Committees View page',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createView(Request $request){
        try{
            $countries = Countries::get();
            return view('admin.committee.create')->with(compact('countries'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create committee View',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }



    public function createCommittee(Request $request){
        try{
            $data = $request->all();
            dd($data);
            $committeeData['name'] = $data->committee_name;
            $committeeData['description'] = $data->description;
            $committeeData['country'] = $data->country;
            $committeeData['state'] = $data->state;
            $committeeData['city'] = $data->city;
            $createCommittee = Committee::create($committeeData);
            if($createCommittee){
                $request->session()->flash('success','Committee Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            return redirect('/committee/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create committee',
                'params' => $request->all(),
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
