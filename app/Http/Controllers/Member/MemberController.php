<?php

namespace App\Http\Controllers\Member;

use App\BloodGroupType;
use App\Cities;
use App\Countries;
use App\Members;
use App\States;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class MemberController extends Controller
{
    public function manageMembers(Request $request){
        try{
            return view('admin.members.manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Members View page',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
    public function createView(Request $request){
        try{
            $bloodGroupType = new BloodGroupType();
            $blood_group_types = $bloodGroupType->get();
            $countries = Countries::get();
            return view('admin.members.create')->with(compact('blood_group_types','countries'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create members View',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
    public function create(Request $request){
        try{
            $data = $request->all();
            $membersData['first_name'] = $data['first_name'];
            $membersData['middle_name'] = $data['middle_name'];
            $membersData['last_name'] = $data['last_name'];
            $membersData['gender'] = $data['gender'];
            $membersData['date_of_birth'] = $data['dob'];
            $membersData['blood_group_id'] = $data['blood_group'];
            $membersData['mobile'] = $data['mobile_number'];
            $membersData['email'] = $data['email_id'];
            $membersData['city_id'] = $data['city'];
            $membersData['longitude'] = $data['latitude'];
            $membersData['latitude'] = $data['longitude'];
            $createMember = Members::create($membersData);
            if($request->has('profile_images')){
                $createMemberDirectoryName = sha1($createMember->id);
                $imageUploadPath = public_path().env('MEMBER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createMemberDirectoryName;
                if (!file_exists($imageUploadPath)) {
                    File::makeDirectory($imageUploadPath, $mode = 0777, true, true);
                }
                $imageArray = explode(';',$data['profile_images']);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($data['profile_images'], ';');
                $type = explode(':', substr($data['profile_images'], 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = $imageUploadPath.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($image));
                $createMember->update([
                    'profile_image' => $filename,
                ]);
            }
            if($createMember){
                $request->session()->flash('success','Member Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            return redirect('/member/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create members',
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
    public function memberListing(Request $request){
        try{
            $records = array();
            $status = 200;
            $records['data'] = array();
            $records["draw"] = intval($request->draw);
            $membersData = Members::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_name') /*&& $request->search_name != ''*/){
                $membersData = Members::where('first_name','ilike','%'.$request->search_name.'%')
                    ->orWhere('middle_name','ilike','%'.$request->search_name.'%')
                    ->orWhere('last_name','ilike','%'.$request->search_name.'%')
                    ->whereIn('id',$membersData)
                    ->pluck('id')->toArray();
                if(count($membersData) > 0){
                    $filterFlag = false;
                }
            }
            if($filterFlag == true && $request->has('search_mobile') /*&& $request->search_mobile != ''*/){
                $membersData = Members::where('mobile',$request->search_mobile)
                    ->whereIn('id',$membersData)
                    ->pluck('id')
                    ->toArray();
                if(count($membersData) > 0){
                    $filterFlag = false;
                }
            }
            $finalMembersData = Members::whereIn('id', $membersData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalMembersData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalMembersData); $iterator++, $pagination++) {
                    $firstName = $finalMembersData[$pagination]->first_name;
                    $middleName = $finalMembersData[$pagination]->middle_name;
                    $lastName = $finalMembersData[$pagination]->last_name;
                    $srNo = $finalMembersData[$pagination]->id;
                    $mobile = $finalMembersData[$pagination]->mobile;
                    if($finalMembersData[$pagination]->is_active == true ){
                        $memberStatus = "Enable";
                    }else{
                        $memberStatus = "Disable";
                    }
                        $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/member/edit/' . $finalMembersData[$pagination]['id'] . '" style="color: white"> Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $firstName ." ".$middleName ." ".$lastName,
                        $mobile,
                        $memberStatus,
                        $actionButton
                    ];
                    }
                }
        }catch(\Exception $e){
           $data = [
               'action' => 'Members listing',
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
    public function editView(Request $request,$id){
        try{
            $memberData  = Members::where('id',$id)->first();
            return view('admin.members.edit')->with(compact('memberData'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'Member Edit View',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
}
