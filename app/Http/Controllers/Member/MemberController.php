<?php

namespace App\Http\Controllers\Member;

use App\BloodGroupType;
use App\Cities;
use App\Languages;
use App\Members;
use App\MemberTranslations;
use App\UserCities;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class MemberController extends Controller
{
    public function manageMembers(Request $request){
        try{
            $new = 0;
            $edited = 0;
            $not_edited = 0;
            if(Session::has('city')){
                $city = Session::get('city');
                $memberIds = Members::where('city_id',$city)->pluck('id')->toArray();
            } else{
                $memberIds = Members::pluck('id')->toArray();
            }
            $membersTranslations = MemberTranslations::whereNotNull('first_name')
                ->orWhereNotNull('middle_name')
                ->orWhereNotNull('last_name')
                ->orWhereNotNull('address')
                ->orwhereColumn('updated_at','>','created_at')
                ->pluck('member_id')
                ->toArray();
            $membersData = Members::whereIn('id',$memberIds)->whereNotIn('id',$membersTranslations)
                ->pluck('id')
                ->toArray();
            if(count($membersData) > 0){
                $new = count($membersData);
            }

            $membersTranslations = MemberTranslations::where('first_name',null)
                ->orWhere('middle_name',null)
                ->orWhere('last_name',null)
                ->orWhere('address',null)
                ->pluck('member_id')
                ->toArray();
            $membersData = Members::whereIn('id',$memberIds)->whereIn('id',$membersTranslations)
                ->pluck('id')
                ->toArray();
            if(count($membersData) > 0){
                $not_edited = count($membersData);
            }
            $membersTranslations = MemberTranslations::whereNotNull('first_name')
                ->whereNotNull('middle_name')
                ->whereNotNull('last_name')
                ->whereNotNull('address')
                ->pluck('member_id')
                ->toArray();
            $membersData = Members::whereIn('id',$memberIds)->whereIn('id',$membersTranslations)
                ->pluck('id')
                ->toArray();
            if(count($membersData) > 0){
                $edited = count($membersData);
            }
            $members = Members::whereIn('id',$memberIds)->pluck('id')->toArray();
            $total = count($members);
            $edit = array("All ($total)","New ($new)","Not Edited ($not_edited)","Edited ($edited)");
            return view('admin.members.manage')->with(compact('edit'));
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
            $userId = Auth::user()->id;
            $cityIds = UserCities::where('user_id',$userId)->pluck('city_id')->toArray();
            $cities = Cities::whereIn('id',$cityIds)->get()->toArray();
            return view('admin.members.create')->with(compact('blood_group_types','cities'));
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

    public function memberListing(Request $request){
        try{
            $records = array();
            $status = 200;
            $cities = array();
            $records['data'] = array();
            $records["draw"] = intval($request->draw);
            $userId = Auth::user()->id;
            $cities = UserCities::where('user_id',$userId)->pluck('city_id')->toArray();
            $membersData = Members::whereIn('city_id',$cities)
                ->orderBy('created_at','desc')->pluck('id')->toArray();
            if(Session::has('city')){
                $cities = Session::get('city');
                $membersData = Members::where('city_id',$cities)
                    ->orderBy('created_at','desc')->pluck('id')->toArray();
            }
            $filterFlag = true;
            if($request->has('search_name') && $request->search_name != ''){
                $membersData = Members::whereRaw("CONCAT(first_name,' ',middle_name,' ',last_name) ilike '%".$request->search_name."%'")
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
                                ->whereIn('member.id',$membersData)
                                ->where('cities.name','ilike','%'.$request->search_city.'%')
                                ->pluck('members.id')
                                ->toArray();
                if(count($membersData) > 0){
                    $filterFlag = false;
                }
            }
            if(Session::has('city')){
                $city = Session::get('city');
                $memberIds = Members::where('city_id',$city)->pluck('id')->toArray();
            } else{
                $memberIds = Members::pluck('id')->toArray();
            }
            if($filterFlag == true && $request->has('filter_data')){
                if($request->filter_data == 1) {
                    $membersTranslations = MemberTranslations::whereNotNull('first_name')
                        ->orWhereNotNull('middle_name')
                        ->orWhereNotNull('last_name')
                        ->orWhereNotNull('address')
                        ->orwhereColumn('updated_at','>','created_at')
                        ->pluck('member_id')
                        ->toArray();
                    $membersData = Members::whereIn('id',$memberIds)->whereNotIn('id',$membersTranslations)
                        ->pluck('id')
                        ->toArray();
                    if(count($membersData) > 0){
                        $filterFlag = false;
                    }
                }
                if($request->filter_data == 2) {
                    $membersTranslations = MemberTranslations::where('first_name',null)
                        ->orWhere('middle_name',null)
                        ->orWhere('last_name',null)
                        ->orWhere('address',null)
                        ->pluck('member_id')
                        ->toArray();
                    $membersData = Members::whereIn('id',$memberIds)->whereIn('id',$membersTranslations)
                        ->pluck('id')
                        ->toArray();
                    if(count($membersData) > 0){
                        $filterFlag = false;
                    }
                }
                if($request->filter_data == 3) {
                    $membersTranslations = MemberTranslations::whereNotNull('first_name')
                        ->whereNotNull('middle_name')
                        ->whereNotNull('last_name')
                        ->whereNotNull('address')
                        ->pluck('member_id')
                        ->toArray();
                    $membersData = Members::whereIn('id',$memberIds)->whereIn('id',$membersTranslations)
                        ->pluck('id')
                        ->toArray();
                    if(count($membersData) > 0){
                        $filterFlag = false;
                    }
                }
            }
            $finalMembersData = Members::whereIn('id', $membersData)->orderBy('id','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalMembersData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalMembersData); $iterator++, $pagination++) {
                    $srNo = $iterator + 1;
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
                        $address = str_limit($finalMembersData[$pagination]->address,20);
                    }
                    if($finalMembersData[$pagination]->is_active == true ){
                        $memberStatus = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$memberId)' id='status$memberId' value='$memberId' checked/>";
                    }else{
                        $memberStatus = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$memberId)' id='status$memberId' value='$memberId'/>";
                    }
                    $createMemberDirectoryName = sha1($memberId);
                    $image = $finalMembersData[$pagination]->profile_image;
                    if ($image != null) {
                        $memberImage = env('MEMBER_IMAGES_UPLOAD') . DIRECTORY_SEPARATOR . $createMemberDirectoryName . DIRECTORY_SEPARATOR . $image;
                        $img = '<img src="'.$memberImage.'" class="avatar">';
                    } else {
                        $img = '<img src="'.env('DEFAULT_IMAGE').DIRECTORY_SEPARATOR."member.jpeg".'" class="avatar">';
                    }
                        $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/member/edit/' . $finalMembersData[$pagination]['id'] . '" style="color: white"> Edit
                    </div>';

                    $records['data'][$iterator] = [
                        $srNo,
                        $img,
                        $firstName ." ".$middleName ." ".$lastName,
                        $gujaratiDetails['first_name']." ".$gujaratiDetails['middle_name']." ".$gujaratiDetails['last_name'],
                        $address,
                        str_limit($gujaratiDetails['address'],20),
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
            $userId = Auth::user()->id;
            $cityIds = UserCities::where('user_id',$userId)->pluck('city_id')->toArray();
            $cities = Cities::whereIn('id',$cityIds)->get()->toArray();
            $defaultImage = env('DEFAULT_IMAGE').DIRECTORY_SEPARATOR."member.jpeg";
            return view('admin.members.edit')->with(compact('memberData','bloodGroups','cities','memberTranslation','defaultImage'));
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
