<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 5/12/18
 * Time: 12:48 PM
 */
namespace App\Http\Controllers\Suggestion;
use App\Http\Controllers\Controller;
use App\Suggestion;
use App\Cities;
use App\SuggestionCategory;
use App\SuggestionType;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function manage(Request $request){
        try{
            $suggestionTypes = SuggestionType::get();
            $suggestionCategories = SuggestionCategory::get();
            return view('admin.suggestions.manage')->with(compact('suggestionTypes','suggestionCategories'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Suggestion View page',
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
            $suggestionData = Suggestion::orderBy('created_at','desc')->pluck('id')->toArray();
            $filterFlag = true;
            if($request->has('search_city') /*&& $request->search_name != ''*/){
                $suggestionData = Suggestion::join('cities','cities.id','=','suggestions.city_id')
                    ->where('cities.name','ilike','%'.$request->search_city.'%')
                    ->pluck('suggestions.id')
                    ->toArray();
                if(count($suggestionData) < 0){
                    $filterFlag = false;
                }
            }
            if($request->has('sugg_type') && $filterFlag==true){
                if($request->sugg_type == 'all'){
                    $suggestionData = Suggestion::whereIn('id',$suggestionData)
                        ->pluck('id')
                        ->toArray();
                } else {
                    $suggestionData = Suggestion::whereIn('id', $suggestionData)
                        ->where('suggestion_type_id', $request->sugg_type)
                        ->pluck('id')
                        ->toArray();
                }
                if(count($suggestionData) < 0){
                    $filterFlag = false;
                }
            }
            if($request->has('sugg_cat') && $filterFlag == true){
                if($request->sugg_cat == 'all'){
                    $suggestionData = Suggestion::whereIn('id',$suggestionData)
                        ->pluck('id')
                        ->toArray();
                } else {
                    $suggestionData = Suggestion::whereIn('id', $suggestionData)
                        ->where('suggestion_category_id', $request->sugg_cat)
                        ->pluck('id')
                        ->toArray();
                }
                if(count($suggestionData) < 0){
                    $filterFlag = false;
                }
            }

            $finalSuggestionData = Suggestion::whereIn('id', $suggestionData)->orderBy('created_at','desc')->get();
            {
                $records["recordsFiltered"] = $records["recordsTotal"] = count($finalSuggestionData);
                if ($request->length == -1) {
                    $length = $records["recordsTotal"];
                } else {
                    $length = $request->length;
                }
                for ($iterator = 0, $pagination = $request->start; $iterator < $length && $pagination < count($finalSuggestionData); $iterator++, $pagination++) {
                    $srNo = $iterator+1;
                    $description = str_limit($finalSuggestionData[$pagination]->description,20);
                    $city = Cities::where('id',$finalSuggestionData[$pagination]->city_id)->pluck('name')->first();
                    $suggestionType = SuggestionType::where('id',$finalSuggestionData[$pagination]->suggestion_type_id)->pluck('name')->first();
                    $suggestionCategory = SuggestionCategory::where('id',$finalSuggestionData[$pagination]->suggestion_category_id)->pluck('name')->first();
                    $date = strtotime($finalSuggestionData[$pagination]->created_at);
                    $actionButton = '<div id="sample_editable_1_new" class="btn btn-small blue" >
                        <a href="/suggestion/view/' . $finalSuggestionData[$pagination]['id'] . '" style="color: white"> View
                    </div>';
                    $records['data'][$iterator] = [
                        $srNo,
                        $city,
                        $suggestionType,
                        $suggestionCategory,
                        $description,
                        date('d M Y', $date ),
                        $actionButton
                    ];
                }
            }
        }catch(\Exception $e){
            $data = [
                'action' => 'Suggestion listing',
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
    public function view(Request $request, $id){
        try{
            $suggestionData = Suggestion::where('id',$id)->first();
            $city = Cities::where('id',$suggestionData['city_id'])->value('name');
            $suggestionType = SuggestionType::where('id',$suggestionData['suggestion_type_id'])->value('name');
            $suggestionCategory = SuggestionCategory::where('id',$suggestionData['suggestion_category_id'])->value('name');
            return view('admin.suggestions.view')->with(compact('city','suggestionType','suggestionCategory','suggestionData'));
        }catch(\Exception $exception){
            $data = [
                'params' => $request->all(),
                'action' => 'Suggestion View page',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
}