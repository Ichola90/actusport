<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>infoflashsports | connexion</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        * {
            font-family: 'Lora' serif;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background-color: #f5f4f3;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .p-muted {
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        i {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-90%);
            cursor: pointer;
            color: #111111;
            font-size: 18px;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo img {
            height: 100px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            font-size: 22px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            margin-top: 15px;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #4798f5;
            border-radius: 20px;
            font-size: 18px;

        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .options label {
            display: flex;
            align-items: center;
            font-weight: normal;
        }

        .options input[type="checkbox"] {
            margin-right: 6px;
            accent-color: #4798f5;
            /* vert foncé */
        }

        .options a {
            color: #4798f5;
            text-decoration: none;
        }

        .options a:hover {
            text-decoration: underline;
        }

        button {
            width: 100%;
            background-color: #7ed957;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 20px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        button:hover {
            background-color: #e25822;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 20px 15px;
                width: 90%;
            }

            .options {
                font-size: 12px;
            }

            .title {
                font-size: 16px;
            }

            .p-muted {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Logo -->
        <div class="logo" style="display: flex; justify-content: center; align-items: center; font-size: 22px;">
            <img src="{{ asset('assets/img/logo/logoif.png') }}" alt="">
        </div>

        <!-- Titre -->
        <div class="title" style="font-family: Lora; font-weight: bold; font-size: 26px; color: #e25822;">Connectez-vous avec</div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('login') }}" class="mt-4">
            @csrf

            <label for="email" style="font-family: lora;">Votre adresse e-mail</label>
            <input type="email" id="email" name="email" required id="email" autocomplete="on"
                placeholder="{{ old('email') }}">

            <label for="password" style="font-family: lora;">Votre mot de passe</label>
            <div style="position: relative;">
                <input type="password" id="password" name="password" required autocomplete="current-password">
                <i class="fa fa-eye-slash" id="togglePassword"> </i>
            </div>
            <div class="options">
                <label><input type="checkbox" name="remember"> Se souvenir de moi</label>
                <a href="">Mot de passe oublié ?</a>
            </div>

            <button type="submit">Connexion</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "timeOut": "3000",
                "extendedTimeOut": "1000"
            };
            @if(session('success'))
            toastr.success("{{ session('success') }}");
            @endif
            @if(session('error'))
            toastr.error("{{ session('error') }}");
            @endif
            @if(session('warning'))
            toastr.warning("{{ session('warning') }}");
            @endif
            @if(session('info'))
            toastr.info("{{ session('info') }}");
            @endif
        });
        $('#togglePassword').on('click', function() {
            const pwd = $('#password');
            const type = pwd.attr('type') === 'password' ? 'text' : 'password';
            pwd.attr('type', type);

            // Affiche uniquement l'œil (fa-eye) quand le mot de passe est visible
            if (type === 'text') {
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });


        // function blockAccess(event) {
        // if (event.keyCode === 123 || (event.ctrlkey && event.shftkey && event.keyCode == 73)) {
        // event.preventDefault();
        // }
        // }
        // document.addEventListener('keydown', blockAccess);
        // document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
</body>

</html>