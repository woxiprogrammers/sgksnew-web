<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 5/11/18
 * Time: 11:00 AM
 */
namespace App\Http\Controllers\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Countries;
use App\States;
use App\Cities;
use App\Events;
use App\EventImages;
use App\EventsTranslations;
use App\Languages;
use Illuminate\Support\Facades\File;


class EventController extends Controller
{

    public function manageEvents(Request $request){
        try{
            return view('admin.events.manage');
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
            $countries = Countries::get();
            return view('admin.events.create')->with(compact('countries'));
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
            $eventData['event_name'] = $data['en']['event_name'];
            $eventData['description'] = $data['en']['description'];
            $eventData['venue'] = $data['en']['venue'];
            $eventData['start_date'] = $data['en']['start_date'];
            $eventData['end_date'] = $data['en']['end_date'];
            $eventData['city_id'] = $data['en']['city'];
            $createEvent = Events::create($eventData);
            if($createEvent){
                $request->session()->flash('success','Committee Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            if(array_key_exists('gj',$data)){
                if(array_key_exists('event_name',$data['gj'])){
                    $gujaratiEventData['event_name'] = $data['gj']['event_name'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiEventData['description'] = $data['gj']['description'];
                }if (array_key_exists('venue',$data['gj'])){
                    $gujaratiEventData['venue'] = $data['gj']['venue'];
                }
                $gujaratiEventData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiEventData['event_id'] = $createEvent->id;
                EventsTranslations::create($gujaratiEventData);
            }
            if($request->has('event_images')){
                $createEventDirectoryName = sha1($createEvent->id);
                $eventImages = public_path().env('EVENT_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createEventDirectoryName;
                if (!file_exists($eventImages)) {
                    File::makeDirectory($eventImages, $mode = 0777, true, true);
                }
                $images = $request->event_images;
                foreach ($images as $eventImage) {
                    $imageArray = explode(';', $eventImage);
                    $image = explode(',', $imageArray[1])[1];
                    $pos = strpos($eventImage, ';');
                    $type = explode(':', substr($eventImage, 0, $pos))[1];
                    $extension = explode('/', $type)[1];
                    $filename = mt_rand(1, 10000000000) . sha1(time()) . ".{$extension}";
                    $fileFullPath = $eventImages . DIRECTORY_SEPARATOR . $filename;
                    file_put_contents($fileFullPath, base64_decode($image));
                    $imagesData['event_id'] = $createEvent->id;
                    $imagesData['url'] = $filename;
                    EventImages::create($imagesData);
                }

            }
            return redirect('/event/manage');
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

    public function listing(Request $request){
        try{
            $records = array();
            $status = 200;
            $records['data'] = array();
            $records["draw"] = intval($request->draw);
            $eventsData = Events::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_event') /*&& $request->search_name != ''*/){
                $eventsData = Events::where('event_name','like','%'.$request->search_event.'%')
                    ->whereIn('id',$eventsData)
                    ->pluck('id')->toArray();
                if(count($eventsData) > 0){
                    $filterFlag = false;
                }
            }

            $finalEventsData = Events::whereIn('id', $eventsData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalEventsData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalEventsData); $iterator++, $pagination++) {
                    $eventName = str_limit($finalEventsData[$pagination]->event_name,15);
                    $description = str_limit($finalEventsData[$pagination]->description,15);
                    $venue = str_limit($finalEventsData[$pagination]->venue,15);
                    $startDate = $finalEventsData[$pagination]->start_date;
                    $endDate = $finalEventsData[$pagination]->end_date;
                    $isActiveStatus = $finalEventsData[$pagination]->is_active;
                    $srNo = $finalEventsData[$pagination]->id;
                    $gujaratiDetails = EventsTranslations::where('event_id',$finalEventsData[$pagination]->id)->first();
                    if($isActiveStatus){
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$srNo)' id='status$srNo' value='$srNo' checked/>";
                    }else{
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$srNo)' id='status$srNo' value='$srNo'/>";
                    }
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue">
                        <a href="/event/edit/' . $finalEventsData[$pagination]['id'] . '" style="color: white">Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $eventName,
                        str_limit($gujaratiDetails['event_name'],15),
                        $description,
                        str_limit($gujaratiDetails['description'],15),
                        $venue,
                        str_limit($gujaratiDetails['venue'],15),
                        $startDate,
                        $endDate,
                        $isActive,
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'Event listing',
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
            $eventData = Events::where('id',$id)->first();
            $eventDataGujarati = EventsTranslations::where('event_id',$id)->first();
            $countries = Countries::get();

            $cityId = $eventData['city_id'];
            $city = Cities::where('id',$cityId)->first();
            $cityName = $city['name'];
            $stateId = $city['state_id'];
            $state = States::where('id',$stateId)->first();
            $stateName = $state['name'];
            $countryId = $state['country_id'];
            $country = Countries::where('id',$countryId)->first();
            $countryName = $country['name'];

            $createEventDirectoryName = sha1($eventData->id);
            $images = EventImages::where('event_id',$id)->select('id','url')->get();
            if (count($images)>0) {
                $indexForImage = 0;
                $indexForId = 0;
                foreach ($images as $image) {
                    $eventImages[$indexForImage++] = env('EVENT_IMAGES_UPLOAD') . DIRECTORY_SEPARATOR . $createEventDirectoryName . DIRECTORY_SEPARATOR . $image['url'];
                    $eventImagesId[$indexForId++] = $image['id'];
                }
            }else{
                $eventImages[] = null;
                $eventImagesId[] = null;
            }
            return view('admin.events.edit')->with(compact('countries','eventData','eventDataGujarati','cityName','stateName','countryName','cityId','eventImages','eventImagesId'));
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

    public function edit(Request $request,$id){
        try{
            $data = $request->all();
            $eventData['event_name'] = $data['en']['event_name'];
            $eventData['description'] = $data['en']['description'];
            $eventData['venue'] = $data['en']['venue'];
            $eventData['start_date'] = $data['en']['start_date'];
            $eventData['end_date'] = $data['en']['end_date'];
            $eventData['city_id'] = $data['en']['city'];
            $editEvent = Events::where('id',$id)->update($eventData);
            if ($editEvent) {
                $request->session()->flash('success', 'Member Edited Successfully');
            } else {
                $request->session()->flash('error', 'Something went wrong');
            }

            if(array_key_exists('gj',$data)){
                if(array_key_exists('event_name',$data['gj'])){
                    $gujaratiEventData['event_name'] = $data['gj']['event_name'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiEventData['description'] = $data['gj']['description'];
                }if (array_key_exists('venue',$data['gj'])){
                    $gujaratiEventData['venue'] = $data['gj']['venue'];
                }
                $gujaratiEventData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiEventData['event_id'] = $id;
                EventsTranslations::where('event_id',$id)->update($gujaratiEventData);
            }

            if($request->has('event_images')){
                $createEventDirectoryName = sha1($id);
                $eventImages = public_path().env('EVENT_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createEventDirectoryName;
                if (!file_exists($eventImages)) {
                    File::makeDirectory($eventImages, $mode = 0777, true, true);
                }
                $images = $request->event_images;
                foreach ($images as $eventImage) {
                    $imageArray = explode(';', $eventImage);
                    $image = explode(',', $imageArray[1])[1];
                    $pos = strpos($eventImage, ';');
                    $type = explode(':', substr($eventImage, 0, $pos))[1];
                    $extension = explode('/', $type)[1];
                    $filename = mt_rand(1, 10000000000) . sha1(time()) . ".{$extension}";
                    $fileFullPath = $eventImages . DIRECTORY_SEPARATOR . $filename;
                    file_put_contents($fileFullPath, base64_decode($image));
                    $imagesData['event_id'] = $id;
                    $imagesData['url'] = $filename;
                    EventImages::create($imagesData);
                }

            }

            return redirect("/event/manage");
        }catch(\Exception $exception){
            $data = [
                'action' => 'Edit Event',
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

    public function changeStatus(Request $request,$id){
        try{
            $eventData  =Events::where('id',$id)->first();
            $status = $eventData['is_active'];
            if($status){
                $changeStatus['is_active'] = false;
                $createEvent = Events::where('id',$id)->update($changeStatus);
                if ($createEvent) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }else{
                $changeStatus['is_active'] = true;
                $createEvent = Events::where('id',$id)->update($changeStatus);
                if ($createEvent) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }
            return redirect('/event/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Event Change Status',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function deleteEventImage(Request $request,$id){
        try{
            $folderId = EventImages::where('id', $id)->select('event_id','url')->first();
            $ds = DIRECTORY_SEPARATOR;
            $eventId = $folderId['event_id'];
            $folderEncName = sha1($eventId);
            $webUploadPath = env('EVENT_IMAGES_UPLOAD');
            $file_to_be_deleted = public_path().$ds . $webUploadPath . $ds . $folderEncName . $ds . $folderId['url'];
            if (!file_exists($file_to_be_deleted)) {
                return redirect("/event/edit/$eventId");
            } else {
                unlink($file_to_be_deleted);
                EventImages::where('id',$id)->delete();
                return redirect("/event/edit/$eventId");
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