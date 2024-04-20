@extends('layout')
@section('content')
<div class="container">
    <div class="col s12"><input id="searchbar_toggle" type="checkbox" />
        <div id="searchbar" class="row">
            <div class="col s12 l2">
                <select id="search_col" onchange="searchChange()">
                    <option value="Course.course_id" data-type="number" {{request()->input('sc') == 'Course.course_id' ? 'selected' : ''}}>Course Course Id</option>
                    <option value="Course.course_name" {{request()->input('sc') == 'Course.course_name' ? 'selected' : ''}}>Course Course Name</option>
                    <option value="Course.department" {{request()->input('sc') == 'Course.department' ? 'selected' : ''}}>Course Department</option>
                    <option value="Course.credits" data-type="number" {{request()->input('sc') == 'Course.credits' ? 'selected' : ''}}>Course Credits</option>
                    <option value="Course.program" data-type="number" {{request()->input('sc') == 'Course.program' ? 'selected' : ''}}>Course Program</option>
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
                    <th class="@getSortClass(Course.course_id,asc)"><a href="@getLink(sort,courses,Course.course_id,asc)">Course Id</a></th>
                    <th class="@getSortClass(Course.course_name)"><a href="@getLink(sort,courses,Course.course_name)">Course Name</a></th>
                    <th class="@getSortClass(Course.department)"><a href="@getLink(sort,courses,Course.department)">Department</a></th>
                    <th class="@getSortClass(Course.credits) hide-on-small-only"><a href="@getLink(sort,courses,Course.credits)">Credits</a></th>
                    <th class="@getSortClass(Course.program) hide-on-small-only"><a href="@getLink(sort,courses,Course.program)">Program</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                <tr>
                    <td class="center-align">{{$course->course_id}}</td>
                    <td>{{$course->course_name}}</td>
                    <td>{{$course->department}}</td>
                    <td class="hide-on-small-only right-align">{{$course->credits}}</td>
                    <td class="hide-on-small-only right-align">{{$course->program}}</td>
                    <td class="center-align">
                        <a class="btn-small grey" href="/admin/courses/{{$course->course_id}}" title="View"><i class="mdi mdi-eye"></i></a>
                        <a class="btn-small" href="/admin/courses/{{$course->course_id}}/edit" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        <form action="/admin/courses/{{$course->course_id}}" method="POST">
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
                        <option value="@getLink(size,courses,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                        <option value="@getLink(size,courses,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                        <option value="@getLink(size,courses,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="col m9 s6">
                <div class="right hide-on-small-only">
                    <ul class="pagination">
                        <li class="{{$courses->currentPage() <= 1 ? ' disabled' : ''}}"><a href="@getLink(page,courses,$courses->currentPage()-1)">Prev</a></li>
                        @for ($page = 1; $page <= $courses->lastPage(); $page++)
                        <li class="{{$courses->currentPage() == $page ? ' active' : ''}}"><a href="@getLink(page,courses,$page)">{{$page}}</a></li>
                        @endfor
                        <li class="{{$courses->currentPage() >= $courses->lastPage() ? ' disabled' : ''}}"><a href="@getLink(page,courses,$courses->currentPage()+1)">Next</a></li>
                    </ul>
                </div>
                <div class="right hide-on-med-and-up">
                    <label> Page
                        <select id="page_index" onchange="location = this.value">
                            @for ($page = 1; $page <= $courses->lastPage(); $page++)
                            <option value="@getLink(page,courses,$page)" {{$courses->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                            @endfor
                        </select>
                    </label> of <span>{{$courses->lastPage()}}</span>
                    <div class="btn-group">
                        <a class="btn-small{{$courses->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,courses,$courses->currentPage()-1)"><i class="mdi mdi-chevron-left"></i></a>
                        <a class="btn-small{{$courses->currentPage() >= $courses->lastPage() ? ' disabled' : ''}}" href="@getLink(page,courses,$courses->currentPage()+1)"><i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-small" href="/admin/courses/create">Create</a>
    </div>
    <style>
        #searchbar_toggle_menu { display: inline-flex!important }
    </style>
</div>
<script>
    initPage()
</script>
@endsection