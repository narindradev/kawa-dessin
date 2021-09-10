<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCatRequest;


class CategoryController extends Controller
{
    public function index()
    {
        abort(404);
    }
    public function modal_form(Offer $offer, Category $category)
    {
        return view("category.modal-form", ["offer" => $offer, "category" => $category]);
    }
    public function store(StoreCatRequest $request, Offer $offer, Category $category)
    {
        $category->name = $request->input("name");
        $category->description = $request->input("description");
        
        if ($offer->categories()->save($category)) {
            die(json_encode(["success" => true, "message" => trans("lang.success_record")]));
        } else {
            die(json_encode(["success" => false, "message" => trans("lang.error_action")]));
        }
    }
    public function data_list(Offer $offer)
    {
        $data = [];
        $categories = $offer->categories;
        foreach ($categories as $category) {
            $data[] = $this->_make_row($category,$offer);
        }
        return (["data" => $data]);
    }

    private function _make_row($data , Offer $offer)
    {

        return [
            "#" . $data->id,
            $data->name,
            Str::limit($data->description, 50) ?? '-',
            js_anchor('<i class="fas fa-question-circle" style="font-size:15px" ></i>', ["data-id" => $data->id, "data-action-url" => url("/questionnaire/list/$data->id"), "class" => "btn btn-sm btn-clean ", "title" => trans("lang.list_question"), "data-action" => "load-question"]).
            modal_anchor(url("/category/modal_form/$offer->id/$data->id"), '<i class="fas fa-pen" style="font-size:15px"></i>', ["class" => "btn btn-sm btn-clean " ,'title' => trans('lang.edit')]) .
            js_anchor('<i class="fas fa-trash" style="font-size:15px" ></i>', ["data-id" => $data->id, "data-action-url" => url("/category/delete/$data->id"), "class" => "btn btn-sm btn-clean ", "title" => "delete", "data-action" => "delete"])
        ];
    }

    public function delete(Request $request, Category $category)
    {
        if ($request->input("cancel")) {
            $category->update(["deleted" => 0]);
            die(json_encode(["success" => true, "message" => trans("lang.success_canceled"), "data" => $this->_make_row($category , $category->offer)]));
        } else {
            $category->update(["deleted" => 1]);
            die(json_encode(["success" => true, "message" => trans("lang.success_deleted")]));
        }
    }

    
}
