<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Course;

class CourseController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Course.course_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Course::query()
            ->select('Course.course_id', 'Course.course_name', 'Course.department', 'Course.credits', 'Course.program')
            ->orderBy($sort, $sortDirection);
        if (Util::IsInvalidSearch($query->getQuery()->columns, $column)) {
            abort(403);
        }
        if (request()->input('sw')) {
            $search = request()->input('sw');
            $operator = Util::getOperator(request()->input('so'));
            if ($operator == 'like') {
                $search = '%'.$search.'%';
            }
            $query->where($column, $operator, $search);
        }
        $courses = $query->paginate($size);
        return view('courses.index', ['courses' => $courses]);
    }

    public function create()
    {
        return view('courses.create', ['ref' => Util::getRef('/courses')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'course_name' => 'max:50',
            'department' => 'max:50'
        ]);
        Course::create([
            'course_name' => request()->input('course_name'),
            'department' => request()->input('department'),
            'credits' => request()->input('credits'),
            'program' => request()->input('program')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($course_id)
    {
        $course = Course::query()
            ->select('Course.course_id', 'Course.course_name', 'Course.department', 'Course.credits', 'Course.program')
            ->where('Course.course_id', $course_id)
            ->first();
        return view('courses.show', ['course' => $course, 'ref' => Util::getRef('/courses')]);
    }

    public function edit($course_id)
    {
        $course = Course::query()
            ->select('Course.course_id', 'Course.course_name', 'Course.department', 'Course.credits', 'Course.program')
            ->where('Course.course_id', $course_id)
            ->first();
        return view('courses.edit', ['course' => $course, 'ref' => Util::getRef('/courses')]);
    }

    public function update($course_id)
    {
        Util::setRef();
        $this->validate(request(), [
            'course_name' => 'max:50',
            'department' => 'max:50'
        ]);
        Course::find($course_id)->update([
            'course_name' => request()->input('course_name'),
            'department' => request()->input('department'),
            'credits' => request()->input('credits'),
            'program' => request()->input('program')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($course_id)
    {
        Course::find($course_id)->delete();
        return back();
    }
}