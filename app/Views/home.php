<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laundry App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
        }

        .hero{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .card-home{
            border:none;
            border-radius:20px;
            padding:50px;
            box-shadow:0 5px 20px rgba(0,0,0,0.1);
            background:white;
            text-align:center;
        }

        .title{
            font-size:45px;
            font-weight:bold;
        }

        .desc{
            color:gray;
        }
    </style>
</head>
<body>

<div class="container hero">

    <div class="card-home">

        <h1 class="title">🧺 Laundry Booking App</h1>

        <p class="desc mt-3 mb-4">
            Sistem Booking Laundry Berbasis CodeIgniter 4
        </p>

        <a href="/login" class="btn btn-primary btn-lg me-2">
            Login
        </a>

        <a href="/register" class="btn btn-success btn-lg">
            Register
        </a>

    </div>

</div>

</body>
</html>