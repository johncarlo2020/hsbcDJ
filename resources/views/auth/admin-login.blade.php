<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wardah</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="main admin-login">

    <div class="contaniner wrapper d-flex justify-container-center">
        <div class="branding-container">
            @include('components.branding')
        </div>
         <div class="p-4 mx-auto bg-white border rounded shadow-sm form-container">
            <h1 class="mb-4">Welcome!</h1>
            <h2>Sign in to</h2>
            <p class="mb-4">Warda Admin Panel</p>
            <form method="POST" action="{{ route('authenticateAdmin') }}">
                @csrf
                <div class="mb-4">
                  <label for="exampleInputEmail1" class="form-label">Email</label>
                  <input placeholder="Enter your email" type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-4">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input placeholder="Enter your password" type="password" name="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-4 form-check remember">
                  <input type="checkbox" class="form-check-input" id="remember">
                  <label class="form-check-label" for="exampleCheck1">Remember me</label>
                </div>
                <button type="submit" class="btn button">Login</button>
              </form>
         </div>
         <p class="copy-text">Wowsome © Copyright 2024</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
