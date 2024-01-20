<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExtendLearningResource;
use App\Models\ExtendLearning;
use Illuminate\Http\Request;

class ExtendLearningController extends Controller
{
    public function getExtendLearningData(){
        $item = ExtendLearning::first();
        return new ExtendLearningResource($item);
    }
    public function createOrUpdateExtendLearning(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'sub_title' => 'required|string',
            'sub_sub_title' => 'required|string',
            'footer' => 'required|string',
            'do_more_title' => 'required|string',
            'do_more_description' => 'required|string',
            'learn_more_title' => 'required|string',
            'learn_more_description' => 'required|string',
        ]);
        $exits_data = ExtendLearning::first();
        if($exits_data){
            $exits_data->update($data);
        }else{
            $data['product_id'] = 1;
            ExtendLearning::create($data);
        }
    }
}
