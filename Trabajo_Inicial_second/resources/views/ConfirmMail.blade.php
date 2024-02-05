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
            <p>Click the link down below for verify your email, have a nice day!! <3</p>
            <a href="{{$url}}">Verify Mail</a>
        </div>
    </div>
</body>
</html>
