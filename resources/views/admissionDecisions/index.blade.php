@extends('layout')
@section('content')
<div class="container">
    <div class="col s12"><input id="searchbar_toggle" type="checkbox" />
        <div id="searchbar" class="row">
            <div class="col s12 l2">
                <select id="search_col" onchange="searchChange()">
                    <option value="AdmissionDecision.rec_id" data-type="number" {{request()->input('sc') == 'AdmissionDecision.rec_id' ? 'selected' : ''}}>Admission Decision Rec Id</option>
                    <option value="AdmissionDecision.application" data-type="number" {{request()->input('sc') == 'AdmissionDecision.application' ? 'selected' : ''}}>Admission Decision Application</option>
                    <option value="AdmissionDecision.decision_date" data-type="date" {{request()->input('sc') == 'AdmissionDecision.decision_date' ? 'selected' : ''}}>Admission Decision Decision Date</option>
                    <option value="AdmissionDecision.decision" {{request()->input('sc') == 'AdmissionDecision.decision' ? 'selected' : ''}}>Admission Decision Decision</option>
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
                    <th class="@getSortClass(AdmissionDecision.rec_id,asc)"><a href="@getLink(sort,admissionDecisions,AdmissionDecision.rec_id,asc)">Rec Id</a></th>
                    <th class="@getSortClass(AdmissionDecision.application)"><a href="@getLink(sort,admissionDecisions,AdmissionDecision.application)">Application</a></th>
                    <th class="@getSortClass(AdmissionDecision.decision_date)"><a href="@getLink(sort,admissionDecisions,AdmissionDecision.decision_date)">Decision Date</a></th>
                    <th class="@getSortClass(AdmissionDecision.decision) hide-on-small-only"><a href="@getLink(sort,admissionDecisions,AdmissionDecision.decision)">Decision</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admissionDecisions as $admissionDecision)
                <tr>
                    <td class="center-align">{{$admissionDecision->rec_id}}</td>
                    <td class="right-align">{{$admissionDecision->application}}</td>
                    <td class="center-align">{{$admissionDecision->decision_date}}</td>
                    <td class="hide-on-small-only">{{$admissionDecision->decision}}</td>
                    <td class="center-align">
                        <a class="btn-small grey" href="/admin/admissionDecisions/{{$admissionDecision->rec_id}}" title="View"><i class="mdi mdi-eye"></i></a>
                        <a class="btn-small" href="/admin/admissionDecisions/{{$admissionDecision->rec_id}}/edit" title="Edit"><i class="mdi mdi-pencil"></i></a>
                        <form action="/admin/admissionDecisions/{{$admissionDecision->rec_id}}" method="POST">
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
                        <option value="@getLink(size,admissionDecisions,10)" {{request()->input('size') == '10' ? 'selected' : ''}}>10</option>
                        <option value="@getLink(size,admissionDecisions,20)" {{request()->input('size') == '20' ? 'selected' : ''}}>20</option>
                        <option value="@getLink(size,admissionDecisions,30)" {{request()->input('size') == '30' ? 'selected' : ''}}>30</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="col m9 s6">
                <div class="right hide-on-small-only">
                    <ul class="pagination">
                        <li class="{{$admissionDecisions->currentPage() <= 1 ? ' disabled' : ''}}"><a href="@getLink(page,admissionDecisions,$admissionDecisions->currentPage()-1)">Prev</a></li>
                        @for ($page = 1; $page <= $admissionDecisions->lastPage(); $page++)
                        <li class="{{$admissionDecisions->currentPage() == $page ? ' active' : ''}}"><a href="@getLink(page,admissionDecisions,$page)">{{$page}}</a></li>
                        @endfor
                        <li class="{{$admissionDecisions->currentPage() >= $admissionDecisions->lastPage() ? ' disabled' : ''}}"><a href="@getLink(page,admissionDecisions,$admissionDecisions->currentPage()+1)">Next</a></li>
                    </ul>
                </div>
                <div class="right hide-on-med-and-up">
                    <label> Page
                        <select id="page_index" onchange="location = this.value">
                            @for ($page = 1; $page <= $admissionDecisions->lastPage(); $page++)
                            <option value="@getLink(page,admissionDecisions,$page)" {{$admissionDecisions->currentPage() == $page ? 'selected' : ''}}>{{$page}}</option>
                            @endfor
                        </select>
                    </label> of <span>{{$admissionDecisions->lastPage()}}</span>
                    <div class="btn-group">
                        <a class="btn-small{{$admissionDecisions->currentPage() <= 1 ? ' disabled' : ''}}" href="@getLink(page,admissionDecisions,$admissionDecisions->currentPage()-1)"><i class="mdi mdi-chevron-left"></i></a>
                        <a class="btn-small{{$admissionDecisions->currentPage() >= $admissionDecisions->lastPage() ? ' disabled' : ''}}" href="@getLink(page,admissionDecisions,$admissionDecisions->currentPage()+1)"><i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <a class="btn-small" href="/admin/admissionDecisions/create">Create</a>
    </div>
    <style>
        #searchbar_toggle_menu { display: inline-flex!important }
    </style>
</div>
<script>
    initPage()
</script>
@endsection