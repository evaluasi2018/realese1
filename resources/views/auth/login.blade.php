<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SI Evaluasi | Login</title>
        <link rel="icon" type="image/png" href="{{ asset('assets/images/unib.png') }}">
        <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

        <link rel="stylesheet" href="{{asset('assets/login/style.css')}}">
    </head>
    <body>
        <div class="loginBox">
            
            <img src="{{asset('assets/login/unib.png')}}" class="user">
            @if (session()->has('notif'))
                <div class="row" id="notif" fadeIn>
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Peringatan</strong> {{ session()->get('notif') }}
                    </div>
                </div>
                @else
                    <h2 id="silahkan" style="text-transform: uppercase; display: ;" >Silahkan Login Disini</h2>

            @endif
                <form action="{{ route('panda.login') }}" method="POST">
                @csrf
                <p>Username</p>
                <input type="text" name="username" class="{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="Masukan Username">
                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                <p>Password</p>
                <input type="password" name="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Masukan Password">
                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                <input type="submit" name="" value="Login">
                <a href="#">Lupa Password</a>
            </form>
        </div>
    </body>
    <script>
        $(function(){
          
            $("#silahkan").fadeIn(1000);
            $("#notif").fadeOut(1000);
          
        });
    </script>
</html>
