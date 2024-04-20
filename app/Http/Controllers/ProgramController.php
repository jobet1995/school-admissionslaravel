<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Program;

class ProgramController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Program.program_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Program::query()
            ->select('Program.program_id', 'Program.program_name', 'Program.description', 'Program.requirements', 'Program.credits')
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
        $programs = $query->paginate($size);
        return view('programs.index', ['programs' => $programs]);
    }

    public function create()
    {
        return view('programs.create', ['ref' => Util::getRef('/programs')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'program_name' => 'max:50',
            'description' => 'max:50',
            'requirements' => 'max:50',
            'credits' => 'max:50'
        ]);
        Program::create([
            'program_name' => request()->input('program_name'),
            'description' => request()->input('description'),
            'requirements' => request()->input('requirements'),
            'credits' => request()->input('credits')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($program_id)
    {
        $program = Program::query()
            ->select('Program.program_id', 'Program.program_name', 'Program.description', 'Program.requirements', 'Program.credits')
            ->where('Program.program_id', $program_id)
            ->first();
        return view('programs.show', ['program' => $program, 'ref' => Util::getRef('/programs')]);
    }

    public function edit($program_id)
    {
        $program = Program::query()
            ->select('Program.program_id', 'Program.program_name', 'Program.description', 'Program.requirements', 'Program.credits')
            ->where('Program.program_id', $program_id)
            ->first();
        return view('programs.edit', ['program' => $program, 'ref' => Util::getRef('/programs')]);
    }

    public function update($program_id)
    {
        Util::setRef();
        $this->validate(request(), [
            'program_name' => 'max:50',
            'description' => 'max:50',
            'requirements' => 'max:50',
            'credits' => 'max:50'
        ]);
        Program::find($program_id)->update([
            'program_name' => request()->input('program_name'),
            'description' => request()->input('description'),
            'requirements' => request()->input('requirements'),
            'credits' => request()->input('credits')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($program_id)
    {
        Program::find($program_id)->delete();
        return back();
    }
}