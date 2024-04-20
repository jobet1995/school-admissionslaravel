<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\AdmissionDecision;

class AdmissionDecisionController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'AdmissionDecision.rec_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = AdmissionDecision::query()
            ->select('AdmissionDecision.rec_id', 'AdmissionDecision.application', 'AdmissionDecision.decision_date', 'AdmissionDecision.decision')
            ->orderBy($sort, $sortDirection);
        if (Util::IsInvalidSearch($query->getQuery()->columns, $column)) {
            abort(403);
        }
        if (request()->input('sw')) {
            $search = request()->input('sw');
            $operator = Util::getOperator(request()->input('so'));
            if ($column == 'AdmissionDecision.decision_date') {
                $search = Util::formatDateStr($search, 'date');
            }
            if ($operator == 'like') {
                $search = '%'.$search.'%';
            }
            $query->where($column, $operator, $search);
        }
        $admissionDecisions = $query->paginate($size);
        return view('admissionDecisions.index', ['admissionDecisions' => $admissionDecisions]);
    }

    public function create()
    {
        return view('admissionDecisions.create', ['ref' => Util::getRef('/admissionDecisions')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'decision' => 'max:50'
        ]);
        AdmissionDecision::create([
            'application' => request()->input('application'),
            'decision_date' => Util::getDate(request()->input('decision_date')),
            'decision' => request()->input('decision')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($rec_id)
    {
        $admissionDecision = AdmissionDecision::query()
            ->select('AdmissionDecision.rec_id', 'AdmissionDecision.application', 'AdmissionDecision.decision_date', 'AdmissionDecision.decision')
            ->where('AdmissionDecision.rec_id', $rec_id)
            ->first();
        return view('admissionDecisions.show', ['admissionDecision' => $admissionDecision, 'ref' => Util::getRef('/admissionDecisions')]);
    }

    public function edit($rec_id)
    {
        $admissionDecision = AdmissionDecision::query()
            ->select('AdmissionDecision.rec_id', 'AdmissionDecision.application', 'AdmissionDecision.decision_date', 'AdmissionDecision.decision')
            ->where('AdmissionDecision.rec_id', $rec_id)
            ->first();
        return view('admissionDecisions.edit', ['admissionDecision' => $admissionDecision, 'ref' => Util::getRef('/admissionDecisions')]);
    }

    public function update($rec_id)
    {
        Util::setRef();
        $this->validate(request(), [
            'decision' => 'max:50'
        ]);
        AdmissionDecision::find($rec_id)->update([
            'application' => request()->input('application'),
            'decision_date' => Util::getDate(request()->input('decision_date')),
            'decision' => request()->input('decision')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($rec_id)
    {
        AdmissionDecision::find($rec_id)->delete();
        return back();
    }
}