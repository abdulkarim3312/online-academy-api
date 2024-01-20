<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutUsResource;
use App\Http\Resources\CourseDetailsResource;
use App\Http\Resources\HomeBannerResource;
use App\Http\Resources\LogoResource;
use App\Models\AboutUs;
use App\Models\CourseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\HomeBanner;
use App\Models\Logo;
use Illuminate\Support\Str;


class SettingsController extends Controller
{
    public function getHomeBanner(){
        return new HomeBannerResource(HomeBanner::first());
    }
    public function createOrUpdateHomeBanner(Request $request){
        $data = $request->validate([
            'background_color' => 'required',
            'top_title' => 'required|string',
            'sub_title' => 'required|string',
        ]);

        $home_banner = HomeBanner::first();
        if($home_banner){
            if ($request->hasFile('banner_image')) {
                if ($home_banner->banner_image != null) {
                    if (Storage::exists($home_banner->banner_image))
                        Storage::delete($home_banner->banner_image);
                }
                $data['banner_image'] = $this->formatImage($request->file('banner_image'));
            } else if ($request->banner_image) {
                $data['banner_image'] = $home_banner->banner_image;
            } else {
                $data['banner_image'] = null;
            }

            $home_banner->update($data);
        }else{
            if ($request->hasFile('banner_image')) {
                $data['banner_image'] = $this->formatImage($request->file('banner_image'));
            }
            HomeBanner::create($data);
        }
    }

    public function formatImage($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'home_banner/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }


    public function getCourseDetails(){
        return new CourseDetailsResource(CourseDetail::first());
    }

    public function createOrUpdateCourseDetails(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'short_description' => 'required',
            'long_description' => 'required',
        ]);

        $course_detail = CourseDetail::first();
        if($course_detail){
            if ($request->hasFile('image')) {
                if ($course_detail->image != null) {
                    if (Storage::exists($course_detail->image))
                        Storage::delete($course_detail->image);
                }
                $data['image'] = $this->formatDetailImage($request->file('image'));
            } else if ($request->image) {
                $data['image'] = $course_detail->image;
            } else {
                $data['image'] = null;
            }

            $course_detail->update($data);
        }else{
            if ($request->hasFile('image')) {
                $data['image'] = $this->formatDetailImage($request->file('image'));
            }
            CourseDetail::create($data);
        }
    }

    public function formatDetailImage($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'course_detail/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getAboutUsData(){
        return new AboutUsResource(AboutUs::first());
    }
    public function createOrUpdateAboutUs(Request $request){
        $data = $request->validate([
            'title' => 'required',
            'sub_title' => 'required|string',
            'description' => 'required|string',
        ]);

        $about_us = AboutUs::first();
        if($about_us){
            if ($request->hasFile('image')) {
                if ($about_us->image != null) {
                    if (Storage::exists($about_us->image))
                        Storage::delete($about_us->image);
                }
                $data['image'] = $this->formatAboutUsImage($request->file('image'));
            } else if ($request->image) {
                $data['image'] = $about_us->image;
            } else {
                $data['image'] = null;
            }

            $about_us->update($data);
        }else{
            if ($request->hasFile('image')) {
                $data['image'] = $this->formatAboutUsImage($request->file('image'));
            }
            AboutUs::create($data);
        }
    }

    public function formatAboutUsImage($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'about_us/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function getLogoData(){
        return new LogoResource(Logo::first());
    }

    public function createOrUpdateLogo(Request $request){
        $data = $request->validate([
            'admin_logo' => 'nullable',
            'site_logo' => 'nullable',
        ]);
        $logo = Logo::first();
        if($logo){
            if ($request->hasFile('admin_logo')) {
                if ($logo->admin_logo != null) {
                    if (Storage::exists($logo->admin_logo))
                        Storage::delete($logo->admin_logo);
                }
                $data['admin_logo'] = $this->formatAdminLogo($request->file('admin_logo'));
            } else if ($request->admin_logo) {
                $data['admin_logo'] = $logo->admin_logo;
            } else {
                $data['admin_logo'] = null;
            }

            if ($request->hasFile('site_logo')) {
                if ($logo->site_logo != null) {
                    if (Storage::exists($logo->site_logo))
                        Storage::delete($logo->site_logo);
                }
                $data['site_logo'] = $this->formatSiteLogo($request->file('site_logo'));
            } else if ($request->site_logo) {
                $data['site_logo'] = $logo->site_logo;
            } else {
                $data['site_logo'] = null;
            }

            $logo->update($data);
        }else{
            if ($request->hasFile('admin_logo')) {
                $data['admin_logo'] = $this->formatAdminLogo($request->file('admin_logo'));
            }

            if ($request->hasFile('site_logo')) {
                $data['site_logo'] = $this->formatSiteLogo($request->file('site_logo'));
            }
            Logo::create($data);
        }
    }

    public function formatAdminLogo($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'site_logo/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function formatSiteLogo($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'site_logo/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
}
