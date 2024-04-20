@extends('layout')
@section('content')
<div class="container">
    <div>
        <div class="row">
            <div class="col m6 l4">
                <label for="user_account_id">Id</label>
                <input readonly id="user_account_id" name="id" value="{{$userAccount->id}}" type="number" required />
            </div>
            <div class="col m6 l4">
                <label for="user_account_name">Name</label>
                <input readonly id="user_account_name" name="name" value="{{$userAccount->name}}" required maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label for="user_account_email">Email</label>
                <input readonly id="user_account_email" name="email" value="{{$userAccount->email}}" type="email" required maxlength="50" />
            </div>
            <div class="col m6 l4">
                <label>
                    <input readonly id="user_account_active" name="active" class="filled-in" type="checkbox" value="1" {{$userAccount->active ? 'checked' : ''}} />
                    <span>Active</span>
                </label>
            </div>
            <div class="col s12">
                <h5>Roles</h5>
                <table class="striped highlight">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userAccountUserRoles as $userAccountUserRole)
                        <tr>
                            <td>{{$userAccountUserRole->role_name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col s12">
                <a class="btn-small grey" href="{{$ref}}">Back</a>
                <a class="btn-small" href="/admin/userAccounts/{{$userAccount->id}}/edit?ref={{urlencode($ref)}}">Edit</a>
            </div>
        </div>
    </div>
</div>
<script>
    initPage(true)
</script>
@endsection