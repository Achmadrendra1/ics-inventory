<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body onload="window.print()">
<div class="container">
        <img src="{{ URL::to('assets/img/logo.png') }}" alt="Logo" height="120"/>
        <center><h1>@yield('title') Report</h1></center>
        <center>
            <h4>Period Date :
                {{ Request::get('filter_tgl1') }}
                 s/d 
                {{ Request::get('filter_tgl2') }}
            </h4>
        </center>
        <br><br>
        @yield('content')
	</div>
</body>
</html>