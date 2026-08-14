<?php
// Always return the correct HTTP status for a missing page.
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="robots" content="noindex, nofollow">

    <title>Page Not Found | Concrete Arts India</title>

    <meta name="description" content="The page you are looking for could not be found on Concrete Arts India.">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f7f7f7;
            color: #222;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .error-page {
            width: 100%;
            max-width: 760px;
            text-align: center;
            background: #ffffff;
            padding: 60px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        }

        .error-code {
            font-size: clamp(80px, 15vw, 160px);
            line-height: 1;
            font-weight: 800;
            color: #222;
            letter-spacing: -8px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: clamp(28px, 5vw, 42px);
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .message {
            max-width: 560px;
            margin: 0 auto 30px;
            color: #666;
            font-size: 17px;
            line-height: 1.7;
        }

        .home-button {
            display: inline-block;
            background: #B8864A;
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: opacity 0.2s ease;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 50px;
        }

        .home-button:hover {
            opacity: 0.85;
        }

        .brand {
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }

        @media (max-width: 600px) {
            .error-page {
                padding: 45px 25px;
            }

            .error-code {
                letter-spacing: -4px;
            }

            .message {
                font-size: 15px;
            }

            .home-button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <main class="error-page">

        <div class="error-code">404</div>

        <h1>Page Not Found</h1>

        <p class="message">
            Sorry, the page you are looking for doesn't exist or may have been
            moved to another location.
        </p>

        <a href="/" class="home-button">
            Back to Homepage
        </a>

        <div class="brand">
            Concrete Arts India
        </div>

    </main>

</body>

</html>