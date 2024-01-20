<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\ParentResource;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();

        if (isset($request->situation) && $request->situation !== '')
            $query->where('situation', $request->situation);

        return ParentResource::collection(executeQuery($query->whereNotNull('registered_at')));
    }


    public function formatImage($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'agent_image/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            // 'parent_id' => 'required|string|min:4|unique:parents,parent_id,NULL,id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
            // 'email' => 'required|max:255|unique:parents,email,NULL,id,deleted_at,NULL',
            'address' => 'nullable',
            'detailed_address' => 'nullable',
            'postal_code' => 'nullable|string',
            'situation' => 'required|string|in:approval,stop,dormancy,secession',
            'memo' => 'nullable',
        ]);

        $parent_count = User::withTrashed()->count();
        $parent_id = str_pad($parent_count + 1, 6, '0', STR_PAD_LEFT);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->formatImage($request->file('photo'));
        }
        $data['parent_id'] = $parent_id;
        $data['password'] = bcrypt($data['password']);
        $data['registered_at'] = Carbon::now();
        $data['register_by'] = 'admin';

        return new ParentResource(User::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $parent)
    {
        return new ParentResource($parent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $parent)
    {
        $data = $request->validate([
            // 'parent_id' => 'required|string|min:4|unique:parents,parent_id,' . $parent->id . ',id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'password' => 'nullable|min:6|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|max:255',
            // 'email' => 'required|max:255|unique:parents,email,' . $parent->id . ',id,deleted_at,NULL',
            'address' => 'nullable',
            'detailed_address' => 'nullable',
            'postal_code' => 'nullable|string',
            'situation' => 'required|string|in:approval,stop,dormancy,secession',
            'memo' => 'nullable',
        ]);

        if ($request->hasFile('photo')) {
            if ($parent->photo != null) {
                if (Storage::exists($parent->photo))
                    Storage::delete($parent->photo);
            }
            $data['photo'] = $this->formatImage($request->file('photo'));
        }

        if (isset($data['password']) && $data['password'] != "")
            $data['password'] = bcrypt($data['password']);

        return $parent->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $parent)
    {
        return $parent->delete();
    }
}
