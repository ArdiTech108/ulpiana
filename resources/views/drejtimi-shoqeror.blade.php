<!DOCTYPE html>
<html lang="sq">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drejtimi Shoqëror | Gjimnazi "Ulpiana"</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/logo.png">
    <link rel="manifest" href="site.webmanifest">

    <link rel="stylesheet" href="style.css">
    <style>
        .curriculum-section {
            padding: 120px 0 60px;
            min-height: 100vh;
            position: relative;
            z-index: 2;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 40px;
            transition: color 0.3s;
        }

        .back-btn:hover {
            color: var(--primary);
        }

        .years-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .year-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .year-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .year-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .year-num {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #10b981, #059669);
            /* Green accent for social sciences */
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .year-title {
            font-size: 1.4rem;
            color: white;
            font-weight: 600;
        }

        .subjects-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .subjects-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-secondary);
            font-size: 1.05rem;
        }

        .subjects-list li i {
            color: #10b981;
            font-size: 0.8rem;
        }

        .accent-subject {
            color: white !important;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- Custom Cursor -->
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="bg-elements">
        <div class="blob blob-1"></div>
        <div class="blob blob-2" style="background:var(--accent)"></div>
        <div class="noise-overlay"></div>
    </div>

    <section class="curriculum-section">
        <div class="container">
            <a href="index.html" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Kthehu tek Ballina</a>

            <div class="section-header">
                <h5 class="section-subtitle" style="color: #10b981;">KURRIKULA AKADEMIKE</h5>
                <h2 class="section-title">Drejtimi <span class="gradient-text"
                        style="background: linear-gradient(to right, #34d399, #059669); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Shoqëror</span>
                </h2>
                <p class="section-desc" style="max-width: 800px;">Ky drejtim fokusohet në thellimin e njohurive në
                    shkencat humane, filologjike dhe atyre shoqërore. Është baza ideale për të vazhduar studimet në
                    drejtësi, gazetari, diplomaci, psikologji apo art.</p>
            </div>

            <div class="years-grid">
                <!-- Viti 1 -->
                <div class="year-card">
                    <div class="year-header">
                        <div class="year-num">1</div>
                        <h3 class="year-title">Viti i Parë (Klasa 10)</h3>
                    </div>
                    <ul class="subjects-list">
                        <li class="accent-subject"><i class="fa-solid fa-book"></i> Gjuhë Shqipe dhe Letërsi</li>
                        <li class="accent-subject"><i class="fa-solid fa-monument"></i> Histori</li>
                        <li class="accent-subject"><i class="fa-solid fa-earth-americas"></i> Gjeografi</li>
                        <li class="accent-subject"><i class="fa-solid fa-language"></i> Gjuhë Angleze</li>
                        <li class="accent-subject"><i class="fa-solid fa-language"></i> Gjuhë e dytë e huaj</li>
                        <li><i class="fa-solid fa-square-root-variable"></i> Matematikë</li>
                        <li><i class="fa-solid fa-flask"></i> Kimi</li>
                        <li><i class="fa-solid fa-atom"></i> Fizikë</li>
                        <li><i class="fa-solid fa-dna"></i> Biologji</li>
                        <li><i class="fa-solid fa-desktop"></i> T.I.K</li>
                        <li><i class="fa-solid fa-music"></i> Art Muzikor</li>
                        <li><i class="fa-solid fa-palette"></i> Art Figurativ</li>
                        <li><i class="fa-solid fa-volleyball"></i> Edukatë Fizike</li>
                    </ul>
                </div>

                <!-- Viti 2 -->
                <div class="year-card">
                    <div class="year-header">
                        <div class="year-num">2</div>
                        <h3 class="year-title">Viti i Dytë (Klasa 11)</h3>
                    </div>
                    <ul class="subjects-list">
                        <li class="accent-subject"><i class="fa-solid fa-book"></i> Gjuhë Shqipe dhe Letërsi</li>
                        <li class="accent-subject"><i class="fa-solid fa-monument"></i> Histori</li>
                        <li class="accent-subject"><i class="fa-solid fa-earth-americas"></i> Gjeografi</li>
                        <li class="accent-subject"><i class="fa-solid fa-brain"></i> Psikologji</li>
                        <li class="accent-subject"><i class="fa-solid fa-people-group"></i> Sociologji</li>
                        <li><i class="fa-solid fa-language"></i> Gjuhë Angleze</li>
                        <li><i class="fa-solid fa-language"></i> Gjuhë e dytë e huaj</li>
                        <li><i class="fa-solid fa-square-root-variable"></i> Matematikë</li>
                        <li><i class="fa-solid fa-volleyball"></i> Edukatë Fizike</li>
                        <li><i class="fa-solid fa-desktop"></i> T.I.K</li>
                        <li><i class="fa-solid fa-music"></i> Art Muzikor</li>
                        <li><i class="fa-solid fa-palette"></i> Art Figurativ</li>
                    </ul>
                </div>

                <!-- Viti 3 -->
                <div class="year-card">
                    <div class="year-header">
                        <div class="year-num">3</div>
                        <h3 class="year-title">Viti i Tretë (Klasa 12)</h3>
                    </div>
                    <ul class="subjects-list">
                        <li class="accent-subject"><i class="fa-solid fa-book"></i> Gjuhë Shqipe (Letërsi e thelluar)
                        </li>
                        <li class="accent-subject"><i class="fa-solid fa-monument"></i> Histori Kombëtare dhe Botërore
                        </li>
                        <li class="accent-subject"><i class="fa-solid fa-lightbulb"></i> Filozofi</li>
                        <li class="accent-subject"><i class="fa-solid fa-puzzle-piece"></i> Logjikë</li>
                        <li class="accent-subject"><i class="fa-solid fa-scale-balanced"></i> Edukatë Qytetare /
                            Drejtësi</li>
                        <li><i class="fa-solid fa-earth-americas"></i> Gjeografi Ekonomike</li>
                        <li><i class="fa-solid fa-language"></i> Gjuhë Angleze</li>
                        <li><i class="fa-solid fa-volleyball"></i> Edukatë Fizike</li>
                        <li><i class="fa-solid fa-asterisk"></i> Modul Zgjedhor Sipas Profilit</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Professional Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-info">
                    <div class="brand">
                        <img src="assets/logo.png"
                            alt="Logo" style="width: 50px; height: 50px; object-fit: contain; border-radius: 5px;">
                        <span class="title">Gjimnazi <strong>Ulpiana</strong></span>
                    </div>
                    <p class="footer-desc">Ekselencë në edukim që nga viti 1968. Përgatisim liderët e së ardhmes me
                        standardet më të larta akademike.</p>
                </div>

                <div class="footer-links">
                    <h4>Linqe të Shpejta</h4>
                    <ul>
                        <li><a href="index.html#ballina">Ballina</a></li>
                        <li><a href="index.html#drejtimet">Drejtimet</a></li>
                        <li><a href="index.html#takimet">Takimet</a></li>
                    </ul>
                </div>

                <div class="footer-contact">
                    <h4>Kontakti</h4>
                    <ul>
                        <li><i class="fa-solid fa-location-dot"></i> Lipjan, 14000</li>
                        <li><i class="fa-solid fa-envelope"></i> info@gjimnazi-ulpiana.edu</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 Gjimnazi "Ulpiana".</p>
                <div class="footer-bottom-links">
                    <a href="privatesia.html">Privatësia</a>
                    <a href="kushtet.html">Kushtet</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Custom Cursor Logic
        const cursorDot = document.querySelector('.cursor-dot');
        const cursorOutline = document.querySelector('.cursor-outline');

        if (window.innerWidth > 768 && cursorDot && cursorOutline) {
            window.addEventListener('mousemove', (e) => {
                const posX = e.clientX;
                const posY = e.clientY;

                cursorDot.style.left = `${posX}px`;
                cursorDot.style.top = `${posY}px`;

                cursorOutline.animate({
                    left: `${posX}px`,
                    top: `${posY}px`
                }, { duration: 150, fill: "forwards" });
            });

            const hoverElements = document.querySelectorAll('a, button, .year-card');
            hoverElements.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cursorOutline.style.width = '60px';
                    cursorOutline.style.height = '60px';
                    cursorOutline.style.backgroundColor = 'rgba(16, 185, 129, 0.1)';
                });
                el.addEventListener('mouseleave', () => {
                    cursorOutline.style.width = '40px';
                    cursorOutline.style.height = '40px';
                    cursorOutline.style.backgroundColor = 'transparent';
                });
            });
        }
    </script>
</body>

</html>
