<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 5/11/18
 * Time: 11:00 AM
 */
namespace App\Http\Controllers\Account;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Countries;
use App\States;
use App\Cities;
use App\Accounts;
use App\AccountImages;
use App\Languages;
use App\AccountsTranslations;
use Illuminate\Support\Facades\File;


class AccountController extends Controller
{
    public function manage(Request $request){
        try{
            return view('admin.accounts.manage');
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
            return view('admin.accounts.create')->with(compact('countries'));
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
            $accountData['name'] = $data['en']['account_name'];
            $accountData['description'] = $data['en']['description'];
            $accountData['city_id'] = $data['en']['city'];
            $createAccount = Accounts::create($accountData);
            if($createAccount){
                $request->session()->flash('success','Account Created Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            if(array_key_exists('gj',$data)){
                if(array_key_exists('account_name',$data['gj'])){
                    $gujaratiAccountData['name'] = $data['gj']['account_name'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiAccountData['description'] = $data['gj']['description'];
                }
                $gujaratiAccountData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiAccountData['account_id'] = $createAccount->id;
                AccountsTranslations::create($gujaratiAccountData);
            }
            if($request->has('account_images')){
                $createEventDirectoryName = sha1($createAccount->id);
                $eventImages = public_path().env('ACCOUNT_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createEventDirectoryName;
                if (!file_exists($eventImages)) {
                    File::makeDirectory($eventImages, $mode = 0777, true, true);
                }
                $images = $request->account_images;
                foreach ($images as $accountImage) {
                    $imageArray = explode(';', $accountImage);
                    $image = explode(',', $imageArray[1])[1];
                    $pos = strpos($accountImage, ';');
                    $type = explode(':', substr($accountImage, 0, $pos))[1];
                    $extension = explode('/', $type)[1];
                    $filename = mt_rand(1, 10000000000) . sha1(time()) . ".{$extension}";
                    $fileFullPath = $eventImages . DIRECTORY_SEPARATOR . $filename;
                    file_put_contents($fileFullPath, base64_decode($image));
                    $imagesData['account_id'] = $createAccount->id;
                    $imagesData['url'] = $filename;
                    AccountImages::create($imagesData);
                }

            }
            return redirect('/account/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Create Account',
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
            $accountsData = Accounts::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_account') /*&& $request->search_name != ''*/){
                $accountsData = Accounts::where('name','like','%'.$request->search_account.'%')
                    ->whereIn('id',$accountsData)
                    ->pluck('id')->toArray();
                if(count($accountsData) > 0){
                    $filterFlag = false;
                }
            }
            $finalAccountsData = Accounts::whereIn('id', $accountsData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalAccountsData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalAccountsData); $iterator++, $pagination++) {
                    $accountName = str_limit($finalAccountsData[$pagination]->name,20);
                    $description = str_limit($finalAccountsData[$pagination]->description,20);
                    $srNo = $finalAccountsData[$pagination]->id;
                    $gujaratiDetails = AccountsTranslations::where('account_id',$finalAccountsData[$pagination]->id)->first();
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue">
                        <a href="/account/edit/' . $finalAccountsData[$pagination]['id'] . '" style="color: white">Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $accountName,
                        str_limit($gujaratiDetails['name'],20),
                        $description,
                        str_limit($gujaratiDetails['description'],20),
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'Account listing',
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
            $accountData = Accounts::where('id',$id)->first();
            $accountDataGujarati = AccountsTranslations::where('account_id',$id)->first();
            $countries = Countries::get();

            $cityId = $accountData['city_id'];
            $city = Cities::where('id',$cityId)->first();
            $cityName = $city['name'];
            $stateId = $city['state_id'];
            $state = States::where('id',$stateId)->first();
            $stateName = $state['name'];
            $countryId = $state['country_id'];
            $country = Countries::where('id',$countryId)->first();
            $countryName = $country['name'];

            $createAccountDirectoryName = sha1($accountData->id);
            $images = AccountImages::where('account_id',$id)->select('id','url')->get();
            if (count($images)>0) {
                $indexForImage = 0;
                $indexForId = 0;
                foreach ($images as $image) {
                    $accountImages[$indexForImage++] = env('ACCOUNT_IMAGES_UPLOAD') . DIRECTORY_SEPARATOR . $createAccountDirectoryName . DIRECTORY_SEPARATOR . $image['url'];
                    $accountImagesId[$indexForId++] = $image['id'];
                }
            }else{
                $accountImages[] = null;
                $accountImagesId[] = null;
            }
            return view('admin.accounts.edit')->with(compact('countries','accountData','accountDataGujarati','cityName','stateName','countryName','cityId','accountImages','accountImagesId'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Create Account Edit View',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function edit(Request $request,$id){
        try{
            $data = $request->all();
            $accountData['name'] = $data['en']['account_name'];
            $accountData['description'] = $data['en']['description'];
            $accountData['city_id'] = $data['en']['city'];
            $editAccount = Accounts::where('id',$id)->update($accountData);
            if ($editAccount) {
                $request->session()->flash('success', 'Account Edited Successfully');
            } else {
                $request->session()->flash('error', 'Something went wrong');
            }

            if(array_key_exists('gj',$data)){
                if(array_key_exists('account_name',$data['gj'])){
                    $gujaratiAccountData['name'] = $data['gj']['account_name'];
                }if (array_key_exists('description',$data['gj'])){
                    $gujaratiAccountData['description'] = $data['gj']['description'];
                }
                $gujaratiAccountData['language_id'] = Languages::where('abbreviation','=','gj')->pluck('id')->first();
                $gujaratiAccountData['account_id'] = $id;
                AccountsTranslations::where('account_id',$id)->update($gujaratiAccountData);
            }

            if($request->has('account_images')){
                $createAccountDirectoryName = sha1($id);
                $accountImages = public_path().env('ACCOUNT_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.$createAccountDirectoryName;
                if (!file_exists($accountImages)) {
                    File::makeDirectory($accountImages, $mode = 0777, true, true);
                }
                $images = $request->account_images;
                foreach ($images as $accountImage) {
                    $imageArray = explode(';', $accountImage);
                    $image = explode(',', $imageArray[1])[1];
                    $pos = strpos($accountImage, ';');
                    $type = explode(':', substr($accountImage, 0, $pos))[1];
                    $extension = explode('/', $type)[1];
                    $filename = mt_rand(1, 10000000000) . sha1(time()) . ".{$extension}";
                    $fileFullPath = $accountImages . DIRECTORY_SEPARATOR . $filename;
                    file_put_contents($fileFullPath, base64_decode($image));
                    $imagesData['account_id'] = $id;
                    $imagesData['url'] = $filename;
                    AccountImages::create($imagesData);
                }

            }

            return redirect("/account/manage");
        }catch(\Exception $exception){
            $data = [
                'action' => 'Edit Account',
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

    public function deleteAccountImage(Request $request,$id){
        try{
            $folderId = AccountImages::where('id', $id)->select('account_id','url')->first();
            $ds = DIRECTORY_SEPARATOR;
            $accountId = $folderId['account_id'];
            $folderEncName = sha1($accountId);
            $webUploadPath = env('ACCOUNT_IMAGES_UPLOAD');
            $file_to_be_deleted = public_path().$ds . $webUploadPath . $ds . $folderEncName . $ds . $folderId['url'];
            if (!file_exists($file_to_be_deleted)) {
                return redirect("/account/edit/$accountId");
            } else {
                unlink($file_to_be_deleted);
                AccountImages::where('id',$id)->delete();
                return redirect("/account/edit/$accountId");
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