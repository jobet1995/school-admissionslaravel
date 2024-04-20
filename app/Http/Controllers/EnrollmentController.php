<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Enrollment;

class EnrollmentController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Enrollment.enrollment_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Enrollment::query()
            ->select('Enrollment.enrollment_id', 'Enrollment.student', 'Enrollment.course', 'Enrollment.enrollment_date', 'Enrollment.grade')
            ->orderBy($sort, $sortDirection);
        if (Util::IsInvalidSearch($query->getQuery()->columns, $column)) {
            abort(403);
        }
        if (request()->input('sw')) {
            $search = request()->input('sw');
            $operator = Util::getOperator(request()->input('so'));
            if ($column == 'Enrollment.enrollment_date') {
                $search = Util::formatDateStr($search, 'date');
            }
            if ($operator == 'like') {
                $search = '%'.$search.'%';
            }
            $query->where($column, $operator, $search);
        }
        $enrollments = $query->paginate($size);
        return view('enrollments.index', ['enrollments' => $enrollments]);
    }

    public function create()
    {
        return view('enrollments.create', ['ref' => Util::getRef('/enrollments')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'grade' => 'max:50'
        ]);
        Enrollment::create([
            'student' => request()->input('student'),
            'course' => request()->input('course'),
            'enrollment_date' => Util::getDate(request()->input('enrollment_date')),
            'grade' => request()->input('grade')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($enrollment_id)
    {
        $enrollment = Enrollment::query()
            ->select('Enrollment.enrollment_id', 'Enrollment.student', 'Enrollment.course', 'Enrollment.enrollment_date', 'Enrollment.grade')
            ->where('Enrollment.enrollment_id', $enrollment_id)
            ->first();
        return view('enrollments.show', ['enrollment' => $enrollment, 'ref' => Util::getRef('/enrollments')]);
    }

    public function edit($enrollment_id)
    {
        $enrollment = Enrollment::query()
            ->select('Enrollment.enrollment_id', 'Enrollment.student', 'Enrollment.course', 'Enrollment.enrollment_date', 'Enrollment.grade')
            ->where('Enrollment.enrollment_id', $enrollment_id)
            ->first();
        return view('enrollments.edit', ['enrollment' => $enrollment, 'ref' => Util::getRef('/enrollments')]);
    }

    public function update($enrollment_id)
    {
        Util::setRef();
        $this->validate(request(), [
            'grade' => 'max:50'
        ]);
        Enrollment::find($enrollment_id)->update([
            'student' => request()->input('student'),
            'course' => request()->input('course'),
            'enrollment_date' => Util::getDate(request()->input('enrollment_date')),
            'grade' => request()->input('grade')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($enrollment_id)
    {
        Enrollment::find($enrollment_id)->delete();
        return back();
    }
}