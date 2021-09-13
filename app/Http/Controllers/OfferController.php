<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class OfferController extends Controller
{

    /** load view */
    public function index()
    {
        return view("offer.index");
    }
    public function form_modal(Request $request, Offer $offer)
    {
        return view("offer.modal-form", ["offer" => $offer]);
    }
    public function store(StoreOfferRequest $request, Offer $offer)
    {
        // sleep(2);
        Cache::forget('offer_data');
        $offer->name = $request->input("title");
        $offer->description = $request->input("description");
      
        
        if($request->hasFile("image")){
            ini_set("memory_limit" ,"128M");
            ini_set("post_max_size" ,"120M");
            ini_set("upload_max_filesize" ,"120M");
            upload($request->file("image"));
        }
        if ($offer->save()) {
            die(json_encode(["success" => true, "message" => trans("lang.success_record") , "data" =>$this->_make_row($offer) ]));
        }
    }
    public function data_list()
    {
        $data = [];
        $offers =  Offer::whereDeleted(0)->get();
        foreach ($offers as $offer) {
            $data[] = $this->_make_row($offer);
        }
        return (["data" => $data]);
    }
    private function _make_row($data )
    {

        return [
            "#" . $data->id,
            $data->name,
            Str::limit($data->description, 50) ?? '-',
            anchor(url("/offer/detail/$data->id"), '<i class="fas fa-eye" style="font-size:15px"></i>', ["class" => "btn btn-sm btn-clean "]) .
            modal_anchor(url("/offer/form_modal/$data->id"), '<i class="fas fa-pen" style="font-size:15px"></i>', ["class" => "btn btn-sm btn-clean " ,'title' => trans('lang.edit')]) .
            js_anchor('<i class="fas fa-trash" style="font-size:15px" ></i>', ["data-id" => $data->id, "data-action-url" => url("/offer/delete/$data->id"), "class" => "btn btn-sm btn-clean ", "title" => "delete", "data-action" => "delete"])
        ];
    }

    public function detail(Offer $offer){
        return view("category.category-list" ,["offer" => $offer]);
    }

    public function delete(Request $request, Offer $offer)
    {
        if ($request->input("cancel")) {
            $offer->update(["deleted" => 0]);
            die(json_encode(["success" => true, "message" => trans("lang.success_canceled"), "data" => $this->_make_row($offer)]));
        } else {
            $offer->update(["deleted" => 1]);
            die(json_encode(["success" => true, "message" => trans("lang.success_deleted")]));
        }
    }
}
