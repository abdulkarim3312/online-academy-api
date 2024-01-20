<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Student::query();

        if (isset($request->situation) && $request->situation !== '')
            $query->where('situation', $request->situation);

        return StudentResource::collection(executeQuery($query->with('parents')));
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
            // 'student_id' => 'required|numeric|min:4|unique:students,student_id,NULL,id,deleted_at,NULL',
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'nullable|email',
            'situation' => 'required|string|in:approval,stop,dormancy,secession',
            'memo' => 'nullable',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->formatImage($request->file('photo'));
        }

        $student_count = Student::withTrashed()->count();
        $student_id = str_pad($student_count + 1, 6, '0', STR_PAD_LEFT);

        $data['student_id'] = $student_id;
        $data['password'] = bcrypt($data['password']);
        $data['registered_at'] = Carbon::now();

        $student = Student::create($data);
        return new StudentResource($student);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            // 'student_id' => 'required|numeric|min:4|unique:students,student_id,' . $student->id . ',id,deleted_at,NULL',
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|max:255',
            'email' => 'nullable|email',
            'situation' => 'required|string|in:approval,stop,dormancy,secession',
            'memo' => 'nullable',
            'password' => 'nullable|min:6|max:255',
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo != null) {
                if (Storage::exists($student->photo))
                    Storage::delete($student->photo);
            }
            $data['photo'] = $this->formatImage($request->file('photo'));
        } else if ($request->photo) {
            $data['photo'] = $student->photo;
        } else {
            $data['photo'] = null;
        }

        if (isset($data['password']) && $data['password'] != "") {
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = $student->password;
        }

        return $student->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if ($student->photo != null) {
            if (Storage::exists($student->photo))
                Storage::delete($student->photo);
        }
        return $student->delete();
    }

    public function formatImage($file)
    {
        $images = Image::make($file)->encode('jpg');
        $imageName = 'student/' . Str::uuid() . '.jpg';
        Storage::put($imageName, $images);
        return $imageName;
    }

    public function updateStudentIdRecord()
    {
        $students = Student::whereDate('registered_at', '2023-08-07')->get();
        foreach ($students as $student) {
            $student->student_id = $student->name;
            $student->save();
        }
        return 'updated';
    }
}
