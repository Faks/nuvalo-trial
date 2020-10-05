<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<section class="vbox">
    <header class="bg-dark dk header navbar navbar-fixed-top-xs">
        <div class="navbar-header aside-md">
            <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
                <i class="fa fa-bars"></i>
            </a>
            <a href="https://solum-designum.eu" class="navbar-brand" data-toggle="fullscreen">Nuvalo Trial</a>
            <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                <i class="fa fa-cog"></i>
            </a>
        </div>
        <ul class="nav navbar-nav hidden-xs">
            <li>
                <div class="m-t m-l">
                    <a href="/api" class="btn btn-xs btn-primary" title="Collect Workers from  API">
                        Collect Data From API
                    </a>

                    <a href="{{ route('mass.destroy') }}" class="btn btn-xs btn-primary" title="Purge All Data">
                        Purge Data
                    </a>

                    <a href="https://bitbucket.org/Faks/nuvalo-trial/src/master/" class="btn btn-xs btn-primary" title="Source Code">
                        Bitbucket
                    </a>

                    <a href="https://www.linkedin.com/in/oskars-germovs-a94b3318a/" class="btn btn-xs btn-primary" title="Contact Me">
                        LinkedIn
                    </a>
                </div>
            </li>
        </ul>
    </header>
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            <aside class="bg-light lter b-r aside-md hidden-print" id="nav">
                <section class="vbox">
                    <header class="header bg-primary lter text-center clearfix">
                        <h4 class="center-block" style="padding-top: 5px;">Navigation</h4>
                    </header>
                    <section class="w-f scrollable">
                        <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0"
                             data-size="5px" data-color="#333333">

                            <!-- nav -->
                            <nav class="nav-primary hidden-xs">
                                <ul class="nav">

                                    <li @if (request()->segment(1) == 'filter')
                                        class="active"
                                        @endif>
                                        <a href="{{ route('filter') }}">
                                            <i class="fa fa-dashboard icon">
                                                <b class="bg-danger"></b>
                                            </i>
                                            <span>Filter 1</span>
                                        </a>
                                    </li>

                                    <li @if (request()->segment(1) == 'filter2')
                                        class="active"
                                        @endif>
                                        <a href="{{ route('filter2') }}">
                                            <i class="fa fa-dashboard icon">
                                                <b class="bg-danger"></b>
                                            </i>
                                            <span>Filter 2</span>
                                        </a>
                                    </li>

                                    <li @if (request()->segment(1) == 'filter3')
                                        class="active"
                                        @endif>
                                        <a href="{{ route('filter3') }}">
                                            <i class="fa fa-dashboard icon">
                                                <b class="bg-danger"></b>
                                            </i>
                                            <span>Filter 3</span>
                                        </a>
                                    </li>

                                </ul>
                            </nav>
                            <!-- / nav -->
                        </div>
                    </section>
                </section>
            </aside>
            <!-- /.aside -->
            <section id="content">
                <section class="vbox">
                    <section class="scrollable wrapper">
                        @yield('content')
                    </section>
                </section>
                <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
            </section>
            <aside class="bg-light lter b-l aside-md hide" id="notes">
                <div class="wrapper">Notification</div>
            </aside>
        </section>
    </section>
</section>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
