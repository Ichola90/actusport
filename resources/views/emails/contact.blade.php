<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Lora', sans-serif !important;
        }

        .contact-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 600px;
            margin: 50px auto;
        }

        h1 {
            color: #7ed957;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
        }

        .info-value {
            color: #212529;
            font-size: 1rem;
        }

        hr {
            border-top: 2px solid #7ed957;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #6c757d;
        }
    </style>
</head>

<body>

    <div class="contact-card">
        <h1>Nouveau message de contact</h1>

        <p><span class="info-label">Nom :</span> <span class="info-value">{{ $data['name'] }}</span></p>
        <p><span class="info-label">Email :</span> <span class="info-value">{{ $data['email'] }}</span></p>

        <hr>

        <p><span class="info-label">Message :</span></p>
        <p class="info-value">{{ $data['message'] }}</p>

        <hr>

        <p>Merci, <br><strong>L’équipe Infoflashsport</strong></p>
    </div>

    <footer>
        &copy; 2025 InfosSport. Tous droits réservés.
    </footer>

</body>

</html>