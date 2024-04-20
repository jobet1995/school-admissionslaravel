<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Class;

class ClassController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Class.class_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Class::query()
            ->select('Class.class_id', 'Class.student', 'Class.course')
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
        $classes = $query->paginate($size);
        return view('classes.index', ['classes' => $classes]);
    }

    public function create()
    {
        return view('classes.create', ['ref' => Util::getRef('/classes')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
        ]);
        Class::create([
            'student' => request()->input('student'),
            'course' => request()->input('course')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($class_id)
    {
        $class = Class::query()
            ->select('Class.class_id', 'Class.student', 'Class.course')
            ->where('Class.class_id', $class_id)
            ->first();
        return view('classes.show', ['class' => $class, 'ref' => Util::getRef('/classes')]);
    }

    public function edit($class_id)
    {
        $class = Class::query()
            ->select('Class.class_id', 'Class.student', 'Class.course')
            ->where('Class.class_id', $class_id)
            ->first();
        return view('classes.edit', ['class' => $class, 'ref' => Util::getRef('/classes')]);
    }

    public function update($class_id)
    {
        Util::setRef();
        $this->validate(request(), [
        ]);
        Class::find($class_id)->update([
            'student' => request()->input('student'),
            'course' => request()->input('course')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($class_id)
    {
        Class::find($class_id)->delete();
        return back();
    }
}