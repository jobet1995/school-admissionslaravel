<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Faculty;

class FacultyController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Faculty.faculty_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Faculty::query()
            ->select('Faculty.faculty_id', 'Faculty.facultyName', 'Faculty.email', 'Faculty.phone', 'Faculty.facultyType')
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
        $faculties = $query->paginate($size);
        return view('faculties.index', ['faculties' => $faculties]);
    }

    public function create()
    {
        return view('faculties.create', ['ref' => Util::getRef('/faculties')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'facultyName' => 'max:50',
            'email' => 'unique:Faculty,email|required|max:50',
            'phone' => 'max:50',
            'facultyType' => 'max:50'
        ]);
        Faculty::create([
            'facultyName' => request()->input('facultyName'),
            'email' => request()->input('email'),
            'phone' => request()->input('phone'),
            'facultyType' => request()->input('facultyType')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($faculty_id)
    {
        $faculty = Faculty::query()
            ->select('Faculty.faculty_id', 'Faculty.facultyName', 'Faculty.email', 'Faculty.phone', 'Faculty.facultyType')
            ->where('Faculty.faculty_id', $faculty_id)
            ->first();
        return view('faculties.show', ['faculty' => $faculty, 'ref' => Util::getRef('/faculties')]);
    }

    public function edit($faculty_id)
    {
        $faculty = Faculty::query()
            ->select('Faculty.faculty_id', 'Faculty.facultyName', 'Faculty.email', 'Faculty.phone', 'Faculty.facultyType')
            ->where('Faculty.faculty_id', $faculty_id)
            ->first();
        return view('faculties.edit', ['faculty' => $faculty, 'ref' => Util::getRef('/faculties')]);
    }

    public function update($faculty_id)
    {
        Util::setRef();
        $this->validate(request(), [
            'facultyName' => 'max:50',
            'email' => 'required|max:50',
            'phone' => 'max:50',
            'facultyType' => 'max:50'
        ]);
        Faculty::find($faculty_id)->update([
            'facultyName' => request()->input('facultyName'),
            'email' => request()->input('email'),
            'phone' => request()->input('phone'),
            'facultyType' => request()->input('facultyType')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($faculty_id)
    {
        Faculty::find($faculty_id)->delete();
        return back();
    }
}