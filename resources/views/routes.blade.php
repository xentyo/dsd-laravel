<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>
    <title>Routes</title>
</head>
<body>
    <div class="container">
        <h1>Routes</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>HTTP Method</th>
                    <th>Route</th>
                    <th>Corresponding Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($routeCollection as $route)
                <tr>
                    <td>{{$route->getMethods()}}</td>
                    <td>{{$route->getPath()}}</td>
                    <td>{{$route->getActionName()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>