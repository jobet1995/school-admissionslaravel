<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.2.1/dist/css/materialize.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.3.95/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/air-datepicker@3.3.4/air-datepicker.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.2.1/dist/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.3.4/air-datepicker.min.js"></script>
    <script src="/js/script.js"></script>
</head>
<body>
    @if (auth()->user() && request()->is('admin/*'))
    <div class="wrapper">
        <input id="sidebar_toggle" type="checkbox" />
        <nav id="sidebar">
            <a href="/">
                <h4>Admissions</h4>
            </a>
            <ul class="collection">
                <li class="collection-item">
                    <a href="/admin/home" class="{{ Str::endsWith(request()->path(), 'home') ? 'active bg-primary' : '' }}">Home</a>
                </li>
                @foreach (auth()->user()->getMenu() as $menu)
                <li class="collection-item"><a href="/{{$menu['path']}}" class="{{ explode('/', request()->path())[1] == explode('/', $menu['path'])[1] ? 'active bg-primary' : '' }}">{{$menu['title']}}</a></li>
                @endforeach
            </ul>
        </nav>
        <div id="body">
            <nav>
                <div class="nav-wrapper">
                    <label for="sidebar_toggle" class=" btn-small"><i class="mdi mdi-menu"></i></label>
                    <ul class="right">
                        <li id="searchbar_toggle_menu" class="hide">
                            <a class="nav-link text-secondary" href="#"><label for="searchbar_toggle" class="hide-on-large-only"><i class="mdi mdi-magnify"></i></label></a>
                        </li>
                        <li>
                            <a class="dropdown" data-target="dropdown-menu" href="#"><i class="mdi mdi-account"></i> <span class="hide-on-med-and-down"> {{ auth()->user()->name }}</span></a>
                        </li>
                    </ul>
                    <ul id="dropdown-menu" class="dropdown-content">
                        <li><a href="/admin/profile" class="dropdown-item"><i class="mdi mdi-account"></i> Profile</a></li>
                        <li><a href="/admin/logout" class="dropdown-item"><i class="mdi mdi-exit-to-app"></i> Logout</a></li>
                    </ul>
                </div>
            </nav>
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
    @else
    @yield('content')
    @endif
</body>
</html>