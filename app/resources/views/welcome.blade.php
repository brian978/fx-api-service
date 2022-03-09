@php ($contact = 'https://github.com/brian978')
@php ($title = env('APP_NAME'))
@php ($desc = 'REST API-ul gratuit care face super simplu procesul de extragere a cursului valutar publicat de Banca Națională a României (BNR)')

<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $desc }}">
    <meta name="robots" content="index, nofollow">
    <link rel="canonical" href="{{ url('/') }}">
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <script src="https://unpkg.com/animejs@3.0.1/lib/anime.min.js"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
</head>
<body class="is-boxed has-animations">
<div class="body-wrap">
    <header class="site-header">
        <div class="container">
            <div class="site-header-inner">
                <div class="brand header-brand">
                    <h1 class="m-0">
                        <a href="{{ url('/') }}">
                            <img class="header-logo-image" src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                        </a>
                    </h1>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-inner">
                    <div class="hero-copy">
                        <h1 class="hero-title mt-0">{{ $title }}</h1>
                        <p class="hero-paragraph">{{ $desc }}</p>
                        <div class="hero-cta">
                            <a class="button button-primary" href="{{ url('/api/docs') }}">Documentatie</a>
                            <a class="button" href="{{ $contact }}">Contact</a>
                        </div>
                    </div>
                    <div class="hero-figure anime-element">
                        <svg class="placeholder" width="528" height="396" viewBox="0 0 528 396">
                            <rect width="528" height="396" style="fill:transparent;" />
                        </svg>
                        <div class="hero-figure-box hero-figure-box-01" data-rotation="45deg"></div>
                        <div class="hero-figure-box hero-figure-box-02" data-rotation="-45deg"></div>
                        <div class="hero-figure-box hero-figure-box-03" data-rotation="0deg"></div>
                        <div class="hero-figure-box hero-figure-box-04" data-rotation="-135deg"></div>
                        <div class="hero-figure-box hero-figure-box-05"></div>
                        <div class="hero-figure-box hero-figure-box-06"></div>
                        <div class="hero-figure-box hero-figure-box-07"></div>
                        <div class="hero-figure-box hero-figure-box-08" data-rotation="-22deg"></div>
                        <div class="hero-figure-box hero-figure-box-09" data-rotation="-52deg"></div>
                        <div class="hero-figure-box hero-figure-box-10" data-rotation="-50deg"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="site-footer-inner" style="padding-bottom: 15px">
                <div class="brand footer-brand">
                    <a href="#">
                        <img class="header-logo-image" src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                    </a>
                </div>
                <ul class="footer-links list-reset">
                    <li>
                        <a href="https://github.com/brian978/fx-api-service">Github</a>
                    </li>
                    <li>
                        <a href="{{ url('api/docs') }}">Documentatie</a>
                    </li>
                    <li>
                        <a href="{{ $contact }}">Contact</a>
                    </li>
                </ul>
                <ul class="footer-social-links list-reset"></ul>
                <div class="footer-copyright">&copy; {{ now()->year }} API Services, all rights reserved</div>
            </div>
            <p style="text-align: center; font-size: 10px; padding-bottom: 10px">
                Informațiile referitoare la cotațiile valutare ale leului sunt preluate de pe site-ul Băncii Naționale a României (BNR) și au caracter pur informativ.
            </p>
        </div>
    </footer>
</div>

<script src="{{ asset('assets/js/main.min.js') }}"></script>
</body>
</html>
