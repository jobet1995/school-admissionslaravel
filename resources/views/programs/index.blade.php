@extends('layout')
@section('content')
<div class="container">
    <div class="col s12"><input id="searchbar_toggle" type="checkbox" />
        <div id="searchbar" class="row">
            <div class="col s12 l2">
                <select id="search_col" onchange="searchChange()">
                    <option value="Program.program_id" data-type="number" {{request()->input('sc') == 'Program.program_id' ? 'selected' : ''}}>Program Program Id</option>
                    <option value="Program.program_name" {{request()->input('sc') == 'Program.program_name' ? 'selected' : ''}}>Program Program Name</option>
                    <option value="Program.description" {{request()->input('sc') == 'Program.description' ? 'selected' : ''}}>Program Description</option>
                    <option value="Program.requirements" {{request()->input('sc') == 'Program.requirements' ? 'selected' : ''}}>Program Requirements</option>
                    <option value="Program.credits" {{request()->input('sc') == 'Program.credits' ? 'selected' : ''}}>Program Credits</option>
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
                    <th class="@getSortClass(Program.program_id,asc)"><a href="@getLink(sort,programs,Program.program_id,asc)">Program Id</a></th>
                    <th class="@getSortClass(Program.program_name)"><a href="@getLink(sort,programs,Program.program_name)">Program Name</a></th>
                    <th class="@getSortClass(Program.description)"><a href="@getLink(sort,programs,Program.description)">Description</a></th>
                    <th class="@getSortClass(Program.requirements) hide-on-small-only"><a href="@getLink(sort,programs,Program.requirements)">Requirements</a></th>
                    <th class="@getSortClass(Program.credits) hide-on-small-only"><a href="@getLink(sort,programs,Program.credits)">Credits</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                <tr>
                    <td class="center-align">{{$program->program_id}}</td>
                    <td>{{$program->program_name}}</td>
                    <td>{{$program->description}}</td>
                    <td class="hide-on-small-only">{{$program->requirements}}</td>
                    <td class="hide-on-small-only">{{$program->credits}}</td>
                    <td class="center-align">
                        <a class="btn-small grey" href="/admin/programs/{{$program->program_id}}" title="View"><i class="mdi mdi-eye"></i></a>
                        <a class="btn-small" href="/admin/programs/{{$program->program_id}}/edit" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        <form action="/admin/programs/{{$program->program_id}}" method="POST">
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
                        <option value="@getLink(size,programs,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                        <option value="@getLink(size,programs,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                        <option value="@getLink(size,programs,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="col m9 s6">
                <div class="right hide-on-small-only">
                    <ul class="pagination">
                        <li class="{{$programs->currentPage() <= 1 ? ' disabled' : ''}}"><a href="@getLink(page,programs,$programs->currentPage()-1)">Prev</a></li>
                        @for ($page = 1; $page <= $programs->lastPage(); $page++)
                        <li class="{{$programs->currentPage() == $page ? ' active' : ''}}"><a href="@getLink(page,programs,$page)">{{$page}}</a></li>
                        @endfor
                        <li class="{{$programs->currentPage() >= $programs->lastPage() ? ' disabled' : ''}}"><a href="@getLink(page,programs,$programs->currentPage()+1)">Next</a></li>
                    </ul>
                </div>
                <div class="right hide-on-med-and-up">
                    <label> Page
                        <select id="page_index" onchange="location = this.value">
                            @for ($page = 1; $page <= $programs->lastPage(); $page++)
                            <option value="@getLink(page,programs,$page)" {{$programs->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                            @endfor
                        </select>
                    </label> of <span>{{$programs->lastPage()}}</span>
                    <div class="btn-group">
                        <a class="btn-small{{$programs->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,programs,$programs->currentPage()-1)"><i class="mdi mdi-chevron-left"></i></a>
                        <a class="btn-small{{$programs->currentPage() >= $programs->lastPage() ? ' disabled' : ''}}" href="@getLink(page,programs,$programs->currentPage()+1)"><i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-small" href="/admin/programs/create">Create</a>
    </div>
    <style>
        #searchbar_toggle_menu { display: inline-flex!important }
    </style>
</div>
<script>
    initPage()
</script>
@endsection