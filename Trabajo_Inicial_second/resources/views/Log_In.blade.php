<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First Work</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{route('index')}}">First Work</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">Register</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('login')}}">Log In</a>
                </li>
            </ul>
        </div>
    </nav>
    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Sign In</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('LoginUser') }}">
                            @csrf
                            @method('POST')
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $errors)
                                    <li>{{$errors}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input required id="email" type="email" class="form-control" name="email" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input required id="password" type="password" class="form-control" name="password" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://www.google.com/recaptcha/api.js?render=6Lf3Z18pAAAAAMfsnV15yU3Y_8dNNcI8adaYqdcX"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('submit', function (e) {
            grecaptcha.ready(function() {
          grecaptcha.execute('6Lf3Z18pAAAAAMfsnV15yU3Y_8dNNcI8adaYqdcX', {action: 'submit'}).then(function(token) {
              let form = e.target;
              let input = document.createElement('input');
              input.type = 'hidden';
              input.name = 'g-recaptcha-response';
              input.value = token;
              form.appendChild(input);
              form.submit();
          });
        }); 
        });
    </script>
</body>

</html>