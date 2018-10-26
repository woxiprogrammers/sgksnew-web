<?php

namespace App\Http\Controllers\Committee;

use App\Committees;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Cities;
use App\Countries;
use App\States;
use Illuminate\Support\Facades\File;


class CommitteeController extends Controller
{
    public function manageCommittee(Request $request){
        try{
            return view('admin.committee.manageCommittees');
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

    public function createCommitteeView(Request $request){
        try{
            $countries = Countries::get();
            return view('admin.committee.createCommittee')->with(compact('countries'));
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
            $committeeData['committee_name'] = $data['committee_name'];
            $committeeData['description'] = $data['description'];
            $committeeData['city_id'] = $data['city'];
            $createCommittee = Committees::create($committeeData);
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

    public function committeeListing(Request $request){
        try{
            $records = array();
            $status = 200;
            $mem=10;
            $records['data'] = array();
            $records["draw"] = intval($request->draw);
            $committeesData = Committees::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_committee') /*&& $request->search_name != ''*/){
                $committeesData = Committees::where('committee_name','like','%'.$request->search_committee.'%')
                    ->whereIn('id',$committeesData)
                    ->pluck('id')->toArray();
                if(count($committeesData) > 0){
                    $filterFlag = false;
                }
            }

            $finalCommitteesData = Committees::whereIn('id', $committeesData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalCommitteesData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalCommitteesData); $iterator++, $pagination++) {
                    $committeeName = $finalCommitteesData[$pagination]->committee_name;
                    $description = $finalCommitteesData[$pagination]->description;
                    $srNo = $finalCommitteesData[$pagination]->id;
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/committee/edit/' . $finalCommitteesData[$pagination]['id'] . '" style="color: white"> Edit
                    </div>
                    <div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/committee/edit/' . $finalCommitteesData[$pagination]['id'] . '" style="color: white"> View Members
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $committeeName,
                        $description,
                        $mem,
                        $mem,
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'Committee listing',
                'params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            $status = 500;
            $records = array();
            Log::critical(json_encode($data));
            abort(500);
        }
        return response()->json($records,$status);
    }

    public function editCommittee(Request $request,$id){
        try{
            $countries = Countries::get();
            $committeeData  = Committees::where('id',$id)->first();
            return view('admin.committee.editCommitteeView')->with(compact('committeeData','countries'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'Committee Edit View',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
}
