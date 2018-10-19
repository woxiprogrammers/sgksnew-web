<?php

namespace App\Http\Controllers\members;

use App\BloodGroupType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class memberController extends Controller
{
    public function manageMembers(Request $request){
        try{
            return view('admin.members.membersView');
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
    public function createMembersView(Request $request){
        try{
            $blood_group_types = BloodGroupType::get();
            return view('admin.members.createMembers')->with(compact('blood_group_types'));
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
    public function createMembers(Request $request){
        try{
            dd($request->all());

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
}
