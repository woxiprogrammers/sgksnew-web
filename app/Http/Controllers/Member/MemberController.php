<?php

namespace App\Http\Controllers\Member;

use App\BloodGroupType;
use App\Cities;
use App\Countries;
use App\Languages;
use App\Members;
use App\MemberTranslations;
use App\States;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
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
            $bloodGroupType = new BloodGroupType();
            $blood_group_types = $bloodGroupType->get();
            $countries = Countries::get();
            return view('admin.members.create')->with(compact('blood_group_types','countries'));
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
    public function create(Request $request){
        try{
            $data = $request->all();
            $membersData['first_name'] = $data['en']['first_name'];
            $membersData['middle_name'] = $data['en']['middle_name'];
            $membersData['last_name'] = $data['en']['last_name'];
            if(array_key_exists('gender',$data['en'])){
                $membersData['gender'] = $data['en']['gender'];
            }
            $membersData['address'] = $data['en']['address'];
            $membersData['date_of_birth'] = $data['en']['dob'];
            $membersData['blood_group_id'] = $data['en']['blood_group'];
            $membersData['mobile'] = $data['en']['mobile_number'];
            $membersData['email'] = $data['en']['email_id'];
            $membersData['city_id'] = $data['en']['city'];
            $membersData['longitude'] = $data['en']['latitude'];
            $membersData['latitude'] = $data['en']['longitude'];
            $createMember = Members::create($membersData);
            if(array_key_exists('gj',$data)){
                if(array_key_exists('first_name',$data['gj'])){
                    $gujaratiMembersData['first_name'] = $data['gj']['first_name'];
                }if (array_key_exists('middle_name',$data['gj'])){
                    $gujaratiMembersData['middle_name'] = $data['gj']['middle_name'];
                }if (array_key_exists('last_name',$data['gj'])){
                    $gujaratiMembersData['last_name'] = $data['gj']['last_name'];
                }if (array_key_exists('address',$data['gj'])){
                    $gujaratiMembersData['address'] = $data['gj']['address'];
                }
                $gujaratiMembersData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiMembersData['member_id'] = $createMember->id;
                MemberTranslations::create($gujaratiMembersData);
            }
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
                Session::flash('success','Member Created Successfully');
            }else{
                Session::flash('error','Something went wrong');
            }
            return redirect('/member/manage');
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create members',
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
                'params' => $request->all(),
                'action' => 'listing of states',
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
                'params' => $request->all(),
                'action' => 'listing of states',
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
            if($request->has('search_name') && $request->search_name != ''){
                $membersData = Members::where('first_name','ilike','%'.$request->search_name.'%')
                    ->orWhere('middle_name','ilike','%'.$request->search_name.'%')
                    ->orWhere('last_name','ilike','%'.$request->search_name.'%')
                    ->whereIn('id',$membersData)
                    ->pluck('id')->toArray();
                if(count($membersData) > 0){
                    $filterFlag = false;
                }
            }
            if($filterFlag == true && $request->has('search_mobile') && $request->search_mobile != ''){
                $membersData = Members::where('mobile','ilike','%'.$request->search_mobile.'%')
                    ->whereIn('id',$membersData)
                    ->pluck('id')
                    ->toArray();
                if(count($membersData) > 0){
                    $filterFlag = false;
                }
            }
            if($filterFlag == true && $request->has('search_city') && $request->search_city != ''){
                $membersData = Members::join('cities','cities.id','=','members.city_id')
                                ->where('cities.name','ilike','%'.$request->search_city.'%')
                                ->pluck('members.id')
                                ->toArray();
                if(count($membersData) > 0){
                    $filterFlag = false;
                }
            }
            $finalMembersData = Members::whereIn('id', $membersData)->orderBy('id','asc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalMembersData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalMembersData); $iterator++, $pagination++) {
                    $firstName = $finalMembersData[$pagination]->first_name;
                    $memberId= $finalMembersData[$pagination]->id;
                    $middleName = $finalMembersData[$pagination]->middle_name;
                    $lastName = $finalMembersData[$pagination]->last_name;
                    $mobile = $finalMembersData[$pagination]->mobile;
                    $gujaratiDetails = MemberTranslations::where('member_id',$finalMembersData[$pagination]->id)->first();
                    $city = Cities::where('id',$finalMembersData[$pagination]->city_id)->pluck('name')->first();
                    if($finalMembersData[$pagination]->address == null){
                        $address = "-";
                    }else{
                        $address = $finalMembersData[$pagination]->address;
                    }
                    if($finalMembersData[$pagination]->is_active == true ){
                        $memberStatus = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$memberId)' id='status$memberId' value='$memberId' checked/>";
                    }else{
                        $memberStatus = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$memberId)' id='status$memberId' value='$memberId'/>";
                    }
                        $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/member/edit/' . $finalMembersData[$pagination]['id'] . '" style="color: white"> Edit
                    </div>';

                    $records['data'][$iterator] = [
                        $memberId,
                        $firstName ." ".$middleName ." ".$lastName,
                        $gujaratiDetails['first_name']." ".$gujaratiDetails['middle_name']." ".$gujaratiDetails['last_name'],
                        $address,
                        $gujaratiDetails['address'],
                        $mobile,
                        $city,
                        $memberStatus,
                        $actionButton
                    ];
                    }
                }
        }catch(\Exception $e){
           $data = [
               'params' => $request->all(),
               'action' => 'Members listing',
               'exception' => $e->getMessage()
           ];
           $status = 500;
           $records = array();
           Log::critical(json_encode($data));
           abort(500);
       }
        return response()->json($records,$status);
    }
    public function editView(Request $request,$memberData){
        try{
            $memberTranslation = MemberTranslations::where('member_id',$memberData['id'])->first();
            $bloodGroups = BloodGroupType::get()->toArray();
            $countries = Countries::get()->toArray();
            $states = States::get()->toArray();
            $cities = Cities::get()->toArray();
            return view('admin.members.edit')->with(compact('memberData','bloodGroups','states','cities','countries','memberTranslation'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Member Edit View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
    public function edit(Request $request,$member){
        try{
            dd($member);
            $data = $request->all();
            $membersData['first_name'] = $data['en']['first_name'];
            $membersData['middle_name'] = $data['en']['middle_name'];
            $membersData['last_name'] = $data['en']['last_name'];
            if(array_key_exists('gender',$data['en'])){
                $membersData['gender'] = $data['en']['gender'];
            }
            $membersData['address'] = $data['en']['address'];
            $membersData['date_of_birth'] = $data['en']['dob'];
            $membersData['blood_group_id'] = $data['en']['blood_group'];
            $membersData['mobile'] = $data['en']['mobile_number'];
            $membersData['email'] = $data['en']['email_id'];
            $membersData['city_id'] = $data['en']['city'];
            $membersData['longitude'] = $data['en']['latitude'];
            $membersData['latitude'] = $data['en']['longitude'];
            $member->update($membersData);
            $memberTranslation = MemberTranslations::where('member_id',$member['id'])->first();

            if(array_key_exists('gj',$data)){
                if(array_key_exists('first_name',$data['gj'])){
                    $gujaratiMembersData['first_name'] = $data['gj']['first_name'];
                }if (array_key_exists('middle_name',$data['gj'])){
                    $gujaratiMembersData['middle_name'] = $data['gj']['middle_name'];
                }if (array_key_exists('last_name',$data['gj'])){
                    $gujaratiMembersData['last_name'] = $data['gj']['last_name'];
                }if (array_key_exists('address',$data['gj'])){
                    $gujaratiMembersData['address'] = $data['gj']['address'];
                }
                if($memberTranslation != null){
                    MemberTranslations::where('member_id',$member['id'])->update($gujaratiMembersData);
                }else{
                   $gujaratiMembersData['language_id'] =  Languages::where('abbreviation','=','gj')->pluck('id')->first();
                   $gujaratiMembersData['member_id'] = $member['id'];
                   MemberTranslations:: create($gujaratiMembersData);
                }
            }
            if($request->has('profile_images')){
                $createMemberDirectoryName = sha1($member['id']);
                $imageUploadPath = public_path().env('MEMBER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createMemberDirectoryName;
                if($member['profile_image'] != null){
                    unlink($imageUploadPath.DIRECTORY_SEPARATOR.$member['profile_image']);
                }
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
                $member->update([
                    'profile_image' => $filename,
                ]);

            }
            if($member){
                Session::flash('success','Member Edited Successfully');
            }else{
                Session::flash('error','Something went wrong');
            }
            return redirect('/member/manage');
        }catch(\Exception $e){
            $data = [
                'params' => $request->all(),
                'action' => 'Member Edit',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
    public function changeStatus(Request $request,$memberId){
        try{
            $status = 200;
            $changeStatus = (boolean)!$memberId->is_active;
            $memberId->update(['is_active' => $changeStatus]);
        }catch(\Exception $e){
            $status = 500;
            $data = [
                'params' => $request->all(),
                'action' => 'Member Activate',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
         return (json_encode($status));
    }
}
