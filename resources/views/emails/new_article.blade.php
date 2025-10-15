<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel article - InfoflashSport</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Lora', serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .email-container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
            border: 1px solid #e0e0e0;
        }

        .email-header {
            position: relative;
            text-align: center;
            color: #fff;
        }

        .logo {
            margin: 20px auto;
            text-align: center;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        .email-header img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .email-header h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            background: rgba(0,0,0,0.5);
            padding: 15px 30px;
            border-radius: 10px;
            color: #fff;
        }

        .email-body {
            padding: 30px 25px;
        }

        .email-body h2 {
            font-size: 26px;
            color: #222;
            margin-top: 0;
        }

        .email-body p {
            font-size: 16px;
            line-height: 1.7;
            color: #555;
        }

        .btn-read {
            display: inline-block;
            background: linear-gradient(90deg, #ff7e5f, #feb47b);
            color: #fff !important;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            margin-top: 20px;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .btn-read:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }

        .email-footer {
            background-color: #f9f9fa;
            text-align: center;
            padding: 25px;
            font-size: 14px;
            color: #888;
        }

        .email-footer p {
            margin: 5px 0 0 0;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 20px 15px;
            }

            .email-header h1 {
                font-size: 24px;
                padding: 10px 20px;
            }

            .email-body h2 {
                font-size: 22px;
            }

            .btn-read {
                padding: 12px 25px;
                font-size: 16px;
            }

            .logo img {
                width: 120px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header Image -->
        @if($article->image)
        <div class="email-header">
             <img src="{{ url($article->image) }}" alt="{{ $article->title }}">
 </div>
        @endif

        <div class="email-body">
            <h2>{{ $article->title }}</h2>
            <p>{!! Str::limit(strip_tags($article->content), 300, '...') !!}</p>

            <a class="btn-read" href="{{ match($type) {
                'mercato' => route('articles.show', $article->id),
                'celebrite' => route('articles.show.celebrite', $article->id),
                'omnisport' => route('articles.show.omnisport', $article->id),
                'wags' => route('articles.show.wags', $article->id),
                'actusport' => route('actuafrique.detail', $article->id),
                default => '#'
            } }}">
                Lire l'article
            </a>
        </div>

        <div class="email-footer">
            Merci de suivre <strong>InfoflashSport</strong> !<br>
            <p>&copy; {{ date('Y') }} Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>
