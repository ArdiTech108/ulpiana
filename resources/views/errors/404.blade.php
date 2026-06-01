<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Faqja nuk u gjet | Gjimnazi "Ulpiana"</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="style.css">
    <style>
        .error-page {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        .error-content {
            z-index: 10;
            max-width: 600px;
        }
        .error-code {
            font-size: 10rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-family: var(--font-heading);
            filter: drop-shadow(0 10px 20px rgba(59, 130, 246, 0.3));
        }
        .error-title {
            font-size: 2rem;
            color: white;
            margin-bottom: 15px;
        }
        .error-desc {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        .blob-404 {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, transparent 70%);
            filter: blur(50px);
            z-index: 1;
            animation: float 10s infinite alternate;
        }
        @keyframes float {
            from { transform: translate(-10%, -10%); }
            to { transform: translate(10%, 10%); }
        }
    </style>
</head>
<body>
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="bg-elements">
        <div class="blob-404"></div>
        <div class="noise-overlay"></div>
    </div>

    <main class="error-page">
        <div class="error-content">
            <h1 class="error-code">404</h1>
            <h2 class="error-title">Ups! Faqja nuk u gjet.</h2>
            <p class="error-desc">Faqja që po kërkoni mund të jetë zhvendosur, fshirë ose nuk ka ekzistuar kurrë.</p>
            <a href="index.html" class="btn btn-primary">
                <i class="fa-solid fa-house"></i> Kthehu te Ballina
            </a>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>
