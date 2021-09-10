<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Http\Requests\StoreQuestionRequest;

class QuestionnaireController extends Controller
{
    public function list(Category $category , Questionnaire $questionnaire){
        die(json_encode(["success" => true ,"html" => view("questionnaire.index",["category" => $category , "question" => $questionnaire])->render() ]));
    }

    public function modal_form(Category $category , Questionnaire $questionnaire)
    {
        return view("questionnaire.modal-form", ["category" => $category, "question" => $questionnaire]);
    }
    public function store(StoreQuestionRequest $request, Category $category , Questionnaire $questionnaire)
    {
       
        $questionnaire->question = $request->input("question");
        $questionnaire->offer_id = $category->offer_id;
        if ($category->questionnaires()->save( $questionnaire)) {
            die(json_encode(["success" => true, "message" => trans("lang.success_record")]));
        } else {
            die(json_encode(["success" => false, "message" => trans("lang.error_action")]));
        }
    }

    public function data_list(Category $category)
    {
        $data = [];
        $questionnairenaires = $category->questionnaires;
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
            js_anchor('<i class="fas fa-trash" style="font-size:15px" ></i>', ["data-id" => $data->id, "data-action-url" => url("/questionnaire/delete/$data->id"), "class" => "btn btn-sm btn-clean ", "title" => "delete", "data-action" => "delete"])
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
}
