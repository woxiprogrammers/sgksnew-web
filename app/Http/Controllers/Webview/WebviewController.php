<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 28/11/18
 * Time: 2:20 PM
 */
namespace App\Http\Controllers\Webview;
use App\Countries;
use App\DrawerWebview;
use App\DrawerWebviewDetails;
use App\DrawerWebviewDetailsTranslations;
use App\States;
use App\Cities;
use App\Languages;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
class WebviewController extends Controller
{
    public function manage(Request $request)
    {
        try {
            return view('admin.webview.manage');
        } catch (\Exception $exception) {
            $data = [
                'params' => $request->all(),
                'action' => 'Webview View page',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createView(Request $request)
    {
        try {
            $drawerWeb = DrawerWebview::get();
            $drawerWebDetails = DrawerWebviewDetails::get();
            $cities = Cities::get();
            return view('admin.webview.create')->with(compact('drawerWeb', 'drawerWebDetails','cities'));
        } catch (\Exception $exception) {
            $data = [
                'action' => 'Webview View page',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $webviewData['drawer_web_id'] = $data['en']['webviewType'];
            $webviewData['description'] = $data['en']['description'];
            $webviewData['city_id'] = $data['en']['city'];
            $createWebview = DrawerWebviewDetails::create($webviewData);

            if (array_key_exists('gj', $data)) {
                if (array_key_exists('description', $data['gj'])) {
                    $gujaratiWebviewData['description'] = $data['gj']['description'];
                }
                $gujaratiWebviewData['language_id'] = Languages::where('abbreviation', '=', 'gj')->pluck('id')->first();
                $gujaratiWebviewData['drawer_webview_details_id'] = $createWebview->id;
                DrawerWebviewDetailsTranslations::create($gujaratiWebviewData);
            }

            if ($createWebview) {
                $request->session()->flash('success', 'Data Inserted Successfully');
            } else {
                $request->session()->flash('error', 'Something went wrong');
            }
            return redirect('/webview/manage');
        } catch (\Exception $exception) {
            $data = [
                'action' => 'Create Webview',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function listing(Request $request)
    {
        try {
            $records = array();
            $status = 200;
            $records['data'] = array();
            $records["draw"] = intval($request->draw);
            $webviewData = DrawerWebviewDetails::orderBy('created_at', 'desc')->pluck('id')->toArray();
            $filterFlag = true;
            if ($request->has('search_webview') && $request->search_webview != "") {
                $webviewDataId = DrawerWebview::where('name', 'ilike', '%'.$request->search_webview.'%')->first();
                $webviewData = DrawerWebviewDetails::where('drawer_web_id', $webviewDataId['id'])
                    ->pluck('id')->toArray();
                if (count($webviewData) < 0) {
                    $filterFlag = false;
                }
            }
            if($filterFlag == true && $request->has('search_city') && $request->search_city != ''){
                $webviewData = DrawerWebviewDetails::join('cities','cities.id','=','drawer_web_view_details.city_id')
                    ->where('cities.name','ilike','%'.$request->search_city.'%')
                    ->pluck('drawer_web_view_details.id')
                    ->toArray();
                if(count($webviewData) < 0){
                    $filterFlag = false;
                }
            }

            $finalWebviewData = DrawerWebviewDetails::whereIn('id', $webviewData)->orderBy('created_at', 'desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalWebviewData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalWebviewData); $iterator++, $pagination++) {
                    $srNo = $iterator + 1;
                    $id = $finalWebviewData[$pagination]->drawer_web_id;
                    $UpdateDate = $finalWebviewData[$pagination]->updated_at;
                    $city = Cities::where('id', $finalWebviewData[$pagination]->city_id)->value('name');
                    $drawerWebviewData = DrawerWebview::where('id', $id)->first();
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue">
                        <a href="/webview/edit/' . $finalWebviewData[$pagination]->id . '" style="color: white">Edit
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $drawerWebviewData['name'],
                        $city,
                        $UpdateDate->format('d M Y'),
                        $actionButton
                    ];
                }
            }
        } catch (\Exception $e) {
            $data = [
                'action' => 'Webview listing',
                'params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            $status = 500;
            $records = array();
            Log::critical(json_encode($data));
            abort(500);
        }
        return response()->json($records, $status);
    }

    public function editView(Request $request, $id){
        try{
            $webviewDetails = DrawerWebviewDetails::where('id',$id)->first();
            $webviewDetailsInGujarati = DrawerWebviewDetailsTranslations::where('drawer_webview_details_id',$id)->first();
            $webviews = DrawerWebview::get();
            $cities = Cities::get();

            return view('admin.webview.edit')->with(compact('webviews','webviewDetails','cities','webviewDetailsInGujarati'));
        }catch(\Exception $exception){
            $data = [
                'action' => 'edit webview View',
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
            $webviewData['drawer_web_id'] = $data['en']['webviewType'];
            $webviewData['description'] = $data['en']['description'];
            $webviewData['city_id'] = $data['en']['city'];
            $updateWebview = DrawerWebviewDetails::where('id',$id)->update($webviewData);

            if(array_key_exists('gj',$data)){
                if (array_key_exists('description',$data['gj'])){
                    $gujaratiWebviewData['description'] = $data['gj']['description'];
                }
                $webviewTranslationsId = DrawerWebviewDetailsTranslations::where('drawer_webview_details_id',$id)->value('id');
                if($webviewTranslationsId != null) {
                    DrawerWebviewDetailsTranslations::where('drawer_webview_details_id', $id)->update($gujaratiWebviewData);
                } else {
                    $gujaratiWebviewData['language_id'] = Languages::where('abbreviation', '=', 'gj')->pluck('id')->first();
                    $gujaratiWebviewData['drawer_webview_details_id'] = $id;
                    DrawerWebviewDetailsTranslations::create($gujaratiWebviewData);
                }
            }

            if($updateWebview){
                $request->session()->flash('success','Data Updated Successfully');
            }else{
                $request->session()->flash('error','Something went wrong');
            }
            return redirect('/webview/manage');
        }catch(\Exception $exception){
            $data = [
                'action' => 'Edit Webview',
                'params' => $request->all(),
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

}