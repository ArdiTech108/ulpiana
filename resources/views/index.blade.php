<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gjimnazi "Ulpiana" Lipjan</title>
    
    <!-- Meta SEO & Open Graph -->
    <meta name="description" content="Gjimnazi 'Ulpiana' në Lipjan - Qendra e ekselencës akademike. Platforma zyrtare për informacione, regjistrime dhe takime.">
    <meta property="og:title" content="Gjimnazi 'Ulpiana' | Platforma Zyrtare">
    <meta name="description" content="Mirësevini në platformën zyrtare të Gjimnazit 'Ulpiana' në Lipjan. Rezervoni takime me profesorët, ndiqni suksesin akademik dhe informohuni me lajmet e fundit.">
    <meta name="keywords" content="Gjimnazi Ulpiana, Lipjan, shkollë e mesme, arsim, Kosovë, nxënës, prindër, takime online">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://ulpiana.edu/">
    <meta property="og:title" content="Gjimnazi 'Ulpiana' - Lipjan">
    <meta property="og:description" content="Platforma moderne për menaxhimin e suksesit akademik dhe komunikimit Prind-Shkollë.">
    <meta property="og:image" content="assets/shkolla.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="Gjimnazi 'Ulpiana' - Lipjan">
    <meta property="twitter:description" content="Platforma moderne për menaxhimin e suksesit akademik.">
    <meta property="twitter:image" content="assets/shkolla.png">
    <meta name="theme-color" content="#030712">
    <link rel="icon" type="image/png" href="assets/logo.png">
    <link rel="apple-touch-icon" href="assets/logo.png">
    <link rel="manifest" href="site.webmanifest">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "HighSchool",
      "name": "Gjimnazi Ulpiana",
      "url": "https://gjimnaziulpiana.edu/",
      "logo": "https://gjimnaziulpiana.edu/assets/logo.png",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Rr. Skenderbeu",
        "addressLocality": "Lipjan",
        "postalCode": "14000",
        "addressCountry": "XK"
      },
      "email": "info@gjimnazi-ulpiana.edu",
      "telephone": "+38344123456"
    }
    </script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Custom Cursor -->
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <!-- Scroll Progress Bar -->
    <div id="scrollProgressBar"></div>

    <!-- Page Transition Overlay -->
    <div id="pageTransition" class="page-transition"></div>

    <!-- Background Elements -->
    <div class="bg-elements">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="noise-overlay"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#ballina" class="brand">
                <div class="brand-icon" style="background: transparent; box-shadow: none;">
                    <img src="assets/logo.png" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 5px;">
                </div>
                <div class="brand-text">
                    <span class="title">Gjimnazi <strong>Ulpiana</strong></span>
                    <span class="subtitle">Shkolla e Mesme e Lartë</span>
                </div>
            </a>
            
            <div class="nav-links">
              <a href="#ballina" class="nav-link active">Ballina</a> 
              <a href="#statistikat" class="nav-link">Statistikat</a> 
                <a href="#historia" class="nav-link">Historia</a>
                <a href="#drejtimet" class="nav-link">Drejtimet</a>
                <a href="#regjistrimi" class="nav-link">Regjistrimi</a>
                <a href="#takimet" class="nav-link">Takimet</a>
                <a href="#galeria" class="nav-link">Galeria</a>
                <a href="#lajmet" class="nav-link">Lajmet</a>
                <a href="#announcements" class="nav-link">Njoftime</a>
                <a href="#safeguarding" class="nav-link">Raporto</a>
                <a href="#burimet" class="nav-link">Burime</a>
                <a href="#kontakti" class="nav-link">Kontakti</a>
            </div>

            <div class="nav-actions">
                <button id="navAuthBtn" class="btn btn-login" onclick="handleAuthAction()">
                    <i class="fa-regular fa-user"></i> <span id="navAuthText">Kyçu në Sistem</span>
                </button>
                <div class="hamburger" id="hamburger">
                    <div class="bar"></div>
                    <div class="bar"></div>
                    <div class="bar"></div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Pulse News Ticker -->
    <div class="pulse-ticker-wrap">
        <div class="pulse-label">Lajmet e Fundit:</div>
        <div class="pulse-ticker">
            <div class="ticker-content">
                <span><i class="fa-solid fa-star"></i> Urime! Gjimnazi Ulpiana fiton çmimin e parë në garat kombëtare të Debatit.</span>
                <span><i class="fa-solid fa-calendar"></i> Regjistrimet për vitin akademik 2026/27 fillojnë së shpejti - Qershor 2026.</span>
                <span><i class="fa-solid fa-microscope"></i> Hapen laboratorët e rinj të Kimisë dhe Biologjisë - Teknologjia e fundit në shërbim të dijes.</span>
                <span><i class="fa-solid fa-users"></i> Takimi i radhës me Këshillin e Prindërve: E Premte, ora 14:00.</span>
            </div>
        </div>
    </div>


    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#ballina" class="mobile-link">Ballina</a>
         <a href="#statistikat" class="mobile-link">Statistikat</a>
        <a href="#historia" class="mobile-link">Historia</a>
        <a href="#drejtimet" class="mobile-link">Drejtimet</a>
        <a href="#regjistrimi" class="mobile-link">Regjistrimi</a>
        <a href="#takimet" class="mobile-link">Takimet</a>
        <a href="#galeria" class="mobile-link">Galeria</a>
         <a href="#lajmet" class="mobile-link">Lajmet</a>
         <a href="#announcements" class="mobile-link">Njoftime</a>
         <a href="#safeguarding" class="mobile-link">Raporto</a>
         <a href="#burimet" class="mobile-link">Burime</a>
         <a href="#kontakti" class="mobile-link">Kontakti</a>
        <button id="mobileAuthBtn" class="btn btn-primary w-100 mt-4" onclick="handleAuthAction()">Kyçu / Regjistrohu</button>
    </div>

    <main>
        <!-- Hero Section -->
        <section id="ballina" class="hero">
            <div class="hero-container">
                <div class="hero-content">
                    <div class="badge fade-up">
                        <span class="pulse-dot"></span> Prezantim Zyrtar Konferenca 2026
                    </div>
                    <h1 class="hero-title fade-up delay-1">
                        Edukimi që ndriçon <br>
                        <span class="gradient-text">Të Ardhmen</span>
                    </h1>
                    <p class="hero-desc fade-up delay-2">
                        Gjimnazi "Ulpiana" në Lipjan është një qendër e ekselencës akademike, duke përgatitur liderët e së nesërmes që nga viti 1968 përmes inovacionit dhe traditës.
                    </p>
                    <div class="hero-btns fade-up delay-3">
                        <a href="#drejtimet" class="btn btn-primary btn-glow">
                            <span>Eksploro Drejtimet</span> <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <button class="btn btn-glass" onclick="openVideoModal('A5lTjgopzxQ')">
                            <i class="fa-solid fa-play"></i> Shiko Prezantimin
                        </button>
                    </div>
                </div>
                
                <div class="hero-visual fade-up delay-4">
                    <div class="hero-image-wrapper">
                        <img src="assets/shkolla.png" alt="Gjimnazi Ulpiana" class="hero-img">
                        <div class="img-overlay"></div>
                        <!-- Verified Platform Badge -->
                        <div class="verified-badge">
                            <i class="fa-solid fa-certificate"></i>
                            <span>Platformë e Verifikuar</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="scroll-indicator">
                <div class="mouse"></div>
                <span>Zbulo më shumë</span>
            </div>
        </section>

        <!-- Ulpiana Pulse Section (The Soul of the School) -->
        <section id="pulse" class="pulse-section">
            <div class="container">
                <div class="pulse-grid">
                    <div class="pulse-main reveal">
                        <div class="pulse-header">
                            <h5 class="section-subtitle">PULSI I SHKOLLËS</h5>
                            <h2 class="section-title">Energjia që lëviz <span class="gradient-text">Gjimnazin</span></h2>
                        </div>
                        <div class="pulse-news-cards">
                            <div class="news-mini-card">
                                <div class="news-date">10 MAJ</div>
                                <div class="news-body">
                                    <h4>Vizita në CERN - Gjenevë</h4>
                                    <p>Nxënësit e drejtimit natyror vizitojnë qendrën më të madhe shkencore në botë.</p>
                                </div>
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <div class="news-mini-card active">
                                <div class="news-date">SOT</div>
                                <div class="news-body">
                                    <h4>Prezantimi në Konferencën Emerald</h4>
                                    <p>Platforma jonë digjitale prezantohet si shembull i inovacionit në edukim.</p>
                                </div>
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <div class="news-mini-card">
                                <div class="news-date">05 MAJ</div>
                                <div class="news-body">
                                    <h4>Dita e Tokës - Lipjan</h4>
                                    <p>Aksioni i mbjelljes së drurëve në oborrin e shkollës nga klubi i ambientit.</p>
                                </div>
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pulse-sidebar reveal delay-2">
                        <div class="pulse-quote-card glass-panel">
                            <div class="quote-icon-top"><i class="fa-solid fa-quote-left"></i></div>
                            <p>"Nuk është vetëm një ndërtesë, është vendi ku çdo ëndërr fillon të marrë krahë."</p>
                            <div class="quote-author-mini">
                                <strong>Altina J.</strong>
                                <span>Kryetare e Këshillit të Nxënësve</span>
                            </div>
                        </div>
                        <div class="live-status-card glass-panel">
                            <div class="status-item">
                                <div class="status-info">
                                    <span>Statusi i Sistemit</span>
                                    <strong>Online & Aktiv</strong>
                                </div>
                                <div class="pulse-dot-green"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Stats Section -->
        <section id="statistikat" class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-box reveal">
                        <div class="stat-icon"><i class="fa-solid fa-calendar-days"></i></div>
                        <h2 class="counter" data-target="1968">0</h2>
                        <p>Viti i Themelimit</p>
                    </div>
                    <div class="stat-box reveal delay-1">
                        <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                        <div style="display:flex; align-items:center; justify-content:center; gap:5px;">
                            <h2 class="counter" data-target="1500">0</h2><span>+</span>
                        </div>
                        <p>Nxënës Aktivë</p>
                    </div>
                    <div class="stat-box reveal delay-2">
                        <div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                        <div style="display:flex; align-items:center; justify-content:center; gap:5px;">
                            <h2 class="counter" data-target="85">0</h2><span>+</span>
                        </div>
                        <p>Staf Akademik</p>
                    </div>
                    <div class="stat-box reveal delay-3">
                        <div class="stat-icon"><i class="fa-solid fa-award"></i></div>
                        <div style="display:flex; align-items:center; justify-content:center; gap:5px;">
                            <h2 class="counter" data-target="100">0</h2><span>%</span>
                        </div>
                        <p>Përkushtim</p>
                    </div>
                </div>
            </div>
        </section>
                    <!-- FAQ Section -->
        <section id="faq" class="faq-section">
            <div class="container">
                <div class="section-header center reveal">
                    <h5 class="section-subtitle">NDIHMË DHE INFORMACION</h5>
                    <h2 class="section-title">Pyetjet e <span class="gradient-text">Shpeshta</span></h2>
                </div>

                <div class="faq-wrapper reveal delay-1">
                    <div class="accordion">
                        <div class="accordion-item">
                            <button class="accordion-btn" aria-expanded="false">Si mund të regjistroj fëmijën tim në Gjimnazin Ulpiana? <i class="fa-solid fa-plus"></i></button>
                            <div class="accordion-content">
                                <p>Regjistrimi bëhet përmes konkursit publik të shpallur nga MASHT dhe Komuna e Lipjanit. Dokumentet e nevojshme përfshijnë dëftesat e klasave 6-9, certifikatën e lindjes dhe pikët e testit të arritshmërisë.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-btn" aria-expanded="false">Si funksionon sistemi i takimeve online? <i class="fa-solid fa-plus"></i></button>
                            <div class="accordion-content">
                                <p>Prindërit duhet të krijojnë një llogari, të zgjedhin profesorin përkatës dhe të caktojnë një nga oraret e lira. Sistemi do të dërgojë një email konfirmimi automatik.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-btn" aria-expanded="false">A mund t'i shohim notat e fëmijëve online? <i class="fa-solid fa-plus"></i></button>
                            <div class="accordion-content">
                                <p>Po, nxënësit kanë portalin e tyre ku mund të shohin notat e publikuara nga profesorët në kohë reale.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- History & Mission -->
        <section id="historia" class="about-section">
            <div class="container">
                <div class="section-header reveal">
                    <h5 class="section-subtitle">HISTORIA DHE VIZIONI</h5>
                    <h2 class="section-title">Nga tradita drejt <span class="gradient-text">Ekselencës Evropiane</span></h2>
                </div>
                
                <div class="about-content">
                    <div class="about-text reveal">
                        <p class="lead-text">Gjimnazi “Ulpiana” u themelua në vitin 1968 në Lipjan, si një vatër e dritës dhe dijes. Për më shumë se 5 dekada, kemi qenë <span class="highlight">dritarja drejt së ardhmes</span> për mijëra të rinj.</p>
                        
                        <div class="feature-list">
                            <div class="feature-item">
                                <div class="f-icon"><i class="fa-solid fa-check"></i></div>
                                <div>
                                    <h4>Standarde Bashkëkohore</h4>
                                    <p>Kurrikulë e përditësuar që nxit inovacionin dhe kreativitetin.</p>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="f-icon"><i class="fa-solid fa-check"></i></div>
                                <div>
                                    <h4>Mjedis Gjithëpërfshirës</h4>
                                    <p>Hapësira të sigurta ku çdo nxënës gjen mbështetjen e duhur.</p>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="f-icon"><i class="fa-solid fa-check"></i></div>
                                <div>
                                    <h4>Teknologji e Avancuar</h4>
                                    <p>Aplikimi i platformave digjitale në mësimdhënie dhe menaxhim.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="about-visual reveal delay-2">
                        <div class="image-grid">
                            <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=600&auto=format&fit=crop" class="img-1" alt="Historia 1">
                            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=600&auto=format&fit=crop" class="img-2" alt="Historia 2">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programs Section -->
        <section id="drejtimet" class="programs-section">
            <div class="container">
                <div class="section-header center reveal">
                    <h5 class="section-subtitle">PROGRAMET AKADEMIKE</h5>
                    <h2 class="section-title">Rrugëtimi yt <span class="gradient-text">fillon këtu</span></h2>
                    <p class="section-desc">Kemi dy drejtime kryesore të profilizuara për të zhvilluar potencialin maksimal të çdo nxënësi, duke u ofruar atyre mundësi të pakufizuara për studime universitare.</p>
                </div>
                
                <div class="programs-grid">
                    <!-- Drejtimi Natyror -->
                    <div class="program-card reveal">
                        <div class="card-bg" style="background-image: url('https://images.unsplash.com/photo-1532094349884-543bc11b234d?q=80&w=800&auto=format&fit=crop');"></div>
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <div class="icon-wrapper natyror">
                                <i class="fa-solid fa-atom"></i>
                            </div>
                            <h3>Drejtimi Natyror</h3>
                            <p>Fokusuar në shkencat e sakta. Përgatitje intensive për mjekësi, inxhinieri, teknologji informative dhe shkenca kompjuterike.</p>
                            <ul class="card-features">
                                <li><i class="fa-solid fa-angle-right"></i> Matematikë e Avancuar</li>
                                <li><i class="fa-solid fa-angle-right"></i> Laboratorë Fizike/Kimie</li>
                                <li><i class="fa-solid fa-angle-right"></i> Kurse Programimi</li>
                            </ul>
                            <a href="drejtimi-natyror.html" class="btn btn-outline-light mt-auto w-100" style="text-align: center; display: inline-block;">Lexo Kurrikulën</a>
                        </div>
                    </div>
                    
                    <!-- Drejtimi Shoqeror -->
                    <div class="program-card reveal delay-1">
                        <div class="card-bg" style="background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=800&auto=format&fit=crop');"></div>
                        <div class="card-overlay"></div>
                        <div class="card-content">
                            <div class="icon-wrapper shoqeror">
                                <i class="fa-solid fa-scale-balanced"></i>
                            </div>
                            <h3>Drejtimi Shoqëror</h3>
                            <p>Fokusuar në shkencat humane. Baza ideale për studime në drejtësi, diplomaci, psikologji, arte dhe gazetari.</p>
                            <ul class="card-features">
                                <li><i class="fa-solid fa-angle-right"></i> Filozofi dhe Sociologji</li>
                                <li><i class="fa-solid fa-angle-right"></i> Klube Debati dhe OKB</li>
                                <li><i class="fa-solid fa-angle-right"></i> Gjuhë të Huaja</li>
                            </ul>
                            <a href="drejtimi-shoqeror.html" class="btn btn-outline-light mt-auto w-100" style="text-align: center; display: inline-block;">Lexo Kurrikulën</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Regjistrimi Section -->
        <section id="regjistrimi" class="admissions-section relative">
            <div class="container">
                <div class="section-header center reveal">
                    <h5 class="section-subtitle">BËHU PJESË E JONA</h5>
                    <h2 class="section-title">Kushtet e <span class="gradient-text">Regjistrimit</span></h2>
                    <p class="section-desc">Gjithçka që ju duhet të dini për t'u bërë pjesë e Gjimnazit "Ulpiana" për vitin e ri shkollor.</p>
                </div>

                <!-- Status Banner -->
                <div class="registration-status reveal glass-panel">
                    <div class="status-indicator upcoming">
                        <span class="pulse-dot yellow"></span>
                        <strong>Statusi:</strong> Në pritje të afatit të Qershorit
                    </div>
                    <p>Konkursi zyrtar shpallet nga MASHTI. Përgatitni dokumentet me kohë!</p>
                </div>

                <div class="admissions-grid mt-5">
                    <!-- Kriteret e Pranimit -->
                    <div class="admission-card reveal delay-1 glass-panel">
                        <div class="card-header">
                            <div class="icon-box"><i class="fa-solid fa-ranking-star"></i></div>
                            <h3>Kriteret dhe Pikët</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-4 text-secondary">Pranimi bëhet përmes një formule që kalkulon suksesin e shkollës së mesme të ulët (kl. 6-9) dhe pikët e Testit të Arritshmërisë.</p>
                            
                            <div class="points-box natyror-points">
                                <h4><i class="fa-solid fa-atom"></i> Drejtimi Natyror</h4>
                                <ul>
                                    <li>Pikët minimale të synuara: <strong>65+ pikë</strong></li>
                                    <li>Lëndët Prioritare: <span>Matematikë, Fizikë, Kimi, Biologji</span></li>
                                </ul>
                            </div>
                            
                            <div class="points-box shoqeror-points">
                                <h4><i class="fa-solid fa-scale-balanced"></i> Drejtimi Shoqëror</h4>
                                <ul>
                                    <li>Pikët minimale të synuara: <strong>60+ pikë</strong></li>
                                    <li>Lëndët Prioritare: <span>Gjuhë Shqipe, Histori, Gjeografi</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumentet -->
                    <div class="admission-card reveal delay-2 glass-panel">
                        <div class="card-header">
                            <div class="icon-box"><i class="fa-solid fa-folder-open"></i></div>
                            <h3>Dokumentet e Nevojshme</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-4 text-secondary">Kandidatët duhet të sjellin dosjen e kompletuar fizikisht në shkollë gjatë ditëve të konkursit.</p>
                            
                            <ul class="docs-list">
                                <li>
                                    <div class="doc-check"><i class="fa-solid fa-check"></i></div>
                                    <div class="doc-info">
                                        <strong>Fletëparaqitja me të dhëna</strong>
                                        <span>Merret dhe plotësohet fizikisht në shkollë.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="doc-check"><i class="fa-solid fa-check"></i></div>
                                    <div class="doc-info">
                                        <strong>Dëftesat origjinale (Kl. 6-9)</strong>
                                        <span>Dëshmia e suksesit nga shkolla paraprake.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="doc-check"><i class="fa-solid fa-check"></i></div>
                                    <div class="doc-info">
                                        <strong>Certifikata e Testit të Arritshmërisë</strong>
                                        <span>Dokumenti origjinal me pikët e testit shtetëror.</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="doc-check"><i class="fa-solid fa-check"></i></div>
                                    <div class="doc-info">
                                        <strong>Certifikata e Lindjes</strong>
                                        <span>Ekstrakti ose certifikata e lindjes.</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic Booking System -->
        <section id="takimet" class="booking-section relative">
            <div class="container">
                <div class="booking-wrapper glass-panel reveal">
                    <div class="booking-info">
                        <h5 class="section-subtitle">PLATFORMA E PRINDËRVE</h5>
                        <h2 class="section-title">Rezervo takim <br>me <span class="gradient-text">Profesorët</span></h2>
                        <p class="section-desc">Një sistem inovativ që u mundëson prindërve të planifikojnë takime direkte me mësimdhënësit në oraret e tyre të lira, duke forcuar trekëndëshin <strong class="highlight">Nxënës-Prind-Shkollë</strong>.</p>
                        
                        <div class="instruction-list">
                            <div class="instruction">
                                <div class="step-num">1</div>
                                <p>Zgjidhni profesorin nga lista</p>
                            </div>
                            <div class="instruction">
                                <div class="step-num">2</div>
                                <p>Zgjidhni një term të lirë (orët e zeza)</p>
                            </div>
                            <div class="instruction">
                                <div class="step-num">3</div>
                                <p>Plotësoni të dhënat dhe konfirmoni</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="booking-app">
                        <!-- Left Panel: Teachers -->
                        <div class="teachers-panel">
                            <div class="panel-head">
                                <h3>Mësimdhënësit</h3>
                                <div class="search-box">
                                    <i class="fa-solid fa-search"></i>
                                    <input type="text" id="searchTeacher" placeholder="Emri i profesorit...">
                                </div>
                                <div class="search-box filter-box" style="margin-top: 10px;">
                                    <i class="fa-solid fa-filter"></i>
                                    <select id="filterSubject">
                                        <option value="">Të gjitha lëndët</option>
                                        <option value="Gjuhë Shqipe">Gjuhë Shqipe</option>
                                        <option value="Matematikë">Matematikë</option>
                                        <option value="Anglisht">Gjuhë Angleze</option>
                                        <option value="Fizikë">Fizikë</option>
                                        <option value="Kimi">Kimi</option>
                                        <option value="Biologji">Biologji</option>
                                        <option value="TIK">T.I.K</option>
                                        <option value="Histori">Histori</option>
                                        <option value="Gjeografi">Gjeografi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="teachers-list" id="teachersList">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                        
                        <!-- Right Panel: Calendar & Slots -->
                        <div class="calendar-panel">
                            <div class="panel-head">
                                <h3>Oraret e Lira</h3>
                                <span class="badge-date" id="currentDateBadge">Sot</span>
                            </div>
                            
                            <div class="selected-teacher-info" id="selectedTeacherInfo">
                                <div class="s-avatar"><i class="fa-solid fa-user-tie"></i></div>
                                <div>
                                    <h4 id="stName">Zgjidhni Profesorin</h4>
                                    <p id="stSubject">Për të parë oraret e rezervuara dhe të lira</p>
                                </div>
                            </div>

                            <div class="slots-grid" id="timeSlots">
                                <div class="empty-state">
                                    <i class="fa-solid fa-hand-pointer"></i>
                                    <p>Zgjidhni profesorin nga paneli i majtë</p>
                                </div>
                            </div>

                            <!-- Booking Form (Hidden initially) -->
                            <form id="bookingForm" class="hidden-form">
                                <h4>Rezervo Termin: <span id="slotToBook" class="gradient-text">--:--</span></h4>
                                <div class="form-inputs">
                                    <div class="input-group">
                                        <i class="fa-regular fa-user"></i>
                                        <input type="text" id="parentName" placeholder="Emri i Prindit" required>
                                    </div>
                                    <div class="input-group">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                        <input type="text" id="studentName" placeholder="Emri i Nxënësit" required>
                                    </div>
                                    <div class="input-group" style="grid-column: 1 / -1;">
                                        <i class="fa-regular fa-envelope"></i>
                                        <input type="email" id="parentEmail" placeholder="Email Adresa e Prindit" required>
                                    </div>
                                    <div class="input-group" style="grid-column: 1 / -1;">
                                        <i class="fa-regular fa-comment-dots"></i>
                                        <input type="text" id="topic" placeholder="Tema / Arsyeja e takimit (Opsionale)">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Konfirmo Takimin</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Premium Gallery -->
        <section id="galeria" class="gallery-section">
            <div class="container">
                <div class="section-header center reveal">
                    <h5 class="section-subtitle">JETA SHKOLLORE</h5>
                    <h2 class="section-title">Eksploro <span class="gradient-text">Ulpianën</span></h2>
                </div>
                
                <div class="gallery-grid reveal delay-1">
                    <a href="assets/sallaetakimeve.png" class="gallery-item large" target="_blank" rel="noopener noreferrer" onclick="event.preventDefault(); openImage(this.href);">
                        <img src="assets/sallaetakimeve.png" alt="Kampusi" loading="lazy" decoding="async">
                        <div class="g-overlay"><span>Salla e Takimeve</span></div>
                    </a>
                    <a href="assets/biblotekta.png" class="gallery-item" target="_blank" rel="noopener noreferrer" onclick="event.preventDefault(); openImage(this.href);">
                        <img src="assets/biblotekta.png" alt="Biblioteka" loading="lazy" decoding="async">
                        <div class="g-overlay"><span>Biblioteka e Re</span></div>
                    </a>
                    <a href="https://infokomuna.com/repository/images/686_455/25_11_2023_3335750_salla_e_sporteve_1.jpg" class="gallery-item" target="_blank" rel="noopener noreferrer" onclick="event.preventDefault(); openImage(this.href);">
                        <img src="https://infokomuna.com/repository/images/686_455/25_11_2023_3335750_salla_e_sporteve_1.jpg" alt="Salla e Sportit" loading="lazy" decoding="async">
                        <div class="g-overlay"><span>Salla e Sportit</span></div>
                    </a>
                    <a href="https://storm-rks.com/wp-content/uploads/2025/08/nxenesit.jpg" class="gallery-item wide" target="_blank" rel="noopener noreferrer" onclick="event.preventDefault(); openImage(this.href);">
                        <img src="https://storm-rks.com/wp-content/uploads/2025/08/nxenesit.jpg" alt="Nxënësit" loading="lazy" decoding="async">
                        <div class="g-overlay"><span>Procesi Mësimor</span></div>
                    </a>
                    <a href="assets/kabinetiitik.png" class="gallery-item" target="_blank" rel="noopener noreferrer" onclick="event.preventDefault(); openImage(this.href);">
                        <img src="assets/kabinetiitik.png" alt="Laboratori" loading="lazy" decoding="async">
                        <div class="g-overlay"><span>Laboratori Shkencor</span></div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Lajmet dhe Njoftimet (Dinamike nga Facebook) -->
        <section id="lajmet" class="news-section">
            <div class="container">
                <div class="section-header center reveal">
                    <h5 class="section-subtitle">LIVE NGA SHKOLLA</h5>
                    <h2 class="section-title">Të Rejat & <span class="gradient-text">Aktivitetet</span></h2>
                    <p class="section-desc">Përcillni në kohë reale të gjitha njoftimet, trajnimet, vizitat dhe aktivitetet tona direkt nga faqja jonë zyrtare në Facebook.</p>
                </div>
                <div class="feed-wrapper reveal delay-1" style="display: flex; justify-content: center; background: rgba(255,255,255,0.02); padding: 40px 20px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.05); max-width: 900px; margin: 0 auto; backdrop-filter: blur(10px);">
                    <div style="background: white; padding: 10px; border-radius: 12px; width: 100%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); overflow: hidden;">
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fprofile.php%3Fid%3D100057190760898&tabs=timeline%2Cevents&width=500&height=700&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="700" style="border:none;overflow:hidden; border-radius: 8px;" scrolling="no" frameborder="0" loading="lazy" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </div>
                    <div class="feed-info" style="display: flex; flex-direction: column; justify-content: center; padding-left: 40px; color: white;">
                        <h3>Pse ta përcillni këtë hapësirë?</h3>
                        <ul style="list-style: none; padding: 0; margin-top: 20px; display: flex; flex-direction: column; gap: 15px;">
                            <li><i class="fa-solid fa-bullhorn" style="color: var(--primary); margin-right: 10px; font-size: 1.2rem;"></i> <strong>Njoftime Zytare:</strong> Datat e testeve, pushimeve dhe afateve.</li>
                            <li><i class="fa-solid fa-camera" style="color: var(--primary); margin-right: 10px; font-size: 1.2rem;"></i> <strong>Fotografi:</strong> Kujtime nga aktivitetet dhe vizitat.</li>
                            <li><i class="fa-solid fa-graduation-cap" style="color: var(--primary); margin-right: 10px; font-size: 1.2rem;"></i> <strong>Trajnime:</strong> Njoftime për quiz-e, trajnime dhe olimpiada.</li>
                        </ul>
                        <a href="https://www.facebook.com/profile.php?id=100057190760898" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-glow" style="margin-top: 30px; display: inline-flex; align-items: center; justify-content: center; gap: 10px; max-width: 250px;">
                            <i class="fa-brands fa-facebook"></i> Na Ndjek në Facebook
                        </a>
                    </div>
                </div>
                
                <style>
                    @media (max-width: 850px) {
                        .feed-wrapper {
                            flex-direction: column;
                            align-items: center;
                        }
                        .feed-info {
                            padding-left: 0 !important;
                            margin-top: 40px;
                            text-align: center;
                        }
                        .feed-info ul {
                            text-align: left;
                        }
                        .feed-info .btn-primary {
                            margin: 30px auto 0 auto;
                        }
                    }
                </style>
            </div>
        </section>

        <!-- Eksosistemi Digjital (Admin Preview) -->
        <section id="ekosistemi" class="ecosystem-section reveal">
            <div class="container">
                <div class="ecosystem-grid">
                    <div class="ecosystem-info">
                        <h5 class="section-subtitle">ARKITEKTURA FULL-STACK</h5>
                        <h2 class="section-title">Më shumë se një <span class="gradient-text">Uebfaqe</span></h2>
                        <p class="lead-text">Ulpiana nuk është thjesht një portal informativ. Është një ekosistem i plotë ERP që integron menaxhimin akademik, administrativ dhe financiar në një platformë të vetme.</p>
                        
                        <div class="eco-features">
                            <div class="eco-item">
                                <i class="fa-solid fa-server"></i>
                                <div>
                                    <h4>Backend me PHP 8 & MySQL</h4>
                                    <p>Menaxhim i sigurt i të dhënave, autentikim me Google OAuth dhe mbrojtje CSRF.</p>
                                </div>
                            </div>
                            <div class="eco-item">
                                <i class="fa-solid fa-chart-line"></i>
                                <div>
                                    <h4>Biznes Manager Integration</h4>
                                    <p>Sistemi i integruar për menaxhimin e tenderave, kontratave dhe planeve strategjike të shkollës.</p>
                                </div>
                            </div>
                            <div class="eco-item">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                                <div>
                                    <h4>PWA (Progressive Web App)</h4>
                                    <p>Platforma funksionon si aplikacion nativ në çdo pajisje mobile, edhe pa internet.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ecosystem-visual">
                        <div class="dashboard-mockup glass-panel">
                            <div class="mockup-header">
                                <div class="dots"><span></span><span></span><span></span></div>
                                <div class="url-bar">ulpiana-admin.v3/dashboard</div>
                            </div>
                            <div class="mockup-content">
                                <div class="mockup-sidebar">
                                    <div class="m-s-item active"></div>
                                    <div class="m-s-item"></div>
                                    <div class="m-s-item"></div>
                                    <div class="m-s-item"></div>
                                </div>
                                <div class="mockup-main">
                                    <div class="m-grid">
                                        <div class="m-card"></div>
                                        <div class="m-card"></div>
                                        <div class="m-card"></div>
                                    </div>
                                    <div class="m-chart"></div>
                                </div>
                            </div>
                            <!-- Floating Badge -->
                            <div class="floating-admin-badge">
                                <i class="fa-solid fa-lock"></i>
                                <span>Admin Panel Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id="announcements" class="faq-section relative">
            <div class="container">
                <div class="faq-wrapper glass-panel reveal" style="padding: 40px; max-width: 1000px; margin: 0 auto;">
                    <div class="section-header center" style="margin-bottom: 20px;">
                        <h5 class="section-subtitle">NJOFTIME ZYRTARE</h5>
                        <h2 class="section-title">Njoftimet e <span class="gradient-text">Shkollës</span></h2>
                    </div>
                    <div id="announcementsList">
                        @forelse ($announcements as $a)
                            <article style="padding:14px 0;border-bottom:1px solid rgba(255,255,255,0.08)">
                                <h4 style="color:white;margin-bottom:6px;">{{ $a->title }}</h4>
                                <p style="color:var(--text-secondary);margin-bottom:4px;">{{ $a->content }}</p>
                                <small style="color:#93c5fd;">Publikuar: {{ $a->created_at->format('d.m.Y H:i') }}</small>
                            </article>
                        @empty
                            <div class="empty-state" style="height:auto; padding: 24px 0;">
                                <i class="fa-regular fa-bell-slash"></i>
                                <p>Nuk ka njoftime për momentin.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Kalendari i Ngjarjeve Section -->
        <section id="kalendari" class="faq-section relative" style="background: rgba(255,255,255,0.02);">
            <div class="container">
                <div class="section-header center reveal">
                    <h5 class="section-subtitle">PLANIFIKIMI AKADEMIK</h5>
                    <h2 class="section-title">Kalendari i <span class="gradient-text">Ngjarjeve</span></h2>
                    <p class="section-desc">Përcillni datat e provimeve, pushimeve dhe aktiviteteve të rëndësishme shkollore.</p>
                </div>
                
                <div id="calendarEventsList" class="events-grid reveal delay-1">
                    @forelse ($events as $e)
                        @php
                            $d = \Carbon\Carbon::parse($e->event_date);
                            $day = $d->format('d');
                            $months = ["JAN", "SHK", "MAR", "PRI", "MAJ", "QER", "KOR", "GUS", "SHT", "TET", "NËN", "DHJ"];
                            $month = $months[$d->month - 1];
                            $tagMap = [
                                'exam' => 'Provim',
                                'holiday' => 'Pushim',
                                'activity' => 'Aktivitet',
                                'other' => 'Tjetër'
                            ];
                        @endphp
                        <div class="event-card">
                            <div class="event-date-box">
                                <span>{{ $day }}</span>
                                <small>{{ $month }}</small>
                            </div>
                            <div class="event-info-c">
                                <h4>{{ $e->title }}</h4>
                                <p>{{ $e->description }}</p>
                                <span class="event-tag tag-{{ $e->category }}">{{ $tagMap[$e->category] ?? 'Tjetër' }}</span>
                            </div>
                        </div>
                    @empty
                        <p style="color:var(--text-secondary); text-align:center; grid-column:1/-1;">Nuk ka ngjarje të planifikuara për momentin.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="safeguarding" class="faq-section relative">
            <div class="container">
                <div class="faq-wrapper glass-panel reveal" style="padding: 40px; max-width: 900px; margin: 0 auto;">
                    <div class="section-header center" style="margin-bottom: 20px;">
                        <h5 class="section-subtitle">CHILD SAFEGUARDING</h5>
                        <h2 class="section-title">Raporto një <span class="gradient-text">Shqetësim</span></h2>
                    </div>
                    <form id="safeguardingForm" class="auth-form active" style="display:block;">
                        <div class="input-wrapper"><input type="text" id="safeName" placeholder="Emri (opsionale)"></div>
                        <br>
                        <div class="input-wrapper"><input type="email" id="safeEmail" placeholder="Email (opsionale)"></div>
                        <br>
                        <div class="input-wrapper">
                            <select id="safeCategory" required>
                                <option value="bullying">Bullizëm</option>
                                <option value="violence">Dhunë</option>
                                <option value="wellbeing">Mirëqenie psikologjike</option>
                                <option value="other">Tjetër</option>
                            </select>
                        </div>
                        <br>
                        <div class="input-wrapper"><input type="text" id="safeMessage" placeholder="Përshkrimi i rastit" required></div>
                        <br>
                        <label class="remember" style="margin:8px 0 14px 0;display:block;"><input type="checkbox" id="safeAnon" checked> Raporto anonimisht</label>
                        <br>
                        <button type="submit" class="btn btn-primary w-100">Dërgo Raportin</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Kontakt Form Section -->
        <section id="kontakti" class="faq-section relative">
            <div class="container">
                <div class="faq-wrapper glass-panel reveal" style="padding: 40px; max-width: 900px; margin: 0 auto;">
                    <div class="section-header center" style="margin-bottom: 20px;">
                        <h5 class="section-subtitle">NA KONTAKTONI</h5>
                        <h2 class="section-title">Dërgo një <span class="gradient-text">Mesazh</span></h2>
                        <p class="section-desc">Keni ndonjë pyetje të përgjithshme rreth shkollës? Na shkruani këtu.</p>
                    </div>
                    <form id="contactForm" class="auth-form active" style="display:block;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div class="input-wrapper"><input type="text" id="contactName" placeholder="Emri juaj" required></div>
                
                            <div class="input-wrapper"><input type="email" id="contactEmail" placeholder="Email adresa" required></div>
                           
                        </div>
                        <br>
                        <div class="input-wrapper"><input type="text" id="contactSubject" placeholder="Subjekti" required></div>
                        <br>
                        <div class="input-wrapper"><textarea id="contactMessage" placeholder="Mesazhi juaj..." style="width: 100%; min-height: 120px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 15px; color: white; outline: none;" required></textarea></div>
                        <br>
                        <button type="submit" class="btn btn-primary w-100">Dërgo Mesazhin</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Digital Resources Section -->
        <section id="burimet" class="faq-section relative">
            <div class="container">
                <div class="faq-wrapper glass-panel reveal" style="padding: 40px; max-width: 1100px; margin: 0 auto;">
                    <div class="section-header center" style="margin-bottom: 20px;">
                        <h5 class="section-subtitle">MATERIALE MËSIMORE</h5>
                        <h2 class="section-title">Libraria <span class="gradient-text">Digjitale</span></h2>
                        <p class="section-desc">Këtu mund të gjeni materiale, ushtrime dhe dokumente të ngarkuara nga profesorët tanë.</p>
                    </div>
                    <div class="resource-filters" style="display:flex; gap:10px; flex-wrap:wrap; margin: 20px 0;">
                        <button class="btn btn-outline-light active" onclick="filterResources('all', this)">Të Gjitha</button>
                        <button class="btn btn-outline-light" onclick="filterResources('Matematikë', this)">Matematikë</button>
                        <button class="btn btn-outline-light" onclick="filterResources('Fizikë', this)">Fizikë</button>
                        <button class="btn btn-outline-light" onclick="filterResources('Kimi', this)">Kimi</button>
                        <button class="btn btn-outline-light" onclick="filterResources('Librari', this)">Librari</button>
                    </div>
                    <div id="resourcesList" class="resources-home-grid">
                        @forelse ($resources as $r)
                            <a href="{{ $r->file_path }}" target="_blank" rel="noopener noreferrer" class="resource-card-home" data-category="{{ $r->category }}">
                                <div class="res-icon"><i class="fa-solid fa-file-pdf"></i></div>
                                <div class="res-info-h">
                                    <h4>{{ $r->title }}</h4>
                                    <p>{{ $r->category }} • Nga: {{ $r->uploader_name }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="empty-state" style="grid-column:1/-1; height:auto; padding: 24px 0;">
                                <i class="fa-regular fa-folder-open"></i>
                                <p>Nuk ka materiale të ngarkuara për momentin.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <style>
            .resources-home-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 20px;
                margin-top: 30px;
            }
            .resource-card-home {
                background: rgba(255,255,255,0.03);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 16px;
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 15px;
                transition: 0.3s;
                text-decoration: none;
            }
            .resource-card-home:hover {
                background: rgba(59, 130, 246, 0.1);
                border-color: rgba(59, 130, 246, 0.3);
                transform: translateY(-3px);
            }
            .res-icon {
                width: 45px; height: 45px;
                background: rgba(239, 68, 68, 0.1);
                border-radius: 10px;
                display: flex; align-items: center; justify-content: center;
                color: #ef4444; font-size: 1.4rem;
            }
            .res-info-h h4 { color: white; font-size: 1rem; margin-bottom: 3px; }
            .res-info-h p { color: var(--text-secondary); font-size: 0.8rem; }
        </style>

        <!-- Testimonials -->
        <section class="testimonial-section">
            <div class="container reveal">
                <div class="testimonial-card glass-panel">
                    <i class="fa-solid fa-quote-left quote-icon"></i>
                    <p class="quote-text">"Gjimnazi Ulpiana më dha jo vetëm dijen e nevojshme akademike, por edhe guximin për të ëndërruar dhe për t'u bërë një profesioniste e suksesshme. Jam krenare që isha pjesë e këtij institucioni prestigjioz."</p>
                    <div class="quote-author">
                        <div class="author-avatar">D</div>
                        <div>
                            <h4>Dafina Krasniqi</h4>
                            <span>Ish-nxënëse / Mjeke Specialiste</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Harta / Lokacioni -->
        <section class="map-section-minimal reveal">
            <div class="container">
                <div class="map-artistic-container">
                    <div class="map-header center">
                        <div class="map-badge"><i class="fa-solid fa-location-dot"></i> Gjimnazi Ulpiana, Lipjan</div>
                        <h2 class="section-title">Ku ndodhemi <span class="gradient-text">ne?</span></h2>
                    </div>
                    <div class="map-frame">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2938.8340776595514!2d21.12053911546252!3d42.52297197917631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13549d4432a514d1%3A0xc4eb123b3a3628e8!2sGjimnazi%20%22Ulpiana%22!5e0!3m2!1sen!2s!4v1680000000000!5m2!1sen!2s" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <div class="map-floating-action">
                            <a href="https://www.google.com/maps/dir//Gjimnazi+%22Ulpiana%22/@42.522972,21.120539,15z" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                                <i class="fa-solid fa-diamond-turn-right"></i> Merr Drejtimet
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners Section (Institutional Authority) -->
        <section class="partners-section reveal">
            <div class="container">
                <div class="partners-wrap">
                    <p class="partners-label">MBËSHTETUR DHE REKOMANDUAR NGA:</p>
                    <div class="partners-grid">
                        <div class="partner-logo">
                            <i class="fa-solid fa-building-columns"></i>
                            <span>Ministria e Arsimit</span>
                        </div>
                        <div class="partner-logo">
                            <i class="fa-solid fa-hands-holding-child"></i>
                            <span>UNICEF Kosovo</span>
                        </div>
                        <div class="partner-logo">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>KEC (Kosovo Education Center)</span>
                        </div>
                        <div class="partner-logo">
                            <i class="fa-solid fa-landmark"></i>
                            <span>Komuna e Lipjanit</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Professional Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-info">
                    <div class="brand">
                        <img src="assets/logo.png" alt="Logo" style="width: 50px; height: 50px; object-fit: contain; border-radius: 5px;">
                        <span class="title">Gjimnazi <strong>Ulpiana</strong></span>
                    </div>
                    <p class="footer-desc">Ekselencë në edukim që nga viti 1968. Përgatisim liderët e së ardhmes me standardet më të larta akademike në Kosovë dhe rajon.</p>
                    <div class="socials">
                        <a href="https://www.facebook.com/profile.php?id=100057190760898" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/gjimnaziulpiana/" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i></a>

                        <a href="https://www.youtube.com/@gjimnaziulpiana" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h4>Menuja Kryesore</h4>
                    <ul>
                        <li><a href="#ballina">Ballina</a></li>
                        <li><a href="#historia">Rreth Nesh</a></li>
                        <li><a href="#drejtimet">Drejtimet Akademike</a></li>
                        <li><a href="#takimet">Sistemi i Takimeve</a></li>
                        <li><a href="#announcements">Njoftimet</a></li>
                        <li><a href="#safeguarding">Raporto Shqetësim</a></li>
                        <li><a href="#burimet">Libraria Digjitale</a></li>
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h4>Kontakti</h4>
                    <ul>
                        <li><i class="fa-solid fa-location-dot"></i> Rr. Skenderbeu, Lipjan, 14000</li>
                        <li><i class="fa-solid fa-envelope"></i> info@gjimnazi-ulpiana.edu</li>
                        <li><i class="fa-solid fa-phone"></i> +383 44 123 456</li>
                        <li><i class="fa-solid fa-clock"></i> Hën - Pre: 08:00 - 16:00</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <span id="currentYear">2026</span> Gjimnazi "Ulpiana". Të gjitha të drejtat e rezervuara.</p>
                <div class="footer-bottom-links">
                    <a href="privatesia.html">Privatësia</a>
                    <a href="kushtet.html">Kushtet e Përdorimit</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Modals -->
    <!-- Image Modal -->
    <div id="imageLightbox" class="modal-overlay">
        <div class="modal-close" onclick="closeImage()"><i class="fa-solid fa-xmark"></i></div>
        <img id="lightboxImg" src="" alt="Shiko Fototgrafinë">
    </div>

    <!-- Video Modal -->
    <div id="videoModal" class="modal-overlay">
        <div class="modal-close" onclick="closeVideoModal()"><i class="fa-solid fa-xmark"></i></div>
        <div class="video-container">
            <iframe id="youtubeIframe" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>

    <!-- Auth Modal -->
    <div id="authModal" class="modal-overlay">
        <div class="auth-card glass-panel">
            <div class="modal-close" onclick="closeAuthModal()"><i class="fa-solid fa-xmark"></i></div>
            
            <div class="auth-header">
                <i class="fa-solid fa-shield-halved auth-icon"></i>
                <h2 id="authTitle">Hyrja në Platformë</h2>
                <p id="authDesc">Identifikohuni për të rezervuar takime ose regjistrohuni si përdorues i ri.</p>
            </div>

            <div class="auth-tabs">
                <button class="auth-tab active" onclick="switchAuthTab('login')" id="tabLoginBtn">Kyçu</button>
                <button class="auth-tab" onclick="switchAuthTab('signup')" id="tabSignupBtn">Regjistrohu</button>
            </div>

            <!-- Login Form -->
            <form id="formLogin" class="auth-form active">
                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" placeholder="Email Adresa" required>
                </div>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" placeholder="Fjalëkalimi" required>
                </div>
                <div class="form-footer">
                    <label class="remember"><input type="checkbox"> Më mbaj të kyçur</label>
                    <a href="#" class="forgot" id="forgotPasswordLink">Harruat fjalëkalimin?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Kyçu Tani</button>
                <div style="text-align:center; margin:15px 0; color:var(--text-secondary); font-size:0.9rem;">ose vazhdo me</div>
                <a href="api.php?action=google_auth" class="btn btn-glass w-100" style="display:flex; align-items:center; justify-content:center; gap:10px; border-color:rgba(255,255,255,0.15);">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google" style="width:20px;"> 
                    Vazhdo me Google
                </a>
            </form>

            <form id="formForgot" class="auth-form">
                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" id="forgotEmail" placeholder="Email Adresa" required>
                </div>
                <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:-4px;">Shkruaj email-in me të cilin je regjistruar. Do të dërgohet një kod 6-shifror.</p>
                <button type="submit" class="btn btn-primary w-100">Dërgo Kodin</button>
                <button type="button" class="btn btn-outline-light w-100" style="margin-top:8px;" id="backToLoginBtn">Kthehu te kyçja</button>
            </form>

            <form id="formReset" class="auth-form">
                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" id="resetEmail" placeholder="Email Adresa" required>
                </div>
                <div class="input-wrapper">
                    <i class="fa-solid fa-key"></i>
                    <input type="text" id="resetToken" placeholder="Kodi 6-shifror" required>
                </div>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="resetNewPassword" placeholder="Fjalëkalimi i ri" required>
                </div>
                <p style="color:var(--text-secondary); font-size:0.9rem; margin-top:-4px;">Vendose kodin nga email-i dhe fjalëkalimin e ri.</p>
                <button type="submit" class="btn btn-primary w-100">Përditëso Fjalëkalimin</button>
            </form>

            <!-- Signup Form -->
            <form id="formSignup" class="auth-form">
                <div class="input-wrapper">
                    <i class="fa-regular fa-user"></i>
                    <input type="text" id="regName" placeholder="Emri dhe Mbiemri" required>
                </div>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user-tag"></i>
                    <select id="regRole" required>
                        <option value="parent">Prind</option>
                        <option value="student">Nxënës</option>
                    </select>
                </div>
                <div class="input-wrapper">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" id="regEmail" placeholder="Email Adresa" required>
                </div>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="regPass" placeholder="Krijoni Fjalëkalimin" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Krijo Llogarinë</button>
                <div style="text-align:center; margin:15px 0; color:var(--text-secondary); font-size:0.9rem;">ose regjistrohu me</div>
                <a href="api.php?action=google_auth" class="btn btn-glass w-100" style="display:flex; align-items:center; justify-content:center; gap:10px; border-color:rgba(255,255,255,0.15);">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google" style="width:20px;"> 
                    Vazhdo me Google
                </a>
            </form>
        </div>
    </div>

    <!-- Notification Toast System -->
    <div id="toastContainer" class="toast-container"></div>

    <script src="script.js?v=2"></script>
</body>
</html>
