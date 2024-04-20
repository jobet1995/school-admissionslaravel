<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Student;

class StudentController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Student.student_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Student::query()
            ->select('Student.student_id', 'Student.first_name', 'Student.last_name', 'Student.email', 'Student.date_of_birth', 'Student.phone', 'Student.streetAddress', 'Student.cityAddress', 'Student.postalCode', 'Student.province')
            ->orderBy($sort, $sortDirection);
        if (Util::IsInvalidSearch($query->getQuery()->columns, $column)) {
            abort(403);
        }
        if (request()->input('sw')) {
            $search = request()->input('sw');
            $operator = Util::getOperator(request()->input('so'));
            if ($column == 'Student.date_of_birth') {
                $search = Util::formatDateStr($search, 'date');
            }
            if ($operator == 'like') {
                $search = '%'.$search.'%';
            }
            $query->where($column, $operator, $search);
        }
        $students = $query->paginate($size);
        return view('students.index', ['students' => $students]);
    }

    public function create()
    {
        return view('students.create', ['ref' => Util::getRef('/students')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'first_name' => 'max:50',
            'last_name' => 'max:50',
            'email' => 'max:50',
            'phone' => 'max:50',
            'streetAddress' => 'max:50',
            'cityAddress' => 'max:50',
            'province' => 'max:50'
        ]);
        Student::create([
            'first_name' => request()->input('first_name'),
            'last_name' => request()->input('last_name'),
            'email' => request()->input('email'),
            'date_of_birth' => Util::getDate(request()->input('date_of_birth')),
            'phone' => request()->input('phone'),
            'streetAddress' => request()->input('streetAddress'),
            'cityAddress' => request()->input('cityAddress'),
            'postalCode' => request()->input('postalCode'),
            'province' => request()->input('province')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($student_id)
    {
        $student = Student::query()
            ->select('Student.student_id', 'Student.first_name', 'Student.last_name', 'Student.email', 'Student.date_of_birth', 'Student.phone', 'Student.streetAddress', 'Student.cityAddress', 'Student.postalCode', 'Student.province')
            ->where('Student.student_id', $student_id)
            ->first();
        return view('students.show', ['student' => $student, 'ref' => Util::getRef('/students')]);
    }

    public function edit($student_id)
    {
        $student = Student::query()
            ->select('Student.student_id', 'Student.first_name', 'Student.last_name', 'Student.email', 'Student.date_of_birth', 'Student.phone', 'Student.streetAddress', 'Student.cityAddress', 'Student.postalCode', 'Student.province')
            ->where('Student.student_id', $student_id)
            ->first();
        return view('students.edit', ['student' => $student, 'ref' => Util::getRef('/students')]);
    }

    public function update($student_id)
    {
        Util::setRef();
        $this->validate(request(), [
            'first_name' => 'max:50',
            'last_name' => 'max:50',
            'email' => 'max:50',
            'phone' => 'max:50',
            'streetAddress' => 'max:50',
            'cityAddress' => 'max:50',
            'province' => 'max:50'
        ]);
        Student::find($student_id)->update([
            'first_name' => request()->input('first_name'),
            'last_name' => request()->input('last_name'),
            'email' => request()->input('email'),
            'date_of_birth' => Util::getDate(request()->input('date_of_birth')),
            'phone' => request()->input('phone'),
            'streetAddress' => request()->input('streetAddress'),
            'cityAddress' => request()->input('cityAddress'),
            'postalCode' => request()->input('postalCode'),
            'province' => request()->input('province')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($student_id)
    {
        Student::find($student_id)->delete();
        return back();
    }
}