<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 30/12/18
 * Time: 6:07 PM
 */
namespace App\Http\Controllers\ManageAdmins;
use App\Cities;
use App\Http\Controllers\Controller;
use App\UserCities;
use App\UserRole;
use App\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ManageAdminController extends Controller
{
    public function manageAdmins(Request $request){
        try{
            return view('admin.admins.manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Admin View page',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createView(Request $request){
        try{
            $cities = Cities::orderBy('name','ASC')->get()->toArray();
            $userRoles = UserRole::get()->toArray();
            $alertMsg = null;
            return view('admin.admins.create')->with(compact('cities','userRoles','alertMsg'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create Event View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
    public function create(Request $request){
        try{
            $data = $request->all();
            if($request->has('email') && $request->email != null){
                $userData = Users::where('email',$request->email)->first();
                if($userData != null){
                    $cities = Cities::get()->toArray();
                    $userRoles = UserRole::get()->toArray();
                    $alertMsg = 'user with '.$request->email.' already present please enter different email id';
                    return view('admin.admins.create')->with(compact('cities','userRoles','alertMsg'));
                }
            }
            $user = new Users();
            $user->first_name = $data['fname'];
            $user->last_name= $data['lname'];
            $user->email = $data['email'];
            $user->mobile = $data['mobile'];
            $user->password = Hash::make($data['password']);
            $user->dob =  $data['dob'];
            $user->gender = $data['gender'];
            $user->is_active = false;
            $user->role_id = (int)$data['user-role'];
            $user->save();
            $userId = Users::orderBy('created_at','desc')->first();
            if ($request->has('cities')){
                $cityIds = $request->cities;
                foreach ($cityIds as $city){
                    $userCity['user_id'] = $userId['id'];
                    $userCity['city_id'] = $city;
                    UserCities::create($userCity);
                }
            }
            return redirect('/admin/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create Admin',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function listing(Request $request){
        try{
            $records = array();
            $status = 200;
            $records['data'] = array();
            $records["draw"] = intval($request->draw);
            $userData = Users::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_city')){
                $userData = Cities::where('name','ilike','%'.$request->search_city.'%')
                    ->whereIn('id',$userData)
                    ->pluck('id')->toArray();
                if(count($userData) < 0){
                    $filterFlag = false;
                }
            }

            $finalAdminData = Users::whereIn('id', $userData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalAdminData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalAdminData); $iterator++, $pagination++) {
                    $srNo = $iterator+1;
                    $fname = ucwords($finalAdminData[$pagination]->first_name);
                    $lname = ucwords($finalAdminData[$pagination]->last_name);
                    $mobile = $finalAdminData[$pagination]->mobile;
                    $emailId = $finalAdminData[$pagination]->email;
                    $isActiveStatus = $finalAdminData[$pagination]->is_active;
                    $id = $finalAdminData[$pagination]->id;
                    $cities = UserCities::where('user_id',$id)->pluck('city_id')->toArray();
                    $userCities = Cities::whereIn('id',$cities)->get()->toArray();
                    $userCity = null;
                    foreach ($userCities as $city){
                        $userCity = $userCity." ". $city['name'];
                    }
                    if($isActiveStatus){
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$id)' id='status$id' value='$id' checked/>";
                    }else{
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$id)' id='status$id' value='$id'/>";
                    }
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue">
                        <a href="/admin/edit/' . $finalAdminData[$pagination]['id'] . '" style="color: white">Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $fname ." ".$lname,
                        $mobile,
                        $emailId,
                        $userCity,
                        $isActive,
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'Admin listing',
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
            $userData = Users::where('id',$id)->get()->first();
            $cities = Cities::orderBy('name','ASC')->get()->toArray();
            $cityIds = UserCities::where('user_id',$id)->pluck('city_id')->toArray();
            $userCities = Cities::whereIn('id',$cityIds)->get()->toArray();
            $userRoles = UserRole::get()->toArray();
            $alertMsg = null;
            return view('admin.admins.edit')->with(compact('userData','userCities','cities','userRoles','alertMsg'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create Admin View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function edit(Request $request,$id){
        try{
            $data = $request->all();
            if($request->has('email')){
                $usersId = Users::where('id',$id)->pluck('id')->toArray();
                $usersIds = Users::whereNotIn('id',$usersId)->where('email',$request->email)->pluck('id')->toArray();
                if(count($usersIds) > 0){
                    $userData = Users::where('id',$id)->get()->first();
                    $cities = Cities::get()->toArray();
                    $cityIds = UserCities::where('user_id',$id)->pluck('city_id')->toArray();
                    $userCities = Cities::whereIn('id',$cityIds)->get()->toArray();
                    $userRoles = UserRole::get()->toArray();
                    $alertMsg = 'user with '.$request->email.' already present please enter different email id';
                    return view('admin.admins.edit')->with(compact('userData','userCities','cities','userRoles','alertMsg'));
                }
            }
            $adminData['first_name'] = $data['fname'];
            $adminData['last_name'] = $data['lname'];
            $adminData['email'] = $data['email'];
            $adminData['mobile'] = $data['mobile'];
            $adminData['password'] = Hash::make($data['password']);
            $adminData['dob'] = $data['dob'];
            if(array_key_exists('gender',$data)){
                $adminData['gender'] = $data['gender'];
            }
            $adminData['is_active'] = false;
            $adminData['role_id'] = (int)$data['user-role'];
            $editAdmin = Users::where('id',$id)->update($adminData);
            if ($request->has('cities')){
                $cityIds = $request->cities;
                foreach ($cityIds as $city){
                    $userCity['user_id'] = $id;
                    $userCity['city_id'] = $city;
                    UserCities::create($userCity);
                }
            }
            if ($editAdmin) {
                $request->session()->flash('success', 'Admin Edited Successfully');
            } else {
                $request->session()->flash('error', 'Something went wrong');
            }
            return redirect("/admin/manage");
        }catch(\Exception $exception){
            $data = [
                'action' => 'Edit Admin',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function changeStatus(Request $request,$id){
        try{
            $adminData  =Users::where('id',$id)->first();
            $status = $adminData['is_active'];
            if($status){
                $changeStatus['is_active'] = false;
                $updateStatus = Users::where('id',$id)->update($changeStatus);
                if ($updateStatus) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }else{
                $changeStatus['is_active'] = true;
                $updateStatus = Users::where('id',$id)->update($changeStatus);
                if ($updateStatus) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }
            return redirect('/admin/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Admin Status',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
}