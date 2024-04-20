@extends('layout')
@section('content')
<div class="container">
    <div class="col s12"><input id="searchbar_toggle" type="checkbox" />
        <div id="searchbar" class="row">
            <div class="col s12 l2">
                <select id="search_col" onchange="searchChange()">
                    <option value="Enrollment.enrollment_id" data-type="number" {{request()->input('sc') == 'Enrollment.enrollment_id' ? 'selected' : ''}}>Enrollment Enrollment Id</option>
                    <option value="Enrollment.student" data-type="number" {{request()->input('sc') == 'Enrollment.student' ? 'selected' : ''}}>Enrollment Student</option>
                    <option value="Enrollment.course" data-type="number" {{request()->input('sc') == 'Enrollment.course' ? 'selected' : ''}}>Enrollment Course</option>
                    <option value="Enrollment.enrollment_date" data-type="date" {{request()->input('sc') == 'Enrollment.enrollment_date' ? 'selected' : ''}}>Enrollment Enrollment Date</option>
                    <option value="Enrollment.grade" {{request()->input('sc') == 'Enrollment.grade' ? 'selected' : ''}}>Enrollment Grade</option>
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
                    <th class="@getSortClass(Enrollment.enrollment_id,asc)"><a href="@getLink(sort,enrollments,Enrollment.enrollment_id,asc)">Enrollment Id</a></th>
                    <th class="@getSortClass(Enrollment.student)"><a href="@getLink(sort,enrollments,Enrollment.student)">Student</a></th>
                    <th class="@getSortClass(Enrollment.course)"><a href="@getLink(sort,enrollments,Enrollment.course)">Course</a></th>
                    <th class="@getSortClass(Enrollment.enrollment_date) hide-on-small-only"><a href="@getLink(sort,enrollments,Enrollment.enrollment_date)">Enrollment Date</a></th>
                    <th class="@getSortClass(Enrollment.grade) hide-on-small-only"><a href="@getLink(sort,enrollments,Enrollment.grade)">Grade</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enrollments as $enrollment)
                <tr>
                    <td class="center-align">{{$enrollment->enrollment_id}}</td>
                    <td class="right-align">{{$enrollment->student}}</td>
                    <td class="right-align">{{$enrollment->course}}</td>
                    <td class="hide-on-small-only center-align">{{$enrollment->enrollment_date}}</td>
                    <td class="hide-on-small-only">{{$enrollment->grade}}</td>
                    <td class="center-align">
                        <a class="btn-small grey" href="/admin/enrollments/{{$enrollment->enrollment_id}}" title="View"><i class="mdi mdi-eye"></i></a>
                        <a class="btn-small" href="/admin/enrollments/{{$enrollment->enrollment_id}}/edit" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        <form action="/admin/enrollments/{{$enrollment->enrollment_id}}" method="POST">
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
                        <option value="@getLink(size,enrollments,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                        <option value="@getLink(size,enrollments,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                        <option value="@getLink(size,enrollments,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="col m9 s6">
                <div class="right hide-on-small-only">
                    <ul class="pagination">
                        <li class="{{$enrollments->currentPage() <= 1 ? ' disabled' : ''}}"><a href="@getLink(page,enrollments,$enrollments->currentPage()-1)">Prev</a></li>
                        @for ($page = 1; $page <= $enrollments->lastPage(); $page++)
                        <li class="{{$enrollments->currentPage() == $page ? ' active' : ''}}"><a href="@getLink(page,enrollments,$page)">{{$page}}</a></li>
                        @endfor
                        <li class="{{$enrollments->currentPage() >= $enrollments->lastPage() ? ' disabled' : ''}}"><a href="@getLink(page,enrollments,$enrollments->currentPage()+1)">Next</a></li>
                    </ul>
                </div>
                <div class="right hide-on-med-and-up">
                    <label> Page
                        <select id="page_index" onchange="location = this.value">
                            @for ($page = 1; $page <= $enrollments->lastPage(); $page++)
                            <option value="@getLink(page,enrollments,$page)" {{$enrollments->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                            @endfor
                        </select>
                    </label> of <span>{{$enrollments->lastPage()}}</span>
                    <div class="btn-group">
                        <a class="btn-small{{$enrollments->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,enrollments,$enrollments->currentPage()-1)"><i class="mdi mdi-chevron-left"></i></a>
                        <a class="btn-small{{$enrollments->currentPage() >= $enrollments->lastPage() ? ' disabled' : ''}}" href="@getLink(page,enrollments,$enrollments->currentPage()+1)"><i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-small" href="/admin/enrollments/create">Create</a>
    </div>
    <style>
        #searchbar_toggle_menu { display: inline-flex!important }
    </style>
</div>
<script>
    initPage()
</script>
@endsection