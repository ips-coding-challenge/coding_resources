<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/admin/vendor/all.css') }}">
    <link href="{{ mix('css/admin/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="/">Login</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>


        @include('admin.sidebar')

        <div class="mainContainer">

            @yield('content')

        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/admin/vendor/all.js')}}"></script>
    <script src="{{ mix('js/admin/app.js') }}"></script>

    <script>

        // let categories = [];
        // axios.get('/api/categories').then(response => {
        //     response.data.data.forEach(item => {
        //         categories.push(item.nam);
        //     })
        // }).catch(err => {
        //     console.log(`Error while fetching categories`, err);
        // })
        // axios.get('/api/categories').then(response => {

        //     const newList = [];
        //     response.data.data.forEach(function (item) {
        //         newList.push(item.name)
        //     });

        //     new Awesomplete(document.querySelector('#categories'), {
        //         list: newList,
        //         filter: function (text, input) {
        //             return Awesomplete.FILTER_CONTAINS(text, input.match(/[^,]*$/)[0]);
        //         },

        //         item: function (text, input) {
        //             return Awesomplete.ITEM(text, input.match(/[^,]*$/)[0]);
        //         },

        //         replace: function (text) {
        //             var before = this.input.value.match(/^.+,\s*|/)[0];
        //             this.input.value = before + text + ", ";
        //         }
        //     });
        // }).catch(error => console.log("Error category", error))

    </script>
</body>

</html>