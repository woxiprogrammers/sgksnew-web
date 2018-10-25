<?php

namespace App\Http\Controllers\Committee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


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
            return view('admin.committee.create');
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

    public function manageMembers(Request $request){
        try{
            return view('admin.committee.viewMembers');
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
    public function addMember(Request $request){
        try{
            return view('admin.committee.addMember');
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

    public function createMember(Request $request){
        try{
            $data = $request->all();
            $membersData['first_name'] = $data->first_name;
            $membersData['middle_name'] = $data->middle_name;
            $membersData['last_name'] = $data->last_name;
            $membersData['designation'] = $data->desig;
            $membersData['mobile'] = $data->mobile_number;
            $membersData['email'] = $data->email_id;
            $membersData['city_id'] = $data->city;
            $createMember = Members::create($membersData);
            if($request->has('profile_images')){
                $createMemberDirectoryName = sha1($createMember->id);
                $imageUploadPath = public_path().env('MEMBER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createMemberDirectoryName;
                if (!file_exists($imageUploadPath)) {
                    File::makeDirectory($imageUploadPath, $mode = 0777, true, true);
                }
                $imageArray = explode(';',$data->profile_images);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($data->profile_images, ';');
                $type = explode(':', substr($data->profile_images, 0, $pos))[1];
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

    public function createCommittee(Request $request){
        try{
            $data = $request->all();
            $committeeData['name'] = $data->committee_name;
            $committeeData['description'] = $data->description;
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


}
