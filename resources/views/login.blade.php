<!DOCTYPE html>
<html lang="">
    <head>
        <!-- Meta tags, title, etc. -->

        <!-- Fonts -->
        <!-- CSS imports -->

        <!-- Custom Styles -->
        <style type="text/css">
            .bt-icons i {
                font-size: 30px;
            }
        </style>
    </head>
    <body>
    <div class="container"><br>
        <div class="col-md-4 col-md-offset-4">
            <h2 class="text-center">Login Aplikasi</h3>
            <hr>
            @if(session('error'))
            <div class="alert alert-danger">
                <b>Opps!</b> {{session('error')}}
            </div>
            @endif
            <form action="{{ route('actionlogin') }}" method="post">
            @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="username" name="username" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Log In</button>
                <hr>
                 
            </form>
        </div>
    </div>
</body>
</html>

 