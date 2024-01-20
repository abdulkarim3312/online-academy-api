<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopicOneContentOne;
use Illuminate\Http\Request;
use App\Http\Resources\TopicOneContentOneResource;
use App\Http\Resources\TopicOneContentTwoResource;
use App\Http\Resources\TopicOneContentThreeResource;
use App\Http\Resources\TopicOneContentFourResource;
use App\Http\Resources\TopicOneContentFiveResource;
use App\Models\TopicOneContentFive;
use App\Models\TopicOneContentFour;
use App\Models\TopicOneContentThree;
use App\Models\TopicOneContentTwo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class TopicOneController extends Controller
{

    public function getTopicOneContentOneData(){
        $item = TopicOneContentOne::first();
        return new TopicOneContentOneResource($item);
    }
    public function createOrUpdateTopicOneContentOne(Request $request){
        $data = $request->validate([
            'short_description' => 'required|string',
        ]);
        $exits_data = TopicOneContentOne::first();
        if($exits_data){
            if ($request->hasFile('image')) {
                if ($exits_data->image != null) {
                    if (Storage::exists($exits_data->image))
                        Storage::delete($exits_data->image);
                }
                $data['image'] = $this->formatImageTopicOneContentOne($request->file('image'));
            } else if ($request->image) {
                $data['image'] = $exits_data->image;
            } else {
                $data['image'] = null;
            }

            if($request->hasFile('video')){
                if ($exits_data->video != null) {
                    if (Storage::exists('topic_one_content_one_image/'.$exits_data->video))
                        Storage::delete('topic_one_content_one_image/'.$exits_data->video);
                }
                $file = $request->file('video');
                $fileName = Str::uuid().'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('topic_one_content_one_image',$fileName);
                $data['video'] = $fileName;
            }

            $exits_data->update($data);

        }else{
            if ($request->hasFile('image')) {
                $data['image'] = $this->formatImageTopicOneContentOne($request->file('image'));
            }
            if($request->hasFile('video')){
                $data['video'] = '';
                $file = $request->file('video');
                $fileName = Str::uuid().'.'.$file->getClientOriginalExtension();
                $path = $file->storeAs('topic_one_content_one_image',$fileName);
                $data['video'] = $fileName;
            }
            $data['overview_content_id'] = 1;
            TopicOneContentOne::create($data);
        }
    }

    public function formatImageTopicOneContentOne($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_one_content_one_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getTopicOneContentTwoData(){
        $item = TopicOneContentTwo::first();
        return new TopicOneContentTwoResource($item);
    }
    public function createOrUpdateTopicOneContentTwo(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'footer_title' => 'required|string',
        ]);
        $exits_data = TopicOneContentTwo::first();
        if($exits_data){
            $exits_data->update($data);
        }else{
            $data['overview_content_id'] = 1;
            TopicOneContentTwo::create($data);
        }
    }

    public function getTopicOneContentThreeData(){
        $item = TopicOneContentThree::first();
        return new TopicOneContentThreeResource($item);
    }
    public function createOrUpdateTopicOneContentThree(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'footer_title' => 'required|string',
            'term_one_title' => 'required|string',
            'term_one_content' => 'required|string',
            'term_two_title' => 'required|string',
            'term_two_content' => 'required|string',
            'term_three_title' => 'required|string',
            'term_three_content' => 'required|string',
            'term_four_title' => 'required|string',
            'term_four_content' => 'required|string',
        ]);
        $exits_data = TopicOneContentThree::first();
        if($exits_data){
            $exits_data->update($data);
        }else{
            $data['overview_content_id'] = 1;
            TopicOneContentThree::create($data);
        }
    }
    public function getTopicOneContentFourData(){
        $item = TopicOneContentFour::first();
        return new TopicOneContentFourResource($item);
    }
    public function createOrUpdateTopicOneContentFour(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'footer_title' => 'required|string',
            'term_one_title' => 'required|string',
            'term_one_content' => 'required|string',
            'term_two_title' => 'required|string',
            'term_two_content' => 'required|string',
            'term_three_title' => 'required|string',
            'term_three_content' => 'required|string',
            'term_four_title' => 'required|string',
            'term_four_content' => 'required|string',
            'term_five_title' => 'required|string',
            'term_five_content' => 'required|string',
        ]);
        $exits_data = TopicOneContentFour::first();
        if($exits_data){
            $exits_data->update($data);
        }else{
            $data['overview_content_id'] = 1;
            TopicOneContentFour::create($data);
        }
    }
    public function getTopicOneContentFiveData(){
        $item = TopicOneContentFive::first();
        return new TopicOneContentFiveResource($item);
    }
    public function createOrUpdateTopicOneContentFive(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'footer_title' => 'required|string',
            'point_one_content' => 'required|string',
            'point_two_content' => 'required|string',
            'point_three_content' => 'required|string',
            'point_four_content' => 'required|string',
            'point_five_content' => 'required|string',
            'point_six_content' => 'required|string',
            'point_seven_content' => 'required|string',
            'point_eight_content' => 'required|string',
            'point_nine_content' => 'required|string',
        ]);
        $exits_data = TopicOneContentFive::first();
        if($exits_data){
            if ($request->hasFile('image')) {
                if ($exits_data->image != null) {
                    if (Storage::exists($exits_data->image))
                        Storage::delete($exits_data->image);
                }
                $data['image'] = $this->formatImage($request->file('image'));
            } else if ($request->image) {
                $data['image'] = $exits_data->image;
            } else {
                $data['image'] = null;
            }

            $exits_data->update($data);
        }else{
            if ($request->hasFile('image')) {
                $data['image'] = $this->formatImage($request->file('image'));
            }
            $data['overview_content_id'] = 1;
            TopicOneContentFive::create($data);
        }
    }

    public function formatImage($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_one_content_five_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
}
