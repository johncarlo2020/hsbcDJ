<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wardah</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body class="welcome main main-bg">
<style>
            .main-bg {
                background-image: url('{{ asset('/images/main-bg.png') }}');
            }

            .congrats {
                text-align: center;
                width: 100%;
                margin: 53% auto 0;
            }
            .tag-line {
                    font-size: 16px;
                    line-height: 20px;
                    font-weight: 400;
                    color: #3c727a;
                    letter-spacing: 1px;
                }
            .visit{
                bottom:10%;
                margin: 53% auto 0;
                text-align: center;
                font-size: 12px;
                    line-height: 20px;
                    font-weight: 400;
                    color: #3c727a;
                    letter-spacing: 1px;
            }
        </style>
    <div class="branding-container">
        
    </div>

    <div class="congrats" >
        <div class="branding " >
            <img class="logo " src="{{ asset('images/logo-large.png') }}" alt="">
        </div>
        <p class="tag-line  mt-5">CONGRATULATIONS <br> YOU HAVE COMPLETED <br> YOUR JOURNEY</p>
        <footer>
            <div class="visit">
            <p class="  mt-5">Visit our official website</p>
            <a href="https://wardahbeauty.com/">CLick Here for more information</a>
            </div>
      
        </footer>
    </div>
</body>
</html>
