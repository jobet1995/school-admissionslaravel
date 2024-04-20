@extends('layout')
@section('content')
<div class="container">
    <div class="col s12"><input id="searchbar_toggle" type="checkbox" />
        <div id="searchbar" class="row">
            <div class="col s12 l2">
                <select id="search_col" onchange="searchChange()">
                    <option value="Role.id" data-type="number" {{request()->input('sc') == 'Role.id' ? 'selected' : ''}}>Role Id</option>
                    <option value="Role.name" {{request()->input('sc') == 'Role.name' ? 'selected' : ''}}>Role Name</option>
                </select>
            </div>
            <div class="col s12 l2">
                <select id="search_oper">
                    <option value="c" {{request()->input('so') == 'c' ? 'selected' : ''}}>Contains</option>
                    <option value="e" {{request()->input('so') == 'e' ? 'selected' : ''}}>Equals</option>
                    <option value="g" {{request()->input('so') == 'g' ? 'selected' : ''}}>&gt;</option>
                    <option value="ge" {{request()->input('so') == 'ge' ? 'selected' : ''}}>&gt;&#x3D;</option>
                    <option value="l" {{request()->input('so') == 'l' ? 'selected' : ''}}>&lt;</option>
                    <option value="le" {{request()->input('so') == 'le' ? 'selected' : ''}}>&lt;&#x3D;</option>
                </select>
            </div>
            <div class="col s12 l2">
                <input id="search_word" autocomplete="off" onkeyup="search(event)" value="{{request()->input('sw')}}" />
            </div>
            <div class="col s12 l6">
                <button class="btn-small" onclick="search()">Search</button>
                <button class="grey btn-small" onclick="clearSearch()">Clear</button>
            </div>
        </div>
        <table class="striped highlight">
            <thead>
                <tr>
                    <th class="@getSortClass(Role.id,asc)"><a href="@getLink(sort,roles,Role.id,asc)">Id</a></th>
                    <th class="@getSortClass(Role.name)"><a href="@getLink(sort,roles,Role.name)">Name</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td class="center-align">{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td class="center-align">
                        <a class="btn-small grey" href="/admin/roles/{{$role->id}}" title="View"><i class="mdi mdi-eye"></i></a>
                        <a class="btn-small" href="/admin/roles/{{$role->id}}/edit" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        <form action="/admin/roles/{{$role->id}}" method="POST">
                            @method("DELETE")
                            @csrf
                            <a class="btn-small red" href="#!" onclick="deleteItem(this)" title="Delete"><i class="mdi mdi-close-thick"></i></a>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col m3 s6">
                <label>Show
                    <select id="page_size" onchange="location = this.value">
                        <option value="@getLink(size,roles,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                        <option value="@getLink(size,roles,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                        <option value="@getLink(size,roles,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="col m9 s6">
                <div class="right hide-on-small-only">
                    <ul class="pagination">
                        <li class="{{$roles->currentPage() <= 1 ? ' disabled' : ''}}"><a href="@getLink(page,roles,$roles->currentPage()-1)">Prev</a></li>
                        @for ($page = 1; $page <= $roles->lastPage(); $page++)
                        <li class="{{$roles->currentPage() == $page ? ' active' : ''}}"><a href="@getLink(page,roles,$page)">{{$page}}</a></li>
                        @endfor
                        <li class="{{$roles->currentPage() >= $roles->lastPage() ? ' disabled' : ''}}"><a href="@getLink(page,roles,$roles->currentPage()+1)">Next</a></li>
                    </ul>
                </div>
                <div class="right hide-on-med-and-up">
                    <label> Page
                        <select id="page_index" onchange="location = this.value">
                            @for ($page = 1; $page <= $roles->lastPage(); $page++)
                            <option value="@getLink(page,roles,$page)" {{$roles->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                            @endfor
                        </select>
                    </label> of <span>{{$roles->lastPage()}}</span>
                    <div class="btn-group">
                        <a class="btn-small{{$roles->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,roles,$roles->currentPage()-1)"><i class="mdi mdi-chevron-left"></i></a>
                        <a class="btn-small{{$roles->currentPage() >= $roles->lastPage() ? ' disabled' : ''}}" href="@getLink(page,roles,$roles->currentPage()+1)"><i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-small" href="/admin/roles/create">Create</a>
    </div>
    <style>
        #searchbar_toggle_menu { display: inline-flex!important }
    </style>
</div>
<script>
    initPage()
</script>
@endsection