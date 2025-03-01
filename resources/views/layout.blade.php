<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('lib/prism.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/dropify.css')}}" />

    <style>
        .img-left {
            position: absolute;
            top: 0px;
            left: 0px;
            height: 100vh;
            opacity: 0.5;
        }

        .card-shadow{
            border: none !important;
            filter: drop-shadow(2px 4px 20px rgba(2, 83, 158, 0.2));
        }

        nav{
            filter: drop-shadow(2px 4px 20px rgba(2, 83, 158, 0.2)) !important;
        }
    </style>

    <title>DELTA</title>

    @stack('style')
</head>

<body>
    <img src="{{asset('bg_layout.svg')}}" class="img-left" />

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{asset('logo/logo.png')}}" class="" width="100px" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('dashboard')}}">Tugas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('presence')}}">Presensi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('profile')}}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="{{url('logout')}}" onclick="return confirm('Are you sure to logout?');">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('lib/prism.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>
    <script src="{{asset('js/jquery.blockUI.js')}}"></script>


    @stack('script')
</body>

</html>
