<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Applications;

class ApplicationsController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Applications.application_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Applications::query()
            ->select('Applications.application_id', 'Applications.student', 'Applications.course', 'Applications.application_date', 'Applications.status')
            ->orderBy($sort, $sortDirection);
        if (Util::IsInvalidSearch($query->getQuery()->columns, $column)) {
            abort(403);
        }
        if (request()->input('sw')) {
            $search = request()->input('sw');
            $operator = Util::getOperator(request()->input('so'));
            if ($column == 'Applications.application_date') {
                $search = Util::formatDateStr($search, 'date');
            }
            if ($operator == 'like') {
                $search = '%'.$search.'%';
            }
            $query->where($column, $operator, $search);
        }
        $applicationses = $query->paginate($size);
        return view('applicationses.index', ['applicationses' => $applicationses]);
    }

    public function create()
    {
        return view('applicationses.create', ['ref' => Util::getRef('/applicationses')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'status' => 'max:50'
        ]);
        Applications::create([
            'student' => request()->input('student'),
            'course' => request()->input('course'),
            'application_date' => Util::getDate(request()->input('application_date')),
            'status' => request()->input('status')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($application_id)
    {
        $applications = Applications::query()
            ->select('Applications.application_id', 'Applications.student', 'Applications.course', 'Applications.application_date', 'Applications.status')
            ->where('Applications.application_id', $application_id)
            ->first();
        return view('applicationses.show', ['applications' => $applications, 'ref' => Util::getRef('/applicationses')]);
    }

    public function edit($application_id)
    {
        $applications = Applications::query()
            ->select('Applications.application_id', 'Applications.student', 'Applications.course', 'Applications.application_date', 'Applications.status')
            ->where('Applications.application_id', $application_id)
            ->first();
        return view('applicationses.edit', ['applications' => $applications, 'ref' => Util::getRef('/applicationses')]);
    }

    public function update($application_id)
    {
        Util::setRef();
        $this->validate(request(), [
            'status' => 'max:50'
        ]);
        Applications::find($application_id)->update([
            'student' => request()->input('student'),
            'course' => request()->input('course'),
            'application_date' => Util::getDate(request()->input('application_date')),
            'status' => request()->input('status')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($application_id)
    {
        Applications::find($application_id)->delete();
        return back();
    }
}