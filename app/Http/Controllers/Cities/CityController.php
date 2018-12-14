<?php
/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 27/11/18
 * Time: 2:31 PM
 */
namespace App\Http\Controllers\Cities;
use App\Cities;
use App\CitiesTranslation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Languages;

class CityController extends Controller
{
    public function manage(Request $request){
        try{
            return view('admin.cities.manage');
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Cities View page',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createView(Request $request){
        try{
            $message = null;
            return view('admin.cities.create')->with(compact('message'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create City View',
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
            $cityData['name'] = $data['en']['city'];
            $cityData['state_id'] =1;
            $cityName = Cities::where('name','ilike',$data['en']['city'])->value('name');
            if($cityName != null){
                $message = 'City with name '.$data['en']['city'].' already exist';
                return view('admin.cities.create')->with(compact('message'));
            } else {
                $createCity = Cities::create($cityData);
            }
            if(array_key_exists('gj',$data)){
                if(array_key_exists('city',$data['gj'])){
                    $gujaratiCityData['name'] = $data['gj']['city'];
                }
                $gujaratiCityData['city_id'] = $createCity->id;
                $gujaratiCityData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                CitiesTranslation::create($gujaratiCityData);
            }
            if($createCity){
                $request->session()->flash('success','City Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            return redirect('/cities/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create City',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function editView(Request $request, $id){
        try{
            $city = Cities::where('id',$id)->first();
            $gujaratiCityData = CitiesTranslation::where('city_id',$id)->first();

            return view('admin.cities.edit')->with(compact('city','gujaratiCityData'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'City Edit View',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function edit(Request $request, $id){
        try{
            $data = $request->all();
            $gujaratiCityId = null;
            $cityData['name'] = $data['en']['city'];
            $cityData['state_id'] =1;
            $updateCity = Cities::where('id',$id)->update($cityData);
            if(array_key_exists('gj',$data)){
                if(array_key_exists('city',$data['gj'])){
                    $gujaratiCityData['name'] = $data['gj']['city'];
                }
                $gujaratiCityData['city_id'] = $id;
                $gujaratiCityData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiCityId = CitiesTranslation::where('city_id',$id)->value('id');
                if($gujaratiCityId != null) {
                    CitiesTranslation::where('city_id', $id)->update($gujaratiCityData);
                } else {
                    CitiesTranslation::create($gujaratiCityData);
                }
            }
            if($updateCity){
                $request->session()->flash('success','City Updated Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            return redirect('/cities/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Edit City',
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
            $citiesData = Cities::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_city')){
                $citiesData = Cities::where('name','ilike','%'.$request->search_city.'%')
                    ->whereIn('id',$citiesData)
                    ->pluck('id')->toArray();
                if(count($citiesData) < 0){
                    $filterFlag = false;
                }
            }

            $finalCitiesData = Cities::whereIn('id', $citiesData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalCitiesData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalCitiesData); $iterator++, $pagination++) {
                    $srNo = $iterator+1;
                    $cityName = $finalCitiesData[$pagination]->name;
                    $isActiveStatus = $finalCitiesData[$pagination]->is_active;
                    $date = $finalCitiesData[$pagination]->created_at;
                    $id = $finalCitiesData[$pagination]->id;
                    $gujaratiCityName = CitiesTranslation::where('city_id',$id)->value('name');
                    if($isActiveStatus){
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$id)' id='status$id' value='$id' checked/>";
                    }else{
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$id)' id='status$id' value='$id'/>";
                    }
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue">
                        <a href="/cities/edit/' . $finalCitiesData[$pagination]['id'] . '" style="color: white">Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $cityName,
                        $gujaratiCityName,
                        $date->format('d M Y'),
                        $isActive,
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'City listing',
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

    public function changeStatus(Request $request,$id){
        try{
            $cityData  =Cities::where('id',$id)->first();
            $status = $cityData['is_active'];
            if($status){
                $changeStatus['is_active'] = false;
                $updateStatus = Cities::where('id',$id)->update($changeStatus);
                if ($updateStatus) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }else{
                $changeStatus['is_active'] = true;
                $updateStatus = Cities::where('id',$id)->update($changeStatus);
                if ($updateStatus) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }
            return redirect('/cities/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'City Change Status',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

}