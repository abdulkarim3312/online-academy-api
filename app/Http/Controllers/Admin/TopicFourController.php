<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TopicFourContentOneResource;
use App\Http\Resources\TopicFourContentTwoResource;
use App\Models\TopicFourContentOne;
use App\Models\TopicFourContentTwo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class TopicFourController extends Controller
{
    public function getTopicFourContentOneData(){
        $item = TopicFourContentOne::first();
        return new TopicFourContentOneResource($item);
    }
    public function createOrUpdateTopicFourContentOne(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'summary_one' => 'required|string',
            'summary_two' => 'required|string',
            'summary_three' => 'required|string',
        ]);
        $exits_data = TopicFourContentOne::first();
        if($exits_data){
            if ($request->hasFile('image')) {
                if ($exits_data->image != null) {
                    if (Storage::exists($exits_data->image))
                        Storage::delete($exits_data->image);
                }
                $data['image'] = $this->formatImageContentOne($request->file('image'));
            } else if ($request->image) {
                $data['image'] = $exits_data->image;
            } else {
                $data['image'] = null;
            }

            $exits_data->update($data);
        }else{
            if ($request->hasFile('image')) {
                $data['image'] = $this->formatImageContentOne($request->file('image'));
            }
            $data['overview_content_id'] = 1;
            TopicFourContentOne::create($data);
        }
    }

    public function formatImageContentOne($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_four_content_one_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getTopicFourContentTwoData(){
        $item = TopicFourContentTwo::first();
        return new TopicFourContentTwoResource($item);
    }
    public function createOrUpdateTopicFourContentTwo(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        $exits_data = TopicFourContentTwo::first();
        if($exits_data){
            if ($request->hasFile('image')) {
                if ($exits_data->image != null) {
                    if (Storage::exists($exits_data->image))
                        Storage::delete($exits_data->image);
                }
                $data['image'] = $this->formatImageContentTwo($request->file('image'));
            } else if ($request->image) {
                $data['image'] = $exits_data->image;
            } else {
                $data['image'] = null;
            }

            $exits_data->update($data);
        }else{
            if ($request->hasFile('image')) {
                $data['image'] = $this->formatImageContentTwo($request->file('image'));
            }
            $data['overview_content_id'] = 1;
            TopicFourContentTwo::create($data);
        }
    }

    public function formatImageContentTwo($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_four_content_two_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
}
