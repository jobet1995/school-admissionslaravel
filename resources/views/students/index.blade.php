@extends('layout')
@section('content')
<div class="container">
    <div class="col s12"><input id="searchbar_toggle" type="checkbox" />
        <div id="searchbar" class="row">
            <div class="col s12 l2">
                <select id="search_col" onchange="searchChange()">
                    <option value="Student.student_id" data-type="number" {{request()->input('sc') == 'Student.student_id' ? 'selected' : ''}}>Student Student Id</option>
                    <option value="Student.first_name" {{request()->input('sc') == 'Student.first_name' ? 'selected' : ''}}>Student First Name</option>
                    <option value="Student.last_name" {{request()->input('sc') == 'Student.last_name' ? 'selected' : ''}}>Student Last Name</option>
                    <option value="Student.email" {{request()->input('sc') == 'Student.email' ? 'selected' : ''}}>Student Email</option>
                    <option value="Student.date_of_birth" data-type="date" {{request()->input('sc') == 'Student.date_of_birth' ? 'selected' : ''}}>Student Date Of Birth</option>
                    <option value="Student.phone" {{request()->input('sc') == 'Student.phone' ? 'selected' : ''}}>Student Phone</option>
                    <option value="Student.streetAddress" {{request()->input('sc') == 'Student.streetAddress' ? 'selected' : ''}}>Student Street Address</option>
                    <option value="Student.cityAddress" {{request()->input('sc') == 'Student.cityAddress' ? 'selected' : ''}}>Student City Address</option>
                    <option value="Student.postalCode" data-type="number" {{request()->input('sc') == 'Student.postalCode' ? 'selected' : ''}}>Student Postal Code</option>
                    <option value="Student.province" {{request()->input('sc') == 'Student.province' ? 'selected' : ''}}>Student Province</option>
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
                    <th class="@getSortClass(Student.student_id,asc)"><a href="@getLink(sort,students,Student.student_id,asc)">Student Id</a></th>
                    <th class="@getSortClass(Student.first_name)"><a href="@getLink(sort,students,Student.first_name)">First Name</a></th>
                    <th class="@getSortClass(Student.last_name)"><a href="@getLink(sort,students,Student.last_name)">Last Name</a></th>
                    <th class="@getSortClass(Student.email) hide-on-small-only"><a href="@getLink(sort,students,Student.email)">Email</a></th>
                    <th class="@getSortClass(Student.date_of_birth) hide-on-small-only"><a href="@getLink(sort,students,Student.date_of_birth)">Date Of Birth</a></th>
                    <th class="@getSortClass(Student.phone) hide-on-small-only"><a href="@getLink(sort,students,Student.phone)">Phone</a></th>
                    <th class="@getSortClass(Student.streetAddress) hide-on-small-only"><a href="@getLink(sort,students,Student.streetAddress)">Street Address</a></th>
                    <th class="@getSortClass(Student.cityAddress) hide-on-small-only"><a href="@getLink(sort,students,Student.cityAddress)">City Address</a></th>
                    <th class="@getSortClass(Student.postalCode) hide-on-small-only"><a href="@getLink(sort,students,Student.postalCode)">Postal Code</a></th>
                    <th class="@getSortClass(Student.province) hide-on-small-only"><a href="@getLink(sort,students,Student.province)">Province</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td class="center-align">{{$student->student_id}}</td>
                    <td>{{$student->first_name}}</td>
                    <td>{{$student->last_name}}</td>
                    <td class="hide-on-small-only">{{$student->email}}</td>
                    <td class="hide-on-small-only center-align">{{$student->date_of_birth}}</td>
                    <td class="hide-on-small-only">{{$student->phone}}</td>
                    <td class="hide-on-small-only">{{$student->streetAddress}}</td>
                    <td class="hide-on-small-only">{{$student->cityAddress}}</td>
                    <td class="hide-on-small-only right-align">{{$student->postalCode}}</td>
                    <td class="hide-on-small-only">{{$student->province}}</td>
                    <td class="center-align">
                        <a class="btn-small grey" href="/admin/students/{{$student->student_id}}" title="View"><i class="mdi mdi-eye"></i></a>
                        <a class="btn-small" href="/admin/students/{{$student->student_id}}/edit" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        <form action="/admin/students/{{$student->student_id}}" method="POST">
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
                        <option value="@getLink(size,students,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                        <option value="@getLink(size,students,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                        <option value="@getLink(size,students,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="col m9 s6">
                <div class="right hide-on-small-only">
                    <ul class="pagination">
                        <li class="{{$students->currentPage() <= 1 ? ' disabled' : ''}}"><a href="@getLink(page,students,$students->currentPage()-1)">Prev</a></li>
                        @for ($page = 1; $page <= $students->lastPage(); $page++)
                        <li class="{{$students->currentPage() == $page ? ' active' : ''}}"><a href="@getLink(page,students,$page)">{{$page}}</a></li>
                        @endfor
                        <li class="{{$students->currentPage() >= $students->lastPage() ? ' disabled' : ''}}"><a href="@getLink(page,students,$students->currentPage()+1)">Next</a></li>
                    </ul>
                </div>
                <div class="right hide-on-med-and-up">
                    <label> Page
                        <select id="page_index" onchange="location = this.value">
                            @for ($page = 1; $page <= $students->lastPage(); $page++)
                            <option value="@getLink(page,students,$page)" {{$students->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                            @endfor
                        </select>
                    </label> of <span>{{$students->lastPage()}}</span>
                    <div class="btn-group">
                        <a class="btn-small{{$students->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,students,$students->currentPage()-1)"><i class="mdi mdi-chevron-left"></i></a>
                        <a class="btn-small{{$students->currentPage() >= $students->lastPage() ? ' disabled' : ''}}" href="@getLink(page,students,$students->currentPage()+1)"><i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-small" href="/admin/students/create">Create</a>
    </div>
    <style>
        #searchbar_toggle_menu { display: inline-flex!important }
    </style>
</div>
<script>
    initPage()
</script>
@endsection