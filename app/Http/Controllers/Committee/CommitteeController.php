<?php

namespace App\Http\Controllers\Committee;

use App\CommitteeMembers;
use App\Committees;
use App\Languages;
use App\CommitteeMembersTranslations;
use App\CommitteesTranslations;
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
            return view('admin.committee.manage');
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
            $committeeData['committee_name'] = $data['en']['committee_name'];
            $committeeData['description'] = $data['en']['description'];
            $committeeData['city_id'] = $data['en']['city'];
            $createCommittee = Committees::create($committeeData);
            if($createCommittee){
                $request->session()->flash('success','Committee Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            if(array_key_exists('gj',$data)){
                if(array_key_exists('committee_name',$data['gj'])){
                    $gujaratiCommitteeData['committee_name'] = $data['gj']['committee_name'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiCommitteeData['description'] = $data['gj']['description'];
                }
                $gujaratiCommitteeData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiCommitteeData['committee_id'] = $createCommittee->id;
                CommitteesTranslations::create($gujaratiCommitteeData);
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
                    $isActiveStatus = $finalCommitteesData[$pagination]->is_active;
                    $srNo = $finalCommitteesData[$pagination]->id;
                    $totalMembers = CommitteeMembers::where('committee_id',$srNo)->count();
                    $gujaratiDetails = CommitteesTranslations::where('committee_id',$finalCommitteesData[$pagination]->id)->first();
                    if($isActiveStatus){
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$srNo)' id='status$srNo' value='$srNo' checked/>";
                    }else{
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$srNo)' id='status$srNo' value='$srNo'/>";
                    }
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue">
                        <a href="/committee/edit/' . $finalCommitteesData[$pagination]['id'] . '" style="color: white">Edit
                    </div>
                    <div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/committee-members/manage/' . $finalCommitteesData[$pagination]['id'] . '" style="color: white"> View Members
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $committeeName,
                        $gujaratiDetails['committee_name'],
                        $description,
                        $gujaratiDetails['description'],
                        $totalMembers,
                        $isActive,
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

    public function editCommitteeView(Request $request,$id){
        try{
            $countries = Countries::get();
            $committeeData  = Committees::where('id',$id)->first();

            $cityId = $committeeData['city_id'];
            $city = Cities::where('id',$cityId)->first();
            $cityName = $city['name'];
            $stateId = $city['state_id'];
            $state = States::where('id',$stateId)->first();
            $stateName = $state['name'];
            $countryId = $state['country_id'];
            $country = Countries::where('id',$countryId)->first();
            $countryName = $country['name'];

            $committeeDataGujarati = CommitteesTranslations::where('committee_id',$id)->first();

            return view('admin.committee.edit')->with(compact('committeeData','countries','countryName','stateName','cityName','cityId','committeeDataGujarati'));
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

    public function editCommittee(Request $request,$id){
        try{
            $data = $request->all();
            $committeeData['committee_name'] = $data['en']['committee_name'];
            $committeeData['description'] = $data['en']['description'];
            $committeeData['city_id'] = $data['en']['city'];
            $createCommittee = Committees::where('id',$id)->update($committeeData);
            $committeeId = CommitteesTranslations::where('committee_id',$id)->first();

            if(array_key_exists('gj',$data)){
                if(array_key_exists('committee_name',$data['gj'])){
                    $committeeDataGujarati['committee_name'] = $data['gj']['committee_name'];
                }if (array_key_exists('description',$data['gj'])){
                    $committeeDataGujarati['description'] = $data['gj']['description'];
                }
                $committeeDataGujarati['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $committeeDataGujarati['committee_id'] = $id;
                if($committeeId['committee_id']==$id) {
                    CommitteesTranslations::where('committee_id', $id)->update($committeeDataGujarati);
                }else{
                    CommitteesTranslations::create($committeeDataGujarati);
                }

            }

            if ($createCommittee) {
                    $request->session()->flash('success', 'Committee Created Successfully');
            } else {
                    $request->session()->flash('error', 'Something went wrong');
            }
            return redirect('/committee/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Edit committee',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function manageMembers(Request $request,$id){
        try{
            return view('admin.committee.members.manage')->with(compact('id'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'Member View page',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }


    public function createMemberView(Request $request,$id){
        try{
            return view('admin.committee.members.create')->with(compact('id'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create Member View',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createMember(Request $request,$id){
        try{
            $data = $request->all();
            $committeeMemberData['committee_id'] = $id;
            $committeeMemberData['full_name'] = $data['en']['full_name'];
            $committeeMemberData['designation'] = $data['en']['designation'];
            $committeeMemberData['mobile_number'] = $data['en']['mobile_number'];
            $committeeMemberData['email_id'] = $data['en']['email_id'];
            $createMember = CommitteeMembers::create($committeeMemberData);
            if(array_key_exists('gj',$data)){
                if(array_key_exists('full_name',$data['gj'])){
                    $gujaratiMemberData['full_name'] = $data['gj']['full_name'];
                }if (array_key_exists('designation',$data['gj'])){
                    $gujaratiMemberData['designation'] = $data['gj']['designation'];
                }
                $gujaratiMemberData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiMemberData['member_id'] = $createMember->id;
                CommitteeMembersTranslations::create($gujaratiMemberData);
            }
            if($request->has('profile_images')){
                $createMemberDirectoryName = sha1($createMember->id);
                $committeeMembersImages = public_path().env('COMMITTEE_MEMBER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createMemberDirectoryName;
                if (!file_exists($committeeMembersImages)) {
                    File::makeDirectory($committeeMembersImages, $mode = 0777, true, true);
                }
                $imageArray = explode(';',$data['profile_images']);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($data['profile_images'], ';');
                $type = explode(':', substr($data['profile_images'], 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = $committeeMembersImages.DIRECTORY_SEPARATOR.$filename;
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
            return redirect("/committee-members/manage/$id");
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

    public function committeeMemberListing(Request $request,$id){
        try{
            $records = array();
            $status = 200;
            $records['data'] = array();
            $records["draw"] = intval($request->draw);
            $membersData = CommitteeMembers::where('committee_id',$id)->orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_name') /*&& $request->search_name != ''*/){
                $membersData = CommitteeMembers::where('full_name','like','%'.$request->search_name.'%')
                    ->whereIn('id',$membersData)
                    ->pluck('id')->toArray();
                if(count($membersData) > 0){
                    $filterFlag = false;
                }
            }

            $finalMembersData = CommitteeMembers::whereIn('id', $membersData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalMembersData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalMembersData); $iterator++, $pagination++) {
                    $memberName = $finalMembersData[$pagination]->full_name;
                    $mobileNumber = $finalMembersData[$pagination]->mobile_number;
                    $emailId = $finalMembersData[$pagination]->email_id;
                    $srNo = $finalMembersData[$pagination]->id;
                    $gujaratiDetails = CommitteeMembersTranslations::where('member_id',$finalMembersData[$pagination]->id)->first();
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/committee-members/edit/' . $finalMembersData[$pagination]['id'] . '" style="color: white"> Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $memberName,
                        $gujaratiDetails['full_name'],
                        $mobileNumber,
                        $emailId,
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'Committee Member listing',
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

    public function editMemberView(Request $request,$id){
        try{
            $memberData  = CommitteeMembers::where('id',$id)->first();
            $memberDataGujarati = CommitteeMembersTranslations::where('member_id',$id)->first();
            $createMemberDirectoryName = sha1($memberData->id);
            $memberImg = env('COMMITTEE_MEMBER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createMemberDirectoryName.DIRECTORY_SEPARATOR.$memberData['profile_image'];
            return view('admin.committee.members.edit')->with(compact('memberData','memberImg','memberDataGujarati'));
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

    public function editMember(Request $request,$id){
        try{
            $data = $request->all();
            $memberData['full_name'] = $data['en']['full_name'];
            $memberData['designation'] = $data['en']['designation'];
            $memberData['mobile_number'] = $data['en']['mobile_number'];
            $memberData['email_id'] = $data['en']['email_id'];
            $editCommitteeMember = CommitteeMembers::where('id',$id)->update($memberData);

            $committeeMemberData = CommitteeMembers::where('id',$id)->first();

            if(array_key_exists('gj',$data)){
                if(array_key_exists('full_name',$data['gj'])){
                    $gujaratiMemberData['full_name'] = $data['gj']['full_name'];
                }if (array_key_exists('designation',$data['gj'])){
                    $gujaratiMemberData['designation'] = $data['gj']['designation'];
                }
                $gujaratiMemberData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiMemberData['member_id'] = $id;
                CommitteeMembersTranslations::where('member_id',$id)->update($gujaratiMemberData);
            }

            if ($editCommitteeMember) {
                $request->session()->flash('success', 'Member Edited Successfully');
            } else {
                $request->session()->flash('error', 'Something went wrong');
            }

            if($request->has('profile_images')){
                $createMemberDirectoryName = sha1($committeeMemberData['id']);
                $committeeMembersImages = public_path().env('COMMITTEE_MEMBER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createMemberDirectoryName;
                if($editCommitteeMember['profile_image'] != null){
                    unlink($committeeMembersImages.DIRECTORY_SEPARATOR.$editCommitteeMember['profile_image']);
                }
                if (!file_exists($committeeMembersImages)) {
                    File::makeDirectory($committeeMembersImages, $mode = 0777, true, true);
                }
                $imageArray = explode(';',$data['profile_images']);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($data['profile_images'], ';');
                $type = explode(':', substr($data['profile_images'], 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = $committeeMembersImages.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($image));
                $committeeMemberData->update([
                    'profile_image' => $filename,
                ]);

            }
            $memberData = CommitteeMembers::where('id',$id)->select('committee_id')->get();
            $committeeId = $memberData[0]->committee_id;
            return redirect("/committee-members/manage/$committeeId");
        }catch(\Exception $exception){
            $data = [
                'action' => 'Edit Committee Member',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }


    public function changeCommitteeStatus(Request $request,$id){
        try{
            $committeeData  = Committees::where('id',$id)->first();
            $status = $committeeData['is_active'];
            if($status){
                $committeeChangeStatus['is_active'] = false;
                $createCommittee = Committees::where('id',$id)->update($committeeChangeStatus);
                if ($createCommittee) {
                    $request->session()->flash('success', 'Committee Created Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }else{
                $committeeChangeStatus['is_active'] = true;
                $createCommittee = Committees::where('id',$id)->update($committeeChangeStatus);
                if ($createCommittee) {
                    $request->session()->flash('success', 'Committee Created Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }
            return redirect('/committee/manage');
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
