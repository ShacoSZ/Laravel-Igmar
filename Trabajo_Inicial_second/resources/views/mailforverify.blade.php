<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{$name}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{$email}}</h6>
            <p class="card-text">To log into your account you need to paste the following code <b>{{$two_factor_code}}</b> into the next page or click the button down below and insert the code.</p>
            <button href="{{route('verify')}}" class="btn btn-success">Verify</button>
        </div>
    </div>
</body>
</html>
