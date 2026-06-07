<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Gjimnazi "Ulpiana"</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/logo.png">
    
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-body { background-color: var(--bg-main); height: 100vh; overflow: hidden; display: flex; cursor: auto; }
        .cursor-dot,
        .cursor-outline { display: none !important; }
        .dashboard-body a,
        .dashboard-body button,
        .dashboard-body input,
        .dashboard-body select,
        .dashboard-body textarea { cursor: pointer !important; }
        .dashboard-body input,
        .dashboard-body textarea { cursor: text !important; }
        .sidebar { width: 280px; background: rgba(15, 23, 42, 0.8); border-right: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; padding: 30px; backdrop-filter: blur(20px); z-index: 10; }
        .prof-profile { text-align: center; margin-top: 30px; margin-bottom: 40px; }
        .prof-avatar { width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), #059669); margin: 0 auto 15px auto; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: white; font-family: var(--font-heading); font-weight: 800; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3); border: 4px solid rgba(255,255,255,0.1); }
        .prof-name { font-size: 1.4rem; color: white; font-weight: 700; font-family: var(--font-heading); }
        .prof-subject { color: var(--accent); font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; }
        .sidebar-menu { list-style: none; display: flex; flex-direction: column; gap: 10px; flex: 1; }
        .sidebar-menu a { display: flex; align-items: center; gap: 15px; padding: 15px 20px; border-radius: 12px; color: var(--text-secondary); text-decoration: none; font-weight: 500; transition: all 0.3s; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(16, 185, 129, 0.1); color: white; }
        .dashboard-main { flex: 1; padding: 40px 60px; overflow-y: auto; position: relative; z-index: 1; }
        .dash-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 20px; }
        .dash-title h1 { font-size: 2.5rem; color: white; }
        .view-panel { display: none; }
        .view-panel.active { display: block; }
        .grade-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 25px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; }
        .grade-val { width: 60px; height: 60px; background: var(--accent); color: white; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800; }
        .grade-info h4 { font-size: 1.2rem; color: white; margin-bottom: 4px; }
        .grade-info p { color: var(--text-secondary); font-size: 0.9rem; }
        .logout-btn { background: rgba(239, 68, 68, 0.1); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.2); margin-top: auto; }
        .logout-btn:hover { background: #ef4444; color: white; }
    </style>
</head>
<body class="dashboard-body">
    <div class="bg-elements"><div class="blob blob-1"></div><div class="blob blob-2" style="background:var(--accent)"></div><div class="noise-overlay"></div></div>

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon" style="width:45px; height:45px; background:transparent;"><img src="assets/logo.png" alt="Logo" style="width:100%"></div>
            <div class="brand-text"><span class="title" style="font-size:1.1rem;">Portal i <strong>Nxënësit</strong></span></div>
        </div>
        <div class="prof-profile">
            <div class="prof-avatar" id="sAvatar">
                @php
                    $initials = '';
                    $words = explode(' ', $user->full_name);
                    foreach ($words as $w) {
                        $initials .= mb_substr($w, 0, 1);
                    }
                    $initials = mb_strtoupper($initials);
                @endphp
                {{ $initials }}
            </div>
            <h2 class="prof-name" id="sName">{{ $user->full_name }}</h2>
            <p class="prof-subject">Gjimnazi Ulpiana</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#" class="active" data-view="grades"><i class="fa-solid fa-graduation-cap"></i> Notat e Mia</a></li>
            <li><a href="#" data-view="resources"><i class="fa-solid fa-book"></i> Libraria Digjitale</a></li>
            <li><a href="#" data-view="news"><i class="fa-solid fa-newspaper"></i> Njoftimet</a></li>
            <li><a href="#" data-view="idcard"><i class="fa-solid fa-id-card"></i> ID Dixhitale</a></li>
            <li><a href="#" data-view="leaderboard"><i class="fa-solid fa-trophy"></i> Tabela Kryesore</a></li>
        </ul>
        <button class="btn logout-btn w-100" id="logoutBtn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Dil</button>
    </aside>

    <main class="dashboard-main">
        <div class="dash-header">
            <div class="dash-title"><h1 id="viewTitle">Notat e Mia</h1><p id="viewDesc">Suksesi juaj akademik</p></div>
        </div>

        <section class="view-panel active" id="view-grades">
            <div id="gradesList">
                @forelse ($grades as $g)
                    <div class="grade-card">
                        <div class="grade-info">
                            <h4>{{ $g->subject_name }}</h4>
                            <p>{{ $g->comment ?: 'Pa koment' }} • Nga: {{ $g->teacher_name }}</p>
                            <small style="color:var(--text-secondary);">Më: {{ $g->created_at->format('d.m.Y H:i') }}</small>
                        </div>
                        <div class="grade-val">{{ $g->grade_value }}</div>
                    </div>
                @empty
                    <div style="text-align:center; padding:50px 0; color:var(--text-secondary);">
                        <i class="fa-solid fa-graduation-cap" style="font-size:3rem; opacity:0.3; margin-bottom:15px;"></i>
                        <p>Nuk keni asnjë notë të regjistruar ende.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="view-panel" id="view-resources">
            <div class="students-table-wrap">
                <table class="students-table">
                    <thead><tr><th>Titulli</th><th>Kategoria</th><th>Data</th><th>Veprim</th></tr></thead>
                    <tbody id="resourcesList">
                        @forelse ($resources as $r)
                            <tr>
                                <td><strong>{{ $r->title }}</strong></td>
                                <td><span class="event-tag tag-activity">{{ $r->category }}</span></td>
                                <td>{{ $r->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="{{ $r->file_path }}" target="_blank" class="btn btn-outline-light" style="padding:6px 12px; font-size:0.85rem; text-decoration:none; display:inline-block;">Shkarko</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align:center; color:var(--text-secondary);">Nuk ka materiale të ngarkuara.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="view-panel" id="view-news">
            <div id="newsList">
                @forelse ($announcements as $a)
                    <article style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px; padding: 20px; margin-bottom: 15px;">
                        <h3 style="color:white; margin-bottom:8px;">{{ $a->title }}</h3>
                        <p style="color:var(--text-secondary); line-height:1.6; margin-bottom:12px;">{{ $a->content }}</p>
                        <small style="color:#10b981;">Publikuar më: {{ $a->created_at->format('d.m.Y H:i') }}</small>
                    </article>
                @empty
                    <div style="text-align:center; padding:50px 0; color:var(--text-secondary);">
                        <i class="fa-regular fa-bell-slash" style="font-size:3rem; opacity:0.3; margin-bottom:15px;"></i>
                        <p>Nuk ka njoftime të shpallura për momentin.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Digital ID Card Section -->
        <section class="view-panel" id="view-idcard">
            <div style="display: flex; justify-content: center; align-items: center; min-height: 50vh;">
                <div style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.02) 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; width: 100%; max-width: 400px; padding: 30px; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.4); backdrop-filter: blur(10px);">
                    <!-- Decorative header -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 8px; background: linear-gradient(90deg, #10b981, #059669);"></div>
                    
                    <div style="text-align: center; margin-bottom: 25px;">
                        <img src="assets/logo.png" alt="Ulpiana Logo" style="width: 50px; margin-bottom: 10px;">
                        <h3 style="color: white; font-family: var(--font-heading); margin: 0; letter-spacing: 1px;">GJIMNAZI ULPIANA</h3>
                        <p style="color: var(--accent); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; margin-top: 3px;">Karta Dixhitale e Nxënësit</p>
                    </div>

                    <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
                        <div style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), #059669); color: white; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 800; border: 4px solid rgba(255,255,255,0.1);">
                            {{ $initials }}
                        </div>
                        
                        <div style="text-align: center; width: 100%;">
                            <h2 style="color: white; margin: 0 0 5px 0; font-size: 1.6rem;">{{ $user->full_name }}</h2>
                            <p style="color: var(--text-secondary); margin: 0 0 15px 0; font-size: 0.95rem;">ID: #ULP-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                            
                            <div style="background: rgba(0,0,0,0.3); border-radius: 12px; padding: 15px; display: inline-block;">
                                <!-- Live QR Code specific to user -->
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Ulpiana_Student_{{ $user->id }}_{{ md5($user->email) }}&color=10b981&bgcolor=0f172a" alt="QR Code" style="border-radius: 8px;">
                            </div>
                            <p style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 15px;">Skano për akses në bibliotekë & hyrje</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Leaderboard Section -->
        <section class="view-panel" id="view-leaderboard">
            <div style="max-width: 650px; margin: 0 auto;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <div style="font-size: 3rem; margin-bottom: 10px;">🏆</div>
                    <h2 style="color: white; font-family: var(--font-heading); margin: 0;">Top 10 Nxënësit</h2>
                    <p style="color: var(--text-secondary); margin-top: 8px;">Bazuar në mesataren e notave të publikuara</p>
                </div>

                @php $rank = 1; @endphp
                @forelse($leaderboard as $entry)
                    @php
                        $isMe = strtolower(trim($entry->student_name)) === strtolower(trim($user->full_name));
                        $medal = $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : '#' . $rank));
                        $avgFormatted = number_format($entry->avg_grade, 2);
                        $barWidth = min(100, ($entry->avg_grade / 5) * 100);
                    @endphp
                    <div style="background: {{ $isMe ? 'rgba(16,185,129,0.15)' : 'rgba(255,255,255,0.03)' }}; border: 1px solid {{ $isMe ? 'rgba(16,185,129,0.5)' : 'rgba(255,255,255,0.08)' }}; border-radius: 16px; padding: 18px 22px; margin-bottom: 12px; display: flex; align-items: center; gap: 18px; transition: transform 0.2s;" onmouseover="this.style.transform='translateX(5px)'" onmouseout="this.style.transform='translateX(0)'">
                        <div style="font-size: {{ $rank <= 3 ? '2rem' : '1.2rem' }}; min-width: 40px; text-align: center; font-weight: 800; color: {{ $rank <= 3 ? 'white' : 'var(--text-secondary)' }};">{{ $medal }}</div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <span style="color: white; font-weight: 600; font-size: 1rem;">{{ $isMe ? '⭐ ' . $entry->student_name . ' (Unë)' : $entry->student_name }}</span>
                                <span style="color: var(--accent); font-weight: 800; font-size: 1.1rem;">{{ $avgFormatted }}</span>
                            </div>
                            <div style="height: 6px; background: rgba(255,255,255,0.08); border-radius: 10px; overflow: hidden;">
                                <div style="height: 100%; width: {{ $barWidth }}%; background: linear-gradient(90deg, #10b981, #059669); border-radius: 10px; transition: width 1s ease;"></div>
                            </div>
                            <div style="margin-top: 5px; color: var(--text-secondary); font-size: 0.8rem;">{{ $entry->total_grades }} lëndë të vlerësuara</div>
                        </div>
                    </div>
                    @php $rank++; @endphp
                @empty
                    <div style="text-align: center; padding: 60px 0; color: var(--text-secondary);">
                        <i class="fa-solid fa-trophy" style="font-size: 3rem; opacity: 0.3; margin-bottom: 15px;"></i>
                        <p>Nuk ka të dhëna të mjaftueshme për tabelën kryesore.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <script src="student-dashboard.js"></script>
    
    <!-- Accessibility Widget -->
    <div class="a11y-widget">
        <div class="a11y-menu" id="a11yMenu">
            <h4><i class="fa-solid fa-universal-access"></i> Aksesueshmëria</h4>
            <div class="a11y-option" onclick="toggleA11y('a11y-large-text', this)">
                <i class="fa-solid fa-magnifying-glass-plus"></i> Zmadho Shkronjat
            </div>
            <div class="a11y-option" onclick="toggleA11y('a11y-high-contrast', this)">
                <i class="fa-solid fa-circle-half-stroke"></i> Kontrast i Lartë
            </div>
            <div class="a11y-option" onclick="toggleA11y('a11y-highlight-links', this)">
                <i class="fa-solid fa-link"></i> Thekso Linqet
            </div>
        </div>
        <div class="a11y-btn" onclick="document.getElementById('a11yMenu').classList.toggle('show')">
            <i class="fa-solid fa-wheelchair"></i>
        </div>
    </div>

    <script>
        function toggleA11y(className, el) {
            document.body.classList.toggle(className);
            el.classList.toggle('active');
        }
    </script>
</body>
</html>
