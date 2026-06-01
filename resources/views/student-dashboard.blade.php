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
    </main>

    <script src="student-dashboard.js"></script>
</body>
</html>
