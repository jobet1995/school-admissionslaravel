@extends('layout')
@section('content')
<div class="container">
    <div class="col s12"><input id="searchbar_toggle" type="checkbox" />
        <div id="searchbar" class="row">
            <div class="col s12 l2">
                <select id="search_col" onchange="searchChange()">
                    <option value="Faculty.faculty_id" data-type="number" {{request()->input('sc') == 'Faculty.faculty_id' ? 'selected' : ''}}>Faculty Faculty Id</option>
                    <option value="Faculty.facultyName" {{request()->input('sc') == 'Faculty.facultyName' ? 'selected' : ''}}>Faculty Faculty Name</option>
                    <option value="Faculty.email" {{request()->input('sc') == 'Faculty.email' ? 'selected' : ''}}>Faculty Email</option>
                    <option value="Faculty.phone" {{request()->input('sc') == 'Faculty.phone' ? 'selected' : ''}}>Faculty Phone</option>
                    <option value="Faculty.facultyType" {{request()->input('sc') == 'Faculty.facultyType' ? 'selected' : ''}}>Faculty Faculty Type</option>
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
                    <th class="@getSortClass(Faculty.faculty_id,asc)"><a href="@getLink(sort,faculties,Faculty.faculty_id,asc)">Faculty Id</a></th>
                    <th class="@getSortClass(Faculty.facultyName)"><a href="@getLink(sort,faculties,Faculty.facultyName)">Faculty Name</a></th>
                    <th class="@getSortClass(Faculty.email)"><a href="@getLink(sort,faculties,Faculty.email)">Email</a></th>
                    <th class="@getSortClass(Faculty.phone) hide-on-small-only"><a href="@getLink(sort,faculties,Faculty.phone)">Phone</a></th>
                    <th class="@getSortClass(Faculty.facultyType) hide-on-small-only"><a href="@getLink(sort,faculties,Faculty.facultyType)">Faculty Type</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faculties as $faculty)
                <tr>
                    <td class="center-align">{{$faculty->faculty_id}}</td>
                    <td>{{$faculty->facultyName}}</td>
                    <td>{{$faculty->email}}</td>
                    <td class="hide-on-small-only">{{$faculty->phone}}</td>
                    <td class="hide-on-small-only">{{$faculty->facultyType}}</td>
                    <td class="center-align">
                        <a class="btn-small grey" href="/admin/faculties/{{$faculty->faculty_id}}" title="View"><i class="mdi mdi-eye"></i></a>
                        <a class="btn-small" href="/admin/faculties/{{$faculty->faculty_id}}/edit" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        <form action="/admin/faculties/{{$faculty->faculty_id}}" method="POST">
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
                        <option value="@getLink(size,faculties,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                        <option value="@getLink(size,faculties,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                        <option value="@getLink(size,faculties,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="col m9 s6">
                <div class="right hide-on-small-only">
                    <ul class="pagination">
                        <li class="{{$faculties->currentPage() <= 1 ? ' disabled' : ''}}"><a href="@getLink(page,faculties,$faculties->currentPage()-1)">Prev</a></li>
                        @for ($page = 1; $page <= $faculties->lastPage(); $page++)
                        <li class="{{$faculties->currentPage() == $page ? ' active' : ''}}"><a href="@getLink(page,faculties,$page)">{{$page}}</a></li>
                        @endfor
                        <li class="{{$faculties->currentPage() >= $faculties->lastPage() ? ' disabled' : ''}}"><a href="@getLink(page,faculties,$faculties->currentPage()+1)">Next</a></li>
                    </ul>
                </div>
                <div class="right hide-on-med-and-up">
                    <label> Page
                        <select id="page_index" onchange="location = this.value">
                            @for ($page = 1; $page <= $faculties->lastPage(); $page++)
                            <option value="@getLink(page,faculties,$page)" {{$faculties->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                            @endfor
                        </select>
                    </label> of <span>{{$faculties->lastPage()}}</span>
                    <div class="btn-group">
                        <a class="btn-small{{$faculties->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,faculties,$faculties->currentPage()-1)"><i class="mdi mdi-chevron-left"></i></a>
                        <a class="btn-small{{$faculties->currentPage() >= $faculties->lastPage() ? ' disabled' : ''}}" href="@getLink(page,faculties,$faculties->currentPage()+1)"><i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-small" href="/admin/faculties/create">Create</a>
    </div>
    <style>
        #searchbar_toggle_menu { display: inline-flex!important }
    </style>
</div>
<script>
    initPage()
</script>
@endsection