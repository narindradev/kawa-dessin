<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Http\Requests\StoreQuestionRequest;

class QuestionnaireController extends Controller
{
    public function list(Category $category , Questionnaire $questionnaire){
        die(json_encode(["success" => true ,"html" => view("questionnaire.category.index",["category" => $category , "question" => $questionnaire])->render() ]));
    }

    public function modal_form(Category $category , Questionnaire $questionnaire)
    {
        return view("questionnaire.category.modal-form", ["category" => $category, "question" => $questionnaire]);
    }
    public function store(StoreQuestionRequest $request, Category $category , Questionnaire $questionnaire)
    {
       
        $questionnaire->question = $request->input("question");
        // $questionnaire->offer_id = $category->offer_id;
        if ($category->questionnaires()->save( $questionnaire)) {
            die(json_encode(["success" => true, "message" => trans("lang.success_record")]));
        } else {
            die(json_encode(["success" => false, "message" => trans("lang.error_action")]));
        }
    }
    public function data_list(Category $category)
    {
        $data = [];
        $questionnairenaires = $category->questionnaires()->whereDeleted(0)->get();
        foreach ($questionnairenaires as $questionnaire) {
            $data[] = $this->_make_row($questionnaire, $category);
        }
        return (["data" => $data]);
    }

    private function _make_row($data ,Category $category)
    {

        return [
            $data->question,
            modal_anchor(url("/questionnaire/modal_form/$category->id/$data->id"), '<i class="fas fa-pen" style="font-size:15px"></i>', ["class" => "btn btn-sm btn-clean " ,'title' => trans('lang.edit')]).
            js_anchor('<i class="text-hover-primary fas fa-trash" style="font-size:15px" ></i>', ["data-id" => $data->id, "data-action-url" => url("/questionnaire/delete/$data->id"), "class" => "btn btn-sm btn-clean ", "title" => "delete", "data-action" => "delete"])
        ];
    }

    public function delete(Request $request, Questionnaire $questionnaire)
    {
        if ($request->input("cancel")) {
            $questionnaire->update(["deleted" => 0]);
            die(json_encode(["success" => true, "message" => trans("lang.success_canceled"), "data" => $this->_make_row($questionnaire ,$questionnaire->category )]));
        } else {
            $questionnaire->update(["deleted" => 1]);
            die(json_encode(["success" => true, "message" => trans("lang.success_deleted")]));
        }
    }

    
    /** offer questions */
    public function storeOffer(StoreQuestionRequest $request, Offer $offer, Questionnaire $questionnaire)
    {
        $questionnaire->question = $request->input("question");
        $questionnaire->offer_id = $offer->offer_id;
        if ($offer->questionnaires()->save( $questionnaire)) {
            die(json_encode(["success" => true, "message" => trans("lang.success_record")]));
        } else {
            die(json_encode(["success" => false, "message" => trans("lang.error_action")]));
        }
    }

    public function modal_form_offer(Offer $offer , Questionnaire $questionnaire)
    {
        return view("questionnaire.offer.modal-form", ["offer" => $offer, "question" => $questionnaire]);
    }
    public function data_list_offer(Offer $offer)
    {
        $data = [];
        $questionnaires = $offer->questionnaires()->whereDeleted(0)->get();
        foreach ($questionnaires as $questionnaire) {
            $data[] = $this->_make_row_offer($questionnaire, $offer);
        }
        return (["data" => $data]);
    }
    private function _make_row_offer($data ,Offer $offer)
    {
        return [
            $data->question,
            js_anchor('<i class="text-hover-primary fas fa-trash" style="font-size:15px" ></i>', ["data-id" => $data->id, "data-action-url" => url("/questionnaireOffer/deleteOffer/$data->id"), "class" => "btn btn-sm btn-clean ", "title" => "delete", "data-action" => "delete"])
        ];
    }

   
    public function deleteOffer(Request $request, Questionnaire $questionnaire)
    {
        if ($request->input("cancel")) {
            $questionnaire->update(["deleted" => 0]);
            die(json_encode(["success" => true, "message" => trans("lang.success_canceled"), "data" => $this->_make_row_offer($questionnaire ,$questionnaire->offer )]));
        } else {
            $questionnaire->update(["deleted" => 1]);
            die(json_encode(["success" => true, "message" => trans("lang.success_deleted")]));
        }
    }

    /** Info preliminary information questionnaire */
    
    public function preliminary_info(){
        return view("questionnaire.preliminary_info.index");
    }

    public function preliminary_info_data_list()
    {
        $data = [];
        $questions = Questionnaire::wherePreliminary(1)->whereDeleted(0)->get();
        foreach ($questions as $question) {
            $data[] = $this->_make_row_pre_info($question);
        }
        return (["data" => $data]);
    }

    private function _make_row_pre_info($data){
        return [
            $data->question,
            js_anchor('<i class="text-hover-primary fas fa-trash" style="font-size:15px" ></i>', ["data-id" => $data->id, "data-action-url" => url("/questionnaire/deletePreliminary/$data->id"), "class" => "btn btn-sm btn-clean ", "title" => "delete", "data-action" => "delete"])
        ];
    }
    public function storePreliminary(Request $request)
    {
        $questionnaire = new Questionnaire;
        $questionnaire->question = $request->input("question");
        $questionnaire->preliminary = 1;
        if ($questionnaire->save()) {
            die(json_encode(["success" => true, "message" => trans("lang.success_record") ,"data" => $this->_make_row_pre_info($questionnaire)]));
        } else {
            die(json_encode(["success" => false, "message" => trans("lang.error_action")]));
        }
    }
    public function preliminary_modal()
    {
       return view("questionnaire.preliminary_info.modal-form");
    }
    public function deletePreliminary(Request $request, Questionnaire $questionnaire)
    {
        if ($request->input("cancel")) {
            $questionnaire->update(["deleted" => 0]);
            die(json_encode(["success" => true, "message" => trans("lang.success_canceled"), "data" => $this->_make_row_offer($questionnaire ,$questionnaire->offer )]));
        } else {
            $questionnaire->update(["deleted" => 1]);
            die(json_encode(["success" => true, "message" => trans("lang.success_deleted")]));
        }
    }
}