<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 15/11/18
 * Time: 1:38 PM
 */
namespace App\Http\Controllers\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Countries;
use App\States;
use App\Cities;
use App\MessageTypes;
use App\MessageTranslations;
use App\Messages;
use App\Languages;
use Illuminate\Support\Facades\File;

class MessageController extends Controller
{

    public function manage(Request $request){
        try{
            return view('admin.messages.manage');
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Messages View page',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createView(Request $request){
        try{
            $countries = Countries::get();
            $messageTypes = new MessageTypes();
            $message_Types = $messageTypes->get();
            return view('admin.messages.create')->with(compact('countries','message_Types'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create Message View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function create(Request $request){
        try{
            $data = $request->all();
            //while creating new buzz deactivate all previous buzz
            if($data['en']['message_type'] == 1){
                $buzzMessages = Messages::where('message_type_id',1)->
                                      where('is_active',true)->get();
                foreach ($buzzMessages as $buzzMessage){
                    $buzzMessage->update([
                        'is_active' => false,
                    ]);
                }
            }
            $messageData['title'] = $data['en']['title'];
            $messageData['description'] = $data['en']['description'];
            $messageData['message_type_id'] = $data['en']['message_type'];
            $messageData['city_id'] = $data['en']['city'];
            $createMessage = Messages::create($messageData);
            if(array_key_exists('gj',$data)){
                if(array_key_exists('title',$data['gj'])){
                    $gujaratiMessageData['title'] = $data['gj']['title'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiMessageData['description'] = $data['gj']['description'];
                }
                $gujaratiMessageData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiMessageData['message_id'] = $createMessage->id;
                MessageTranslations::create($gujaratiMessageData);
            }
            if($request->has('message_images')){
                $createMessageDirectoryName = sha1($createMessage->id);
                $MessageImages = public_path().env('MESSAGE_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createMessageDirectoryName;
                if (!file_exists($MessageImages)) {
                    File::makeDirectory($MessageImages, $mode = 0777, true, true);
                }
                $imageArray = explode(';',$data['message_images']);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($data['message_images'], ';');
                $type = explode(':', substr($data['message_images'], 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = $MessageImages.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($image));
                $createMessage->update([
                    'image_url' => $filename,
                ]);
            }
            if($createMessage){
                $request->session()->flash('success','Message Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            return redirect("/message/manage");
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create Message',
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
            $messageData = Messages::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_message') /*&& $request->search_name != ''*/){
                $messageData = Messages::where('title','like','%'.$request->search_message.'%')
                    ->whereIn('id',$messageData)
                    ->pluck('id')->toArray();
                if(count($messageData) > 0){
                    $filterFlag = false;
                }
            }

            $finalMessagesData = Messages::whereIn('id', $messageData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalMessagesData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalMessagesData); $iterator++, $pagination++) {
                    $srNo = $iterator+1;
                    $title = str_limit($finalMessagesData[$pagination]->title,20);
                    $description = str_limit($finalMessagesData[$pagination]->description,20);
                    $date = $finalMessagesData[$pagination]->created_at;
                    $isActiveStatus = $finalMessagesData[$pagination]->is_active;
                    $id = $finalMessagesData[$pagination]->id;
                    $gujaratiDetails = MessageTranslations::where('message_id',$finalMessagesData[$pagination]->id)->first();
                    if ($isActiveStatus) {
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$id)' id='status$id' value='$id' checked/>";
                    } else {
                        $isActive = "<input type='checkbox' class='js-switch' onchange='return statusFolder(this.checked,$id)' id='status$id' value='$id'/>";
                    }
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/message/edit/' . $finalMessagesData[$pagination]['id'] . '" style="color: white"> Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $title,
                        str_limit($gujaratiDetails['title'],20),
                        $description,
                        str_limit($gujaratiDetails['description'],20),
                        $date->format('d/M/Y'),
                        $isActive,
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'Messages listing',
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
            $messageData = Messages::where('id',$id)->first();
            $messageDataGujarati = MessageTranslations::where('message_id',$id)->first();
            $countries = Countries::get();

            $cityId = $messageData['city_id'];
            $city = Cities::where('id',$cityId)->first();
            $cityName = $city['name'];
            $stateId = $city['state_id'];
            $state = States::where('id',$stateId)->first();
            $stateName = $state['name'];
            $countryId = $state['country_id'];
            $country = Countries::where('id',$countryId)->first();
            $countryName = $country['name'];

            $messageTypes = new MessageTypes();
            $message_Types = $messageTypes->get();

            $createMessageDirectoryName = sha1($messageData->id);
            $image = $messageData['image_url'];
            if($image != null) {
                $messageImage = env('MESSAGE_IMAGES_UPLOAD') . DIRECTORY_SEPARATOR . $createMessageDirectoryName . DIRECTORY_SEPARATOR . $image;
            }else{
                $messageImage = null;
            }
            return view('admin.messages.edit')->with(compact('countries','messageData','messageDataGujarati','cityName','stateName','countryName','cityId','messageImage','message_Types'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create Message View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function edit(Request $request,$id){
        try{
            $data = $request->all();
            //while creating new buzz deactivate all previous buzz
            if($data['en']['message_type'] == 1){
                $buzzMessages = Messages::where('message_type_id',1)->
                where('is_active',true)->get();
                foreach ($buzzMessages as $buzzMessage){
                    $buzzMessage->update([
                        'is_active' => false,
                    ]);
                }
            }
            $messageData['title'] = $data['en']['title'];
            $messageData['description'] = $data['en']['description'];
            $messageData['message_type_id'] = $data['en']['message_type'];
            $messageData['city_id'] = $data['en']['city'];
            if($data['en']['message_type'] == 1){
                $messageData['is_active'] = true;
            }
            $editMessage = Messages::where('id',$id)->update($messageData);
            if(array_key_exists('gj',$data)){
                if(array_key_exists('title',$data['gj'])){
                    $gujaratiMessageData['title'] = $data['gj']['title'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiMessageData['description'] = $data['gj']['description'];
                }
                $gujaratiMessageData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiMessageData['message_id'] = $id;
                MessageTranslations::where('message_id',$id)->update($gujaratiMessageData);
            }
            if($request->has('message_images')){
                $createMessageDirectoryName = sha1($id);
                $MessageImages = public_path().env('MESSAGE_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createMessageDirectoryName;
                if (!file_exists($MessageImages)) {
                    File::makeDirectory($MessageImages, $mode = 0777, true, true);
                }
                $imageArray = explode(';',$data['message_images']);
                $image = explode(',',$imageArray[1])[1];
                $pos  = strpos($data['message_images'], ';');
                $type = explode(':', substr($data['message_images'], 0, $pos))[1];
                $extension = explode('/',$type)[1];
                $filename = mt_rand(1,10000000000).sha1(time()).".{$extension}";
                $fileFullPath = $MessageImages.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($fileFullPath,base64_decode($image));
                $editMessage = Messages::where('id',$id)->first();
                $editMessage->update([
                    'image_url' => $filename,
                ]);
            }
            if($editMessage){
                $request->session()->flash('success','Message Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            return redirect('/message/manage');
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
            $messageData  =Messages::where('id',$id)->first();
            $status = $messageData['is_active'];
            //deactivate all buzz messages while activating this
            if($messageData['message_type_id'] == 1 && $messageData['is_active'] == false){
                $buzzMessages = Messages::where('message_type_id',1)->
                where('is_active',true)->get();
                foreach ($buzzMessages as $buzzMessage){
                    $buzzMessage->update([
                        'is_active' => false,
                    ]);
                }
            }
            if($status){
                $changeStatus['is_active'] = false;
                $createMessage = Messages::where('id',$id)->update($changeStatus);
                if ($createMessage) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }else{
                $changeStatus['is_active'] = true;
                $createMessage = Messages::where('id',$id)->update($changeStatus);
                if ($createMessage) {
                    $request->session()->flash('success', 'Status changes Successfully');
                } else {
                    $request->session()->flash('error', 'Something went wrong');
                }
            }
            return redirect('/message/manage');
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

    public function deleteImage(Request $request,$id){
        try{
            $messageData = Messages::where('id', $id)->first();
            $image = $messageData['image_url'];
            $ds = DIRECTORY_SEPARATOR;
            $folderEncName = sha1($id);
            $webUploadPath = env('MESSAGE_IMAGES_UPLOAD');
            $file_to_be_deleted = public_path().$ds . $webUploadPath . $ds . $folderEncName . $ds . $image;
            if (!file_exists($file_to_be_deleted)) {
                return redirect("/message/edit/$id");
            } else {
                unlink($file_to_be_deleted);
                $messageData->update([
                    'image_url' => null,
                ]);
                return redirect("/message/edit/$id");
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