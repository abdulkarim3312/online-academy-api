<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicThreeContentOneResource;
use App\Http\Resources\TopicThreeContentTwoResource;
use App\Models\TopicThreeContentOne;
use App\Models\TopicThreeContentTwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;


class TopicThreeController extends Controller
{
    public function getTopicThreeContentOneData(){
        $item = TopicThreeContentOne::first();
        return new TopicThreeContentOneResource($item);
    }
    public function createOrUpdateTopicThreeContentOne(Request $request){
        // return $request->all();
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        $exits_data = TopicThreeContentOne::first();
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
            TopicThreeContentOne::create($data);
        }
    }

    public function formatImageContentOne($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_three_content_one_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getTopicThreeContentTwoData(){
        $item = TopicThreeContentTwo::first();
        return new TopicThreeContentTwoResource($item);
    }
    public function createOrUpdateTopicThreeContentTwo(Request $request){
        // return $request->all();
        $data = $request->validate([
            'term_one_title' => 'required|string',
            'term_one_content' => 'required|string',
            'term_one_topic' => 'required|string',
            'term_one_topic_desc' => 'required|string',
            'term_two_title' => 'required|string',
            'term_two_content' => 'required|string',
            'term_two_topic' => 'required|string',
            'term_two_topic_desc' => 'required|string',
            'term_three_title' => 'required|string',
            'term_three_content' => 'required|string',
            'term_three_topic' => 'required|string',
            'term_three_topic_desc' => 'required|string',
            'term_four_title' => 'required|string',
            'term_four_content' => 'required|string',
            'term_four_topic' => 'required|string',
            'term_four_topic_desc' => 'required|string',
        ]);
        $exits_data = TopicThreeContentTwo::first();
        if($exits_data){
            if ($request->hasFile('term_one_image')) {
                if ($exits_data->term_one_image != null) {
                    if (Storage::exists($exits_data->term_one_image))
                        Storage::delete($exits_data->term_one_image);
                }
                $data['term_one_image'] = $this->formatImageContentTwoImageOne($request->file('term_one_image'));
            } else if ($request->term_one_image) {
                $data['term_one_image'] = $exits_data->term_one_image;
            } else {
                $data['term_one_image'] = null;
            }
            if ($request->hasFile('term_two_image')) {
                if ($exits_data->term_two_image != null) {
                    if (Storage::exists($exits_data->term_two_image))
                        Storage::delete($exits_data->term_two_image);
                }
                $data['term_two_image'] = $this->formatImageContentTwoImageOne($request->file('term_two_image'));
            } else if ($request->term_two_image) {
                $data['term_two_image'] = $exits_data->term_two_image;
            } else {
                $data['term_two_image'] = null;
            }
            if ($request->hasFile('term_three_image')) {
                if ($exits_data->term_three_image != null) {
                    if (Storage::exists($exits_data->term_three_image))
                        Storage::delete($exits_data->term_three_image);
                }
                $data['term_three_image'] = $this->formatImageContentTwoImageOne($request->file('term_three_image'));
            } else if ($request->term_three_image) {
                $data['term_three_image'] = $exits_data->term_three_image;
            } else {
                $data['term_three_image'] = null;
            }
            if ($request->hasFile('term_four_image')) {
                if ($exits_data->term_four_image != null) {
                    if (Storage::exists($exits_data->term_four_image))
                        Storage::delete($exits_data->term_four_image);
                }
                $data['term_four_image'] = $this->formatImageContentTwoImageOne($request->file('term_four_image'));
            } else if ($request->term_four_image) {
                $data['term_four_image'] = $exits_data->term_four_image;
            } else {
                $data['term_four_image'] = null;
            }

            $exits_data->update($data);
        }else{
            if ($request->hasFile('term_one_image')) {
                $data['term_one_image'] = $this->formatImageContentTwoImageOne($request->file('term_one_image'));
            }
            if ($request->hasFile('term_two_image')) {
                $data['term_two_image'] = $this->formatImageContentTwoImageTwo($request->file('term_two_image'));
            }
            if ($request->hasFile('term_three_image')) {
                $data['term_three_image'] = $this->formatImageContentTwoImageThree($request->file('term_three_image'));
            }
            if ($request->hasFile('term_four_image')) {
                $data['term_four_image'] = $this->formatImageContentTwoImageFour($request->file('term_four_image'));
            }
            $data['overview_content_id'] = 1;
            TopicThreeContentTwo::create($data);
        }
    }

    public function formatImageContentTwoImageOne($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_three_content_two_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
    public function formatImageContentTwoImageTwo($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_three_content_two_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
    public function formatImageContentTwoImageThree($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_three_content_two_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
    public function formatImageContentTwoImageFour($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'topic_three_content_two_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
}
