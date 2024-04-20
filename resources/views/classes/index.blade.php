@extends('layout')
@section('content')
<div class="container">
    <div class="col s12"><input id="searchbar_toggle" type="checkbox" />
        <div id="searchbar" class="row">
            <div class="col s12 l2">
                <select id="search_col" onchange="searchChange()">
                    <option value="Class.class_id" data-type="number" {{request()->input('sc') == 'Class.class_id' ? 'selected' : ''}}>Class Class Id</option>
                    <option value="Class.student" data-type="number" {{request()->input('sc') == 'Class.student' ? 'selected' : ''}}>Class Student</option>
                    <option value="Class.course" data-type="number" {{request()->input('sc') == 'Class.course' ? 'selected' : ''}}>Class Course</option>
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
                    <th class="@getSortClass(Class.class_id,asc)"><a href="@getLink(sort,classes,Class.class_id,asc)">Class Id</a></th>
                    <th class="@getSortClass(Class.student)"><a href="@getLink(sort,classes,Class.student)">Student</a></th>
                    <th class="@getSortClass(Class.course)"><a href="@getLink(sort,classes,Class.course)">Course</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                <tr>
                    <td class="center-align">{{$class->class_id}}</td>
                    <td class="right-align">{{$class->student}}</td>
                    <td class="right-align">{{$class->course}}</td>
                    <td class="center-align">
                        <a class="btn-small grey" href="/admin/classes/{{$class->class_id}}" title="View"><i class="mdi mdi-eye"></i></a>
                        <a class="btn-small" href="/admin/classes/{{$class->class_id}}/edit" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        <form action="/admin/classes/{{$class->class_id}}" method="POST">
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
                        <option value="@getLink(size,classes,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                        <option value="@getLink(size,classes,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                        <option value="@getLink(size,classes,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="col m9 s6">
                <div class="right hide-on-small-only">
                    <ul class="pagination">
                        <li class="{{$classes->currentPage() <= 1 ? ' disabled' : ''}}"><a href="@getLink(page,classes,$classes->currentPage()-1)">Prev</a></li>
                        @for ($page = 1; $page <= $classes->lastPage(); $page++)
                        <li class="{{$classes->currentPage() == $page ? ' active' : ''}}"><a href="@getLink(page,classes,$page)">{{$page}}</a></li>
                        @endfor
                        <li class="{{$classes->currentPage() >= $classes->lastPage() ? ' disabled' : ''}}"><a href="@getLink(page,classes,$classes->currentPage()+1)">Next</a></li>
                    </ul>
                </div>
                <div class="right hide-on-med-and-up">
                    <label> Page
                        <select id="page_index" onchange="location = this.value">
                            @for ($page = 1; $page <= $classes->lastPage(); $page++)
                            <option value="@getLink(page,classes,$page)" {{$classes->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                            @endfor
                        </select>
                    </label> of <span>{{$classes->lastPage()}}</span>
                    <div class="btn-group">
                        <a class="btn-small{{$classes->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,classes,$classes->currentPage()-1)"><i class="mdi mdi-chevron-left"></i></a>
                        <a class="btn-small{{$classes->currentPage() >= $classes->lastPage() ? ' disabled' : ''}}" href="@getLink(page,classes,$classes->currentPage()+1)"><i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-small" href="/admin/classes/create">Create</a>
    </div>
    <style>
        #searchbar_toggle_menu { display: inline-flex!important }
    </style>
</div>
<script>
    initPage()
</script>
@endsection