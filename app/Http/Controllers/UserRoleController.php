<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Util;
use App\Models\UserRole;

class UserRoleController extends Controller {

    public function index()
    {
        $size = request()->input('size') ? request()->input('size') : 10;
        $sort = request()->input('sort') ? request()->input('sort') : 'UserRole.user_id';
        $sortDirection = request()->input('sort') ? (request()->input('desc') ? 'desc' : 'asc') : 'asc';
        $column = request()->input('sc');
        $query = UserRole::query()
            ->select('UserRole.user_id', 'UserRole.role_id')
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
        $userRoles = $query->paginate($size);
        return view('userRoles.index', ['userRoles' => $userRoles]);
    }

    public function create()
    {
        return view('userRoles.create', ['ref' => Util::getRef('/userRoles')]);
    }

    public function store()
    {
        Util::setRef();
        $this->validate(request(), [
            'user_id' => 'required',
            'role_id' => 'required'
        ]);
        $this->validate(request(), [ 'user_id' => Rule::unique('UserRole', 'user_id')->where('user_id', request()->input('user_id'))->where('role_id', request()->input('role_id')) ]);
        UserRole::create([
            'user_id' => request()->input('user_id'),
            'role_id' => request()->input('role_id')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function show($user_id, $role_id)
    {
        $userRole = UserRole::query()
            ->select('UserRole.user_id', 'UserRole.role_id')
            ->where('UserRole.user_id', $user_id)
            ->where('UserRole.role_id', $role_id)
            ->first();
        return view('userRoles.show', ['userRole' => $userRole, 'ref' => Util::getRef('/userRoles')]);
    }

    public function edit($user_id, $role_id)
    {
        $userRole = UserRole::query()
            ->select('UserRole.user_id', 'UserRole.role_id')
            ->where('UserRole.user_id', $user_id)
            ->where('UserRole.role_id', $role_id)
            ->first();
        return view('userRoles.edit', ['userRole' => $userRole, 'ref' => Util::getRef('/userRoles')]);
    }

    public function update($user_id, $role_id)
    {
        Util::setRef();
        $this->validate(request(), [
            'user_id' => 'required',
            'role_id' => 'required'
        ]);
        DB::table('UserRole')
            ->where('UserRole.user_id', $user_id)
            ->where('UserRole.role_id', $role_id)
            ->update([
            'user_id' => request()->input('user_id'),
            'role_id' => request()->input('role_id')
        ]);
        return redirect(request()->query->get('ref'));
    }

    public function destroy($user_id, $role_id)
    {
        DB::table('UserRole')
            ->where('UserRole.user_id', $user_id)
            ->where('UserRole.role_id', $role_id)
            ->delete();
        return back();
    }
}