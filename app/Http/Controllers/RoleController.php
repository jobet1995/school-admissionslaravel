<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Util;
use App\Models\Role;

class RoleController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'Role.id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = Role::query()
            ->select('Role.id', 'Role.name')
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
        $roles = $query->paginate($size);
        return view('roles.index', ['roles' => $roles]);
    }

    public function create()
    {
        return view('roles.create', ['ref' => Util::getRef('/roles')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'name' => 'unique:Role,name|required|max:50'
        ]);
        Role::create([
            'name' => request()->input('name')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($id)
    {
        $role = Role::query()
            ->select('Role.id', 'Role.name')
            ->where('Role.id', $id)
            ->first();
        return view('roles.show', ['role' => $role, 'ref' => Util::getRef('/roles')]);
    }

    public function edit($id)
    {
        $role = Role::query()
            ->select('Role.id', 'Role.name')
            ->where('Role.id', $id)
            ->first();
        return view('roles.edit', ['role' => $role, 'ref' => Util::getRef('/roles')]);
    }

    public function update($id)
    {
        Util::setRef();
        $this->validate(request(), [
            'name' => 'required|max:50'
        ]);
        Role::find($id)->update([
            'name' => request()->input('name')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($id)
    {
        Role::find($id)->delete();
        return back();
    }
}