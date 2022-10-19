<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="{{asset('logo/icon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('logo/icon.png')}}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <style>
        .hero{
            width: 100vw;
            height: 100vh;
            background: linear-gradient(180deg, #0084d4 0%, #02539e 100%);
            position: relative;
        }

        .img-left {
            position: absolute;
            top: 0px;
            left: 0px;
            height: 100vh;
        }

        .img-right {
            position: absolute;
            bottom: 0px;
            right: 0px;
            transform: rotate(180deg);
            height: 100vh;
        }

        .card{
            border: none;
        }

        .btn-save{
            background-color: #0084d4 !important;
        }
    </style>
    <title>DELTA</title>
</head>

<body>

    <div class="hero d-flex justify-content-center align-items-center">
        <img src="{{asset('bg_layout.svg')}}" class="img-left" />
        <img src="{{asset('bg_layout.svg')}}" class="img-right" />

        <div class="" width="400px">
            <div class="card m-3">
                <div class="card-body" style="width:320px">
                    <center>
                        <img src="{{asset('logo/logo.png')}}" width="250px" alt="">
                    </center>
                    <hr>
                    @if($errors->has('message'))
                    <div class="alert alert-danger mt-3" style="text-align: left;" role="alert">
                        {{ $errors->first('message') }}
                    </div>
                    @endif
                    <form action="{{url('login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" value="{{old("email")}}"
                                placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Passsword">
                        </div>
                        <center>
                            <button type="submit" class="btn btn-primary btn-save">Login</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function () {
            $('.btn-save').click(function () {
                $.blockUI({
                    message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Mohon Tunggu...</p> <div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                    css: {
                        backgroundColor: 'transparent',
                        color: '#fff',
                        border: '0'
                    },
                    overlayCSS: {
                        opacity: 0.5
                    },
                    timeout: 1000,
                    baseZ: 2000
                });
            });
        });

    </script>
</body>

</html>
