<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 23/11/18
 * Time: 12:52 PM
 */

namespace App\Http\Controllers\Classified;
use App\ClassifiedPackages;
use App\Http\Controllers\Controller;
use App\PackageRules;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\ClassifiedImages;
use App\Classifieds;
use App\ClassifiedsTranslations;
use App\Languages;
use App\Cities;
use App\States;
use App\Countries;
use Illuminate\Support\Facades\File;

class ClassifiedController extends Controller
{
    public function manage (Request $request){
        try{
            return view('admin/classified/manage');
        }catch (\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Classified View page',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createView(Request $request){
        try{
            $cities = Cities::get();
            $packages = ClassifiedPackages::get();
            return view('admin.classified.create')->with(compact('cities','packages'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create Classified View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function create(Request $request){
        try{
            $data = $request->all();
            $classifiedData['title'] = $data['en']['title'];
            $classifiedData['description'] = $data['en']['description'];
            $classifiedData['city_id'] = $data['en']['city'];
            $classifiedData['package_id'] = $data['en']['class_package_type'];
            $createClassified = Classifieds::create($classifiedData);
            $classifiedId = Classifieds::orderBy('created_at', 'desc')->value('id');
            $setIsActive['is_active'] = false;
            Classifieds::where('id',$classifiedId)->update($setIsActive);
            if($createClassified){
                $request->session()->flash('success','Classified Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            if(array_key_exists('gj',$data)){
                if(array_key_exists('title',$data['gj'])){
                    $gujaratiClassifiedData['title'] = $data['gj']['title'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiClassifiedData['classified_desc'] = $data['gj']['description'];
                }
                $gujaratiClassifiedData['classified_id'] = $createClassified->id;
                $gujaratiClassifiedData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                ClassifiedsTranslations::create($gujaratiClassifiedData);
            }
            if($request->has('classified_images')){
                $createClassifiedDirectoryName = sha1($createClassified->id);
                $classifiedImages = public_path().env('CLASSIFIED_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createClassifiedDirectoryName;
                if (!file_exists($classifiedImages)) {
                    File::makeDirectory($classifiedImages, $mode = 0777, true, true);
                }
                $images = $request->classified_images;
                foreach ($images as $classifiedImage) {
                    $imageArray = explode(';', $classifiedImage);
                    $image = explode(',', $imageArray[1])[1];
                    $pos = strpos($classifiedImage, ';');
                    $type = explode(':', substr($classifiedImage, 0, $pos))[1];
                    $extension = explode('/', $type)[1];
                    $filename = mt_rand(1, 10000000000) . sha1(time()) . ".{$extension}";
                    $fileFullPath = $classifiedImages . DIRECTORY_SEPARATOR . $filename;
                    file_put_contents($fileFullPath, base64_decode($image));
                    $imagesData['classified_id'] = $createClassified->id;
                    $imagesData['image_url'] = $filename;
                    ClassifiedImages::create($imagesData);
                }

            }
            return redirect('/classified/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create Classified',
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
            $classifiedsData = Classifieds::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_classified')){
                $classifiedsData = Classifieds::where('title','ilike','%'.$request->search_classified.'%')
                    ->whereIn('id',$classifiedsData)
                    ->pluck('id')->toArray();
                if(count($classifiedsData) < 0){
                    $filterFlag = false;
                }
            }
            if($filterFlag == true && $request->has('search_city') && $request->search_city != ''){
                $classifiedsData = Classifieds::join('cities','cities.id','=','classifieds.city_id')
                    ->where('cities.name','ilike','%'.$request->search_city.'%')
                    ->pluck('classifieds.id')
                    ->toArray();
                if(count($classifiedsData) < 0){
                    $filterFlag = false;
                }
            }


            $finalClassifiedsData = Classifieds::whereIn('id', $classifiedsData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalClassifiedsData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalClassifiedsData); $iterator++, $pagination++) {
                    $srNo = $iterator+1;
                    $eventName = str_limit($finalClassifiedsData[$pagination]->title,10);
                    $description = str_limit($finalClassifiedsData[$pagination]->description,10);
                    $package = ClassifiedPackages::where('id',$finalClassifiedsData[$pagination]->package_id)->first();
                    $packageType = PackageRules::where('id',$package['id'])->pluck('package_desc')->first();
                    $city = Cities::where('id',$finalClassifiedsData[$pagination]->city_id)->pluck('name')->first();
                    $date = $finalClassifiedsData[$pagination]->created_at;
                    $isActiveStatus = $finalClassifiedsData[$pagination]->is_active;
                    $id = $finalClassifiedsData[$pagination]->id;

                    $gujaratiDetails = ClassifiedsTranslations::where('classified_id',$finalClassifiedsData[$pagination]->id)->first();

                    $createClassifiedDirectoryName = sha1($id);
                    $image = ClassifiedImages::where('classified_id',$id)->first();
                    if ($image != null) {
                        $classifiedImage = env('CLASSIFIED_IMAGES_UPLOAD') . DIRECTORY_SEPARATOR . $createClassifiedDirectoryName . DIRECTORY_SEPARATOR . $image['image_url'];
                        $img = '<img src="'.$classifiedImage.'" class="avatar">';
                    }else{
                        $img = '<img src="'.env('DEFAULT_IMAGE').DIRECTORY_SEPARATOR."classified.png".'" class="avatar">';
                    }

                    if($isActiveStatus){
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$id)' id='status$id' value='$id' checked/>";
                    }else{
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$id)' id='status$id' value='$id'/>";
                    }
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue">
                        <a href="/classified/edit/' . $finalClassifiedsData[$pagination]['id'] . '" style="color: white">Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $eventName,
                        str_limit($gujaratiDetails['title'],10),
                        $description,
                        str_limit($gujaratiDetails['classified_desc'],10),
                        $package['package_name'],
                        $packageType,
                        $city,
                        $date->format('d M Y'),
                        $img,
                        $isActive,
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'Classified listing',
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

    public function editView(Request $request, $id){
        try{
            $countries = Countries::get();
            $packages = ClassifiedPackages::get();
            $classifiedData = Classifieds::where('id',$id)->first();
            $classifiedGujaratiData = ClassifiedsTranslations::where('classified_id',$id)->first();
            $cities = Cities::get();

            $classifiedPackage = ClassifiedPackages::where('id',$classifiedData['package_id'])->first();
            $classifiedPackageType = PackageRules::where('package_id',$classifiedPackage['id'])->first();

            $createClassifiedDirectoryName = sha1($classifiedData->id);
            $images = ClassifiedImages::where('classified_id',$id)->select('id','image_url')->get();
            if (count($images)>0) {
                $indexForImage = 0;
                $indexForId = 0;
                foreach ($images as $image) {
                    $classifiedImages[$indexForImage++] = env('CLASSIFIED_IMAGES_UPLOAD') . DIRECTORY_SEPARATOR . $createClassifiedDirectoryName . DIRECTORY_SEPARATOR . $image['image_url'];
                    $classifiedImagesId[$indexForId++] = $image['id'];
                }
            }else{
                $classifiedImages[] = null;
                $classifiedImagesId[] = null;
            }

            return view('admin.classified.edit')->with(compact('countries','packages','classifiedData','classifiedGujaratiData','cities','classifiedPackage','classifiedPackageType','classifiedImages','classifiedImagesId'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Edit Classified View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function edit(Request $request,$id){
        try{
            $data = $request->all();
            $classifiedData['title'] = $data['en']['title'];
            $classifiedData['description'] = $data['en']['description'];
            $classifiedData['city_id'] = $data['en']['city'];
            $classifiedData['package_id'] = $data['en']['class_package_type'];
            $editClassified = Classifieds::where('id',$id)->update($classifiedData);
            if($editClassified){
                $request->session()->flash('success','Classified Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            if(array_key_exists('gj',$data)){
                if(array_key_exists('title',$data['gj'])){
                    $gujaratiClassifiedData['title'] = $data['gj']['title'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiClassifiedData['classified_desc'] = $data['gj']['description'];
                }
                $gujaratiClassifiedId = ClassifiedsTranslations::where('id',$id)->value('id');
                if($gujaratiClassifiedId != null){
                    ClassifiedsTranslations::where('classified_id', $id)->update($gujaratiClassifiedData);
                } else {
                    $gujaratiClassifiedData['classified_id'] = $id;
                    $gujaratiClassifiedData['language_id'] = Languages::where('abbreviation', '=', 'gj')->pluck('id')->first();
                    ClassifiedsTranslations::create($gujaratiClassifiedData);
                }
            }
            if($request->has('classified_images')){
                $createClassifiedDirectoryName = sha1($id);
                $classifiedImages = public_path().env('CLASSIFIED_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createClassifiedDirectoryName;
                if (!file_exists($classifiedImages)) {
                    File::makeDirectory($classifiedImages, $mode = 0777, true, true);
                }
                $images = $request->classified_images;
                foreach ($images as $classifiedImage) {
                    $imageArray = explode(';', $classifiedImage);
                    $image = explode(',', $imageArray[1])[1];
                    $pos = strpos($classifiedImage, ';');
                    $type = explode(':', substr($classifiedImage, 0, $pos))[1];
                    $extension = explode('/', $type)[1];
                    $filename = mt_rand(1, 10000000000) . sha1(time()) . ".{$extension}";
                    $fileFullPath = $classifiedImages . DIRECTORY_SEPARATOR . $filename;
                    file_put_contents($fileFullPath, base64_decode($image));
                    $imagesData['classified_id'] = $id;
                    $imagesData['image_url'] = $filename;
                    ClassifiedImages::create($imagesData);
                }

            }

            return redirect("/classified/manage");
        }catch(\Exception $exception){
            $data = [
                'action' => 'Edit Classified',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function getAllPackageType(Request $request,$id){
        try{
            $packageType = PackageRules::where('package_id',$id)->get();
            return $packageType;
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

    public function changeStatus(Request $request,$id){
        try{
            $classifiedData  =Classifieds::where('id',$id)->first();
            $status = $classifiedData['is_active'];
            if($status){
                $changeStatus['is_active'] = false;
                $updateStatus = Classifieds::where('id',$id)->update($changeStatus);
                if ($updateStatus) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }else{
                $changeStatus['is_active'] = true;
                $updateStatus = Classifieds::where('id',$id)->update($changeStatus);
                if ($updateStatus) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }
            return redirect('/classified/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Classified Change Status',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function deleteClassifiedImage(Request $request,$id){
        try{
            $classifiedImg = ClassifiedImages::where('id', $id)->select('classified_id','image_url')->first();
            $ds = DIRECTORY_SEPARATOR;
            $classifiedId = $classifiedImg['classified_id'];
            $folderEncName = sha1($classifiedId);
            $webUploadPath = env('CLASSIFIED_IMAGES_UPLOAD');
            $file_to_be_deleted = public_path().$ds . $webUploadPath . $ds . $folderEncName . $ds . $classifiedImg['image_url'];
            if (!file_exists($file_to_be_deleted)) {
                return redirect("/classified/edit/$classifiedId");
            } else {
                unlink($file_to_be_deleted);
                ClassifiedImages::where('id',$id)->delete();
                return redirect("/classified/edit/$classifiedId");
            }
        }catch(\Exception $exception){
            $data = [
                'action' => 'delete image',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
}