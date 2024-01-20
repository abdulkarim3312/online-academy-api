<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicTwoContentOneResource;
use App\Http\Resources\TopicTwoContentTwoResource;
use App\Http\Resources\TopicTwoContentThreeResource;
use App\Http\Resources\TopicTwoContentFourResource;
use App\Http\Resources\TopicTwoContentFiveResource;
use App\Http\Resources\TopicTwoContentSixResource;
use App\Models\TopicTwoContentFive;
use App\Models\TopicTwoContentFour;
use App\Models\TopicTwoContentOne;
use App\Models\TopicTwoContentSix;
use App\Models\TopicTwoContentThree;
use App\Models\TopicTwoContentTwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class TopicTwoController extends Controller
{
    public function getTopicTwoContentOneData(){
        $item = TopicTwoContentOne::first();
        return new TopicTwoContentOneResource($item);
    }
    public function createOrUpdateTopicTwoContentOne(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'details_one' => 'required|string',
            'details_two' => 'required|string',
            'details_three' => 'required|string',
        ]);
        $exits_data = TopicTwoContentOne::first();
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
            TopicTwoContentOne::create($data);
        }
    }

    public function formatImageContentOne($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_two_content_one_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getTopicTwoContentTwoData(){
        $item = TopicTwoContentTwo::first();
        return new TopicTwoContentTwoResource($item);
    }
    public function createOrUpdateTopicTwoContentTwo(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'note_description' => 'required|string',
            'footer_title' => 'required|string',
        ]);
        $exits_data = TopicTwoContentTwo::first();
        if($exits_data){
            $exits_data->update($data);
        }else{
            $data['overview_content_id'] = 1;
            TopicTwoContentTwo::create($data);
        }
    }

    public function getTopicTwoContentThreeData(){
        $item = TopicTwoContentThree::first();
        return new TopicTwoContentThreeResource($item);
    }
    public function createOrUpdateTopicTwoContentThree(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        $exits_data = TopicTwoContentThree::first();
        if($exits_data){
            if ($request->hasFile('image')) {
                if ($exits_data->image != null) {
                    if (Storage::exists($exits_data->image))
                        Storage::delete($exits_data->image);
                }
                $data['image'] = $this->formatImageContentThree($request->file('image'));
            } else if ($request->image) {
                $data['image'] = $exits_data->image;
            } else {
                $data['image'] = null;
            }

            $exits_data->update($data);
        }else{
            if ($request->hasFile('image')) {
                $data['image'] = $this->formatImageContentThree($request->file('image'));
            }
            $data['overview_content_id'] = 1;
            TopicTwoContentThree::create($data);
        }
    }

    public function formatImageContentThree($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_two_content_three_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getTopicTwoContentFourData(){
        $item = TopicTwoContentFour::first();
        return new TopicTwoContentFourResource($item);
    }
    public function createOrUpdateTopicTwoContentFour(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'footer_title' => 'required|string',
            'term_one_title' => 'required|string',
            'term_one_sub_title' => 'required|string',
            'term_one_content_one' => 'required|string',
            'term_one_content_two' => 'required|string',
            'term_two_title' => 'required|string',
            'term_two_sub_title' => 'required|string',
            'term_two_content' => 'required|string',
            'term_three_title' => 'required|string',
            'term_three_sub_title' => 'required|string',
            'term_three_content' => 'required|string',
            'term_four_title' => 'required|string',
            'term_four_sub_title' => 'required|string',
            'term_four_content' => 'required|string',
        ]);
        $exits_data = TopicTwoContentFour::first();
        if($exits_data){
            $exits_data->update($data);
        }else{
            $data['overview_content_id'] = 1;
            TopicTwoContentFour::create($data);
        }
    }

    public function getTopicTwoContentFiveData(){
        $item = TopicTwoContentFive::first();
        return new TopicTwoContentFiveResource($item);
    }
    public function createOrUpdateTopicTwoContentFive(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'right_description' => 'required|string',
        ]);
        $exits_data = TopicTwoContentFive::first();
        if($exits_data){
            $exits_data->update($data);
        }else{
            $data['overview_content_id'] = 1;
            TopicTwoContentFive::create($data);
        }
    }

    public function getTopicTwoContentSixData(){
        $item = TopicTwoContentSix::first();
        return new TopicTwoContentSixResource($item);
    }
    public function createOrUpdateTopicTwoContentSix(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'footer_title' => 'required|string',
            'point_one_content' => 'required|string',
            'point_two_content' => 'required|string',
            'point_three_content' => 'required|string',
            'point_four_content' => 'required|string',
        ]);
        $exits_data = TopicTwoContentSix::first();
        if($exits_data){
            if ($request->hasFile('image')) {
                if ($exits_data->image != null) {
                    if (Storage::exists($exits_data->image))
                        Storage::delete($exits_data->image);
                }
                $data['image'] = $this->formatImageContentSix($request->file('image'));
            } else if ($request->image) {
                $data['image'] = $exits_data->image;
            } else {
                $data['image'] = null;
            }

            $exits_data->update($data);
        }else{
            if ($request->hasFile('image')) {
                $data['image'] = $this->formatImageContentSix($request->file('image'));
            }
            $data['overview_content_id'] = 1;
            TopicTwoContentSix::create($data);
        }
    }

    public function formatImageContentSix($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_two_content_six_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
}
