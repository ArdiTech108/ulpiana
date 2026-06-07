<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesor Dashboard | Gjimnazi "Ulpiana"</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/logo.png">
    <link rel="manifest" href="site.webmanifest">
    
    <link rel="stylesheet" href="style.css">
    <style>
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.95rem;
            cursor: pointer;
        }
        
        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.05);
            color: white;
            padding-left: 22px;
        }

        .sidebar-menu li.active a {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
        }

        .students-table tr {
            transition: background 0.2s ease;
        }
        
        .students-table tbody tr:hover {
            background: rgba(255,255,255,0.03);
            cursor: default;
        }

        .btn {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn:active {
            transform: scale(0.96);
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 25px;
            background: #1e293b;
            color: white;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 10000;
        }
        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        .toast-success { border-left: 5px solid #10b981; }
        .toast-error { border-left: 5px solid #ef4444; }

        .dashboard-body {
            background-color: var(--bg-main);
            height: 100vh;
            overflow: hidden;
            display: flex;
            cursor: auto;
        }

        /* Dashboard uses standard cursor (custom cursor is disabled here) */
        .cursor-dot,
        .cursor-outline {
            display: none !important;
        }

        .dashboard-body a,
        .dashboard-body button,
        .dashboard-body input,
        .dashboard-body select,
        .dashboard-body textarea {
            cursor: pointer;
        }

        .dashboard-body input,
        .dashboard-body textarea {
            cursor: text;
        }

        .sidebar {
            width: 280px;
            background: rgba(15, 23, 42, 0.8);
            border-right: 1px solid rgba(255,255,255,0.05);
            display: flex;
            flex-direction: column;
            padding: 30px;
            backdrop-filter: blur(20px);
            z-index: 10;
        }

        .prof-profile {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 40px;
        }

        .prof-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            margin: 0 auto 15px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            font-family: var(--font-heading);
            font-weight: 800;
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
            border: 4px solid rgba(255,255,255,0.1);
        }

        .prof-name { font-size: 1.4rem; color: white; font-weight: 700; font-family: var(--font-heading); }
        .prof-subject { color: var(--accent); font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 15px;
            flex: 1;
            overflow-y: auto;
            padding-right: 5px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            border-radius: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(59, 130, 246, 0.15);
            color: white;
        }

        .sidebar-menu a i { font-size: 1.2rem; width: 20px; text-align: center; }

        .dashboard-main {
            flex: 1;
            padding: 40px 60px;
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }

        .dash-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 50px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-bottom: 20px;
        }

        .dash-title h1 { font-size: 2.5rem; color: white; }
        .dash-title p { color: var(--text-secondary); font-size: 1.1rem; }

        .dash-actions { display: flex; gap: 15px; }

        .meetings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .view-panel { display: none; }
        .view-panel.active { display: block; }

        .students-toolbar {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        #analyticsCards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            width: 100%;
        }

        .students-search {
            flex: 1;
            min-width: 240px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.12);
            color: white;
            padding: 12px 14px;
            border-radius: 12px;
        }

        textarea.students-search {
            min-height: 90px;
            resize: vertical;
        }

        .dash-toast-wrap {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 380px;
        }

        .dash-toast {
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(15, 23, 42, 0.95);
            color: #fff;
            font-size: 0.92rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.35);
        }

        .dash-toast.success { border-color: rgba(16,185,129,.45); }
        .dash-toast.error { border-color: rgba(239,68,68,.45); }

        .btn[disabled] {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .students-table-wrap {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .students-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .students-table th,
        .students-table td {
            padding: 14px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            text-align: left;
        }

        .students-table th {
            color: #93c5fd;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .setting-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 20px;
        }

        .setting-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 14px;
            gap: 12px;
        }

        .setting-row select,
        .setting-row input[type="text"] {
            width: 55%;
            background-color: #1e293b !important; /* Ngjyrë e errët solide */
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important; /* Tekst i bardhë i pastër */
            padding: 10px 14px !important;
            border-radius: 10px !important;
            font-size: 0.95rem !important;
            outline: none !important;
            display: block;
        }

        /* Kjo rregullon listën që hapet (dropdown) */
        .setting-row select option {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        .setting-row select:focus,
        .setting-row input[type="text"]:focus {
            border-color: #3b82f6 !important;
            background-color: #0f172a !important;
        }

        .meeting-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 25px;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        .meeting-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border-color: rgba(59, 130, 246, 0.3);
            background: rgba(255,255,255,0.05);
        }

        .meeting-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 4px; height: 100%;
            background: var(--primary);
        }

        .m-time {
            display: inline-block;
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 20px;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .m-details { display: flex; flex-direction: column; gap: 12px; }
        
        .m-detail-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .m-icon {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
        }

        .m-info h5 { color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
        .m-info p { color: white; font-weight: 600; font-size: 1.1rem; }

        .empty-dash {
            text-align: center;
            padding: 100px 0;
            color: var(--text-secondary);
        }
        .empty-dash i { font-size: 4rem; opacity: 0.3; margin-bottom: 20px; }
        .empty-dash h3 { color: white; font-size: 1.5rem; margin-bottom: 10px; }

        .logout-btn {
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
        .logout-btn:hover { background: #ef4444; color: white; }

        @media (max-width: 1200px) {
            .dashboard-main {
                padding: 32px;
            }

            .dash-title h1 {
                font-size: 2rem;
            }
        }

        @media (max-width: 992px) {
            .dashboard-body {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow: auto;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                padding: 20px;
            }

            .prof-profile {
                margin: 20px 0 24px 0;
            }

            .sidebar-menu {
                flex-direction: row;
                flex-wrap: nowrap;
                gap: 10px;
                overflow-x: auto;
                padding-bottom: 10px;
                -webkit-overflow-scrolling: touch;
            }

            .sidebar-menu li {
                flex-shrink: 0;
            }

            .dashboard-main {
                padding: 24px 20px 30px 20px;
                overflow: visible;
            }

            .dash-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 640px) {
            .sidebar {
                padding: 16px;
            }

            .brand-text .title {
                font-size: 1rem !important;
            }

            .prof-avatar {
                width: 78px;
                height: 78px;
                font-size: 2rem;
            }

            .prof-name {
                font-size: 1.1rem;
            }

            .prof-subject {
                font-size: 0.78rem;
            }

            .sidebar-menu a {
                padding: 12px 14px;
                font-size: 0.92rem;
            }

            .dashboard-main {
                padding: 20px 14px 24px 14px;
            }

            .dash-title h1 {
                font-size: 1.6rem;
            }

            .dash-title p {
                font-size: 0.95rem;
            }

            .dash-actions {
                width: 100%;
            }

            .dash-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .meetings-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .meeting-card {
                padding: 18px;
            }

            .m-info p {
                font-size: 1rem;
            }
            
            .students-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .students-search {
                width: 100%;
            }
        }

        /* --- Announcements Custom CSS --- */
        .ann-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: all 0.2s ease;
        }
        .ann-card:hover {
            border-color: rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.05);
        }
        .ann-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }
        .ann-card-title {
            color: white;
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .ann-card-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ann-card-body {
            color: rgba(255,255,255,0.7);
            font-size: 0.95rem;
            line-height: 1.5;
            white-space: pre-wrap;
        }
        .ann-badge {
            font-size: 0.72rem;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }
        .ann-badge-all { background: rgba(59,130,246,0.15); color: #93c5fd; }
        .ann-badge-parents { background: rgba(16,185,129,0.15); color: #6ee7b7; }
        .ann-badge-students { background: rgba(245,158,11,0.15); color: #fcd34d; }
        .ann-badge-teachers { background: rgba(139,92,246,0.15); color: #c4b5fd; }
        
        .ann-btn-edit, .ann-btn-delete {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ann-btn-edit:hover {
            background: rgba(59,130,246,0.15);
            border-color: rgba(59,130,246,0.3);
            color: #60a5fa;
        }
        .ann-btn-delete:hover {
            background: rgba(239,68,68,0.15);
            border-color: rgba(239,68,68,0.3);
            color: #f87171;
        }
    </style>
</head>
<body class="dashboard-body">

    <!-- Custom Cursor -->
    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <!-- Background Elements -->
    <div class="bg-elements">
        <div class="blob blob-1"></div>
        <div class="blob blob-2" style="background:var(--accent)"></div>
        <div class="noise-overlay"></div>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon" style="width:45px; height:45px; background:transparent; box-shadow:none;">
                <img src="assets/logo.png" alt="Logo">
            </div>
            <div class="brand-text">
                <span class="title" style="font-size:1.1rem;">Gjimnazi <strong>Ulpiana</strong></span>
            </div>
        </div>

        <div class="prof-profile">
            <div class="prof-avatar" id="dAvatar">
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
            <h2 class="prof-name" id="dName">{{ $user->full_name }}</h2>
            <p class="prof-subject" id="dSubject">{{ $user->teacher_subject ?? 'Administrator' }}</p>
            <ul class="sidebar-menu" id="sidebarMenu">
                <li class="active"><a href="#" data-view="meetings"><i class="fa-solid fa-calendar-check"></i> Takimet</a></li>
                @if ($user->role === 'teacher')
                    <li><a href="#" data-view="grades"><i class="fa-solid fa-graduation-cap"></i> Notat</a></li>
                @endif
                <li><a href="#" data-view="announcements"><i class="fa-solid fa-bullhorn"></i> Njoftimet</a></li>
                <li><a href="#" data-view="resources"><i class="fa-solid fa-folder-open"></i> Materialet</a></li>
                @if ($user->role === 'admin')
                    <li><a href="#" data-view="calendar"><i class="fa-solid fa-calendar-days"></i> Kalendari</a></li>
                    <li><a href="#" data-view="users"><i class="fa-solid fa-users"></i> Përdoruesit</a></li>
                    <li><a href="#" data-view="safeguarding"><i class="fa-solid fa-shield-heart"></i> Safeguarding</a></li>
                    <li><a href="#" data-view="audit"><i class="fa-solid fa-clipboard-list"></i> Auditimi</a></li>
                @endif
                <li><a href="#" data-view="settings"><i class="fa-solid fa-gears"></i> Cilësimet</a></li>
            </ul>
        </div>

        <button class="btn logout-btn w-100" onclick="logout()" style="margin-top:auto;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Dil nga Sistemi
        </button>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-main">
        <div class="dash-header">
            <div class="dash-title">
                <h1 id="viewTitle">Paneli i Profesorit</h1>
                <p id="viewDesc">Menaxhimi i takimeve me prindër</p>
            </div>
            <div class="dash-actions">
                <button class="btn btn-outline-light" id="printReportBtn" type="button"><i class="fa-solid fa-print"></i> Printo Raportin</button>
            </div>
        </div>

        <section class="view-panel" id="view-students">
            <div class="students-toolbar">
                <input class="students-search" id="studentsSearch" type="text" placeholder="Kërko sipas nxënësit, prindit ose profesorit...">
                <button class="btn btn-outline-light" id="studentsExportBtn"><i class="fa-solid fa-file-export"></i> Eksporto CSV</button>
            </div>
            <div class="students-table-wrap">
                <table class="students-table">
                    <thead>
                        <tr>
                            <th>Nxënësi/ja</th>
                            <th>Prindi</th>
                            <th>Profesori</th>
                            <th>Lënda</th>
                            <th>Ora</th>
                            <th>Tema</th>
                        </tr>
                    </thead>
                    <tbody id="studentsTableBody"></tbody>
                </table>
            </div>
        </section>

            <div id="panelMeetings" class="view-panel active">
                <div id="bookingsList" class="meetings-grid">
                    @forelse ($bookings as $b)
                        <div class="meeting-card">
                            <span class="m-time">{{ $b->booking_time }}</span>
                            <div class="m-details">
                                <div class="m-detail-item">
                                    <div class="m-icon"><i class="fa-regular fa-user"></i></div>
                                    <div class="m-info">
                                        <h5>Nxënësi</h5>
                                        <p>{{ $b->student_name }}</p>
                                    </div>
                                </div>
                                <div class="m-detail-item">
                                    <div class="m-icon"><i class="fa-regular fa-id-card"></i></div>
                                    <div class="m-info">
                                        <h5>Prindi</h5>
                                        <p>{{ $b->parent_name }}</p>
                                    </div>
                                </div>
                                <div class="m-detail-item">
                                    <div class="m-icon"><i class="fa-regular fa-comment-dots"></i></div>
                                    <div class="m-info">
                                        <h5>Arsyeja</h5>
                                        <p>{{ $b->topic ?: 'Pa temë specifike' }}</p>
                                    </div>
                                </div>
                                <div class="m-detail-item">
                                    <div class="m-icon"><i class="fa-regular fa-envelope"></i></div>
                                    <div class="m-info">
                                        <h5>Email</h5>
                                        <p>{{ $b->parent_email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-dash">
                            <i class="fa-solid fa-calendar-day"></i>
                            <h3>Nuk ka takime</h3>
                            <p>Rezervimet tuaja do të shfaqen këtu.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Grades Panel -->
            <div id="view-grades" class="view-panel">
                <div class="students-toolbar">
                    <input type="text" id="gradeStudent" class="students-search" placeholder="Emri i Nxënësit">
                    <input type="text" id="gradeSubject" class="students-search" placeholder="Lënda">
                    <input type="number" id="gradeValue" class="students-search" placeholder="Nota (1-5)" style="max-width:120px;">
                    <input type="text" id="gradeComment" class="students-search" placeholder="Koment (opsional)">
                    <button class="btn btn-primary" id="saveGradeBtn">Ruaj Notën</button>
                </div>
                <div class="students-table-wrap">
                    <table class="students-table">
                        <thead>
                            <tr>
                                <th>Nxënësi</th>
                                <th>Lënda</th>
                                <th>Nota</th>
                                <th>Koment</th>
                                <th>Publikuar</th>
                                <th>Veprim</th>
                            </tr>
                        </thead>
                        <tbody id="gradesTableBody">
                            @forelse ($grades as $g)
                                <tr>
                                    <td>{{ $g->student_name }}</td>
                                    <td>{{ $g->subject_name }}</td>
                                    <td><strong style="color:var(--accent)">{{ $g->grade_value }}</strong></td>
                                    <td>{{ $g->comment }}</td>
                                    <td>{{ $g->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-outline-light" onclick="deleteGrade({{ $g->id }})" style="background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.2); color:#fca5a5; padding:5px 10px; font-size:0.8rem; cursor:pointer;">
                                            Fshi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" style="text-align:center; color:var(--text-secondary);">Nuk ka nota të regjistruara për momentin.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Announcements Panel -->
            <div id="view-announcements" class="view-panel">

                <!-- Two-column layout -->
                <div style="display:grid; grid-template-columns:380px 1fr; gap:24px; align-items:start;">

                    <!-- LEFT: Add form -->
                    <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:18px; padding:24px;">
                        <h3 style="color:white; font-size:1.1rem; margin-bottom:18px; display:flex; align-items:center; gap:10px;">
                            <i class="fa-solid fa-plus" style="color:var(--primary);"></i> Shto Njoftim të Ri
                        </h3>

                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <input type="text" id="annTitle" class="students-search" placeholder="Titulli i njoftimit *" maxlength="180">

                            <div style="position:relative;">
                                <textarea id="annContent" class="students-search" placeholder="Përmbajtja e njoftimit..." style="min-height:110px; resize:vertical;" maxlength="2000"></textarea>
                                <span id="annCharCount" style="position:absolute; bottom:8px; right:12px; font-size:0.72rem; color:var(--text-secondary);">0 / 2000</span>
                            </div>

                            <select id="annAudience" class="students-search" style="background:#1e293b; color:white;">
                                <option value="all">👥 Të gjithë</option>
                                <option value="parents">👨‍👩‍👧 Prindërit</option>
                                <option value="students">🎓 Nxënësit</option>
                                <option value="teachers">👩‍🏫 Mësimdhënësit</option>
                            </select>

                            <button class="btn btn-primary" id="saveAnnouncementBtn" style="width:100%; justify-content:center;">
                                <i class="fa-solid fa-paper-plane"></i> Publiko Njoftimin
                            </button>
                        </div>
                    </div>

                    <!-- RIGHT: List -->
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                            <h3 style="color:white; font-size:1.1rem; display:flex; align-items:center; gap:10px;">
                                <i class="fa-solid fa-list" style="color:var(--accent);"></i>
                                Lista e Njoftimeve
                                <span id="annCount" style="background:rgba(59,130,246,0.15); color:#93c5fd; font-size:0.75rem; padding:2px 10px; border-radius:20px; font-weight:600;"></span>
                            </h3>
                            <input type="text" id="annSearch" placeholder="🔍 Kërko..." style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:10px; color:white; padding:8px 12px; font-size:0.9rem; width:180px;">
                        </div>

                        <div id="announcementsTableBody" style="display:flex; flex-direction:column; gap:10px; max-height:62vh; overflow-y:auto; padding-right:4px;">
                            @forelse ($announcements as $a)
                            <div class="ann-card" data-id="{{ $a->id }}" data-title="{{ htmlspecialchars($a->title, ENT_QUOTES) }}" data-content="{{ htmlspecialchars($a->content, ENT_QUOTES) }}" data-audience="{{ $a->audience ?? 'all' }}">
                                <div class="ann-card-header">
                                    <div>
                                        <div class="ann-card-title">{{ $a->title }}</div>
                                        <div class="ann-card-meta">
                                            <span class="ann-badge ann-badge-{{ $a->audience ?? 'all' }}">
                                                @switch($a->audience ?? 'all')
                                                    @case('parents') 👨‍👩‍👧 Prindërit @break
                                                    @case('students') 🎓 Nxënësit @break
                                                    @case('teachers') 👩‍🏫 Mësimdhënësit @break
                                                    @default 👥 Të gjithë
                                                @endswitch
                                            </span>
                                            <span style="color:var(--text-secondary); font-size:0.78rem;">
                                                <i class="fa-regular fa-clock"></i> {{ $a->created_at->format('d.m.Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div style="display:flex; gap:8px; flex-shrink:0;">
                                        <button class="ann-btn-edit" onclick="annEdit(this)" title="Edito">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="ann-btn-delete" onclick="annDelete({{ $a->id }}, this)" title="Fshi">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="ann-card-body">{{ $a->content }}</div>
                            </div>
                            @empty
                            <div class="empty-dash" style="padding:50px 0;">
                                <i class="fa-solid fa-bullhorn"></i>
                                <h3>Nuk ka njoftime</h3>
                                <p>Shto njoftimin e parë nga forma në të majtë.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div id="annEditModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); backdrop-filter:blur(6px); z-index:9000; align-items:center; justify-content:center;">
                    <div style="background:#0f172a; border:1px solid rgba(255,255,255,0.12); border-radius:20px; padding:30px; width:min(520px, 92vw); position:relative;">
                        <button onclick="annCloseModal()" style="position:absolute; top:14px; right:14px; background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:white; width:32px; height:32px; border-radius:8px; cursor:pointer; font-size:1rem;">✕</button>
                        <h3 style="color:white; margin-bottom:20px;"><i class="fa-solid fa-pen-to-square" style="color:var(--primary);"></i> Edito Njoftimin</h3>
                        <input type="hidden" id="annEditId">
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <input type="text" id="annEditTitle" class="students-search" placeholder="Titulli *" maxlength="180">
                            <textarea id="annEditContent" class="students-search" placeholder="Përmbajtja..." style="min-height:100px; resize:vertical;" maxlength="2000"></textarea>
                            <select id="annEditAudience" class="students-search" style="background:#1e293b; color:white;">
                                <option value="all">👥 Të gjithë</option>
                                <option value="parents">👨‍👩‍👧 Prindërit</option>
                                <option value="students">🎓 Nxënësit</option>
                                <option value="teachers">👩‍🏫 Mësimdhënësit</option>
                            </select>
                            <div style="display:flex; gap:10px; margin-top:6px;">
                                <button class="btn btn-primary" id="annSaveEditBtn" style="flex:1; justify-content:center;">
                                    <i class="fa-solid fa-check"></i> Ruaj Ndryshimet
                                </button>
                                <button class="btn btn-outline-light" onclick="annCloseModal()" style="padding:12px 20px;">Anulo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Resources Panel -->
            <div id="view-resources" class="view-panel">
                <div class="students-toolbar">
                    <input type="text" id="resTitle" class="students-search" placeholder="Titulli i Materialit">
                    <select id="resCategory" class="students-search" style="max-width:200px;">
                        <option value="Leksione">Leksione</option>
                        <option value="Detyra">Detyra</option>
                        <option value="Libra">Libra</option>
                        <option value="Teste">Teste</option>
                    </select>
                    <input type="file" id="resFile" style="display:none;">
                    <button class="btn btn-outline-light" onclick="document.getElementById('resFile').click()">Zgjidh Fajllin</button>
                    <button class="btn btn-primary" id="uploadResBtn">Ngarko Materialin</button>
                </div>
                <div class="students-table-wrap" style="margin-top:20px;">
                    <table class="students-table">
                        <thead><tr><th>Titulli</th><th>Kategoria</th><th>Ngarkuar nga</th><th>Data</th><th>Veprim</th></tr></thead>
                        <tbody id="resourcesTableBody">
                            @forelse ($resources as $r)
                                <tr>
                                    <td><a href="{{ $r->file_path }}" target="_blank" style="color:#93c5fd; text-decoration:none;">{{ $r->title }}</a></td>
                                    <td><span class="event-tag tag-activity">{{ $r->category }}</span></td>
                                    <td>{{ $r->uploader_name }}</td>
                                    <td>{{ $r->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-outline-light" onclick="deleteResource({{ $r->id }})" style="background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.2); color:#fca5a5; padding:5px 10px; font-size:0.8rem; cursor:pointer;">
                                            Fshi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" style="text-align:center; color:var(--text-secondary);">Nuk ka materiale të ngarkuara.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Calendar Management (Admin) -->
            <div id="view-calendar" class="view-panel">
                <form id="eventForm" class="students-toolbar">
                    <input type="text" id="eventTitle" class="students-search" placeholder="Titulli i Ngjarjes" required>
                    <input type="date" id="eventDate" class="students-search" style="max-width:180px;" required>
                    <select id="eventCategory" class="students-search" style="max-width:150px;">
                        <option value="activity">Aktivitet</option>
                        <option value="exam">Provim</option>
                        <option value="holiday">Pushim</option>
                        <option value="other">Tjetër</option>
                    </select>
                    <input type="text" id="eventDesc" class="students-search" placeholder="Përshkrimi">
                    <button class="btn btn-primary" type="submit">Shto Ngjarjen</button>
                </form>
                <div class="students-table-wrap">
                    <table class="students-table">
                        <thead><tr><th>Data</th><th>Titulli</th><th>Kategoria</th><th>Veprim</th></tr></thead>
                        <tbody id="eventsTableBody">
                            @forelse ($events as $e)
                                <tr>
                                    <td><strong>{{ $e->event_date }}</strong></td>
                                    <td>{{ $e->title }}</td>
                                    <td><span class="event-tag tag-{{ $e->category }}">{{ $e->category }}</span></td>
                                    <td>
                                        <button class="btn btn-outline-light" onclick="deleteEvent({{ $e->id }})" style="background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.2); color:#fca5a5; padding:5px 10px; font-size:0.8rem; cursor:pointer;">
                                            Fshi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center; color:var(--text-secondary);">Nuk ka ngjarje të regjistruara.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Users Management (Admin) -->
            <div id="view-users" class="view-panel">
                <div class="students-table-wrap">
                    <table class="students-table">
                        <thead><tr><th>Emri</th><th>Email</th><th>Roli</th><th>Data</th></tr></thead>
                        <tbody id="usersTableBody">
                            @forelse ($users as $u)
                                <tr>
                                    <td>{{ $u->full_name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td><span class="event-tag tag-{{ $u->role }}">{{ $u->role }}</span></td>
                                    <td>{{ $u->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center; color:var(--text-secondary);">Nuk ka përdorues në sistem.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Safeguarding Reports (Admin) -->
            <div id="view-safeguarding" class="view-panel">
                <div class="students-table-wrap">
                    <table class="students-table">
                        <thead><tr><th>Raportuesi</th><th>Kategoria</th><th>Mesazhi</th><th>Data</th></tr></thead>
                        <tbody id="safeguardingTableBody">
                            @forelse ($reports as $rep)
                                <tr>
                                    <td>{{ $rep->is_anonymous ? 'Anonim' : $rep->reporter_name . ' (' . $rep->reporter_email . ')' }}</td>
                                    <td><span class="event-tag tag-{{ $rep->category }}">{{ $rep->category }}</span></td>
                                    <td>{{ $rep->message }}</td>
                                    <td>{{ $rep->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center; color:var(--text-secondary);">Nuk ka raportime.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Logs (Admin) -->
            <div id="view-audit" class="view-panel">
                <div class="students-table-wrap">
                    <table class="students-table">
                        <thead><tr><th>Aktori</th><th>Veprimi</th><th>Lloji</th><th>Data</th></tr></thead>
                        <tbody id="auditTableBody">
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ $log->actor_name ?? 'Sistemi' }}</td>
                                    <td>{{ $log->action_name }}</td>
                                    <td>{{ $log->target_type }}</td>
                                    <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center; color:var(--text-secondary);">Nuk ka logime auditimi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        <section class="view-panel" id="view-settings">
            <div class="settings-grid">
                <div class="setting-card">
                    <h3><i class="fa-solid fa-user-gear"></i> Profili</h3>
                    <div class="setting-row">
                        <span>Emri në panel</span>
                        <input type="text" id="settingDisplayName" placeholder="p.sh. Prof. Arta D.">
                    </div>
                </div>
                <div class="setting-card">
                    <h3><i class="fa-solid fa-bell"></i> Njoftimet</h3>
                    <div class="setting-row">
                        <span>Njoftime për takime</span>
                        <select id="settingNotifications">
                            <option value="on">Aktive</option>
                            <option value="off">Joaktive</option>
                        </select>
                    </div>
                </div>
                <div class="setting-card">
                    <h3><i class="fa-solid fa-language"></i> Gjuha / Tema</h3>
                    <div class="setting-row">
                        <span>Gjuha e panelit</span>
                        <select id="settingLanguage">
                            <option value="sq">Shqip</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div>
            </div>
            <div style="margin-top:20px; display:flex; gap:12px; flex-wrap:wrap;">
                <button class="btn btn-primary" id="saveSettingsBtn"><i class="fa-solid fa-floppy-disk"></i> Ruaj Cilësimet</button>
                <button class="btn btn-outline-light" id="resetSettingsBtn"><i class="fa-solid fa-rotate-left"></i> Rikthe Default</button>
            </div>
        </section>

        <section class="view-panel" id="view-resources">
            <div class="students-toolbar">
                <input class="students-search" id="resTitle" type="text" placeholder="Titulli i materialit (p.sh. Ushtrime Matematika)">
                <select class="students-search" id="resCategory" style="max-width:180px;">
                    <option value="Materiale Mësimore">Materiale Mësimore</option>
                    <option value="Leksione">Leksione</option>
                    <option value="Teste Modele">Teste Modele</option>
                    <option value="Tjetër">Tjetër</option>
                </select>
                <input type="file" id="resFile" style="display:none;">
                <button class="btn btn-outline-light" onclick="document.getElementById('resFile').click()"><i class="fa-solid fa-file-import"></i> Zgjidh Fajllin</button>
                <button class="btn btn-primary" id="uploadResBtn"><i class="fa-solid fa-cloud-arrow-up"></i> Ngarko</button>
            </div>
            <div class="students-table-wrap">
                <table class="students-table">
                    <thead><tr><th>Titulli</th><th>Kategoria</th><th>Ngarkuar nga</th><th>Data</th><th>Veprim</th></tr></thead>
                    <tbody id="resourcesTableBody2">
                        @forelse ($resources as $r)
                            <tr>
                                <td><a href="{{ $r->file_path }}" target="_blank" style="color:#93c5fd; text-decoration:none;">{{ $r->title }}</a></td>
                                <td><span class="event-tag tag-activity">{{ $r->category }}</span></td>
                                <td>{{ $r->uploader_name }}</td>
                                <td>{{ $r->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <button class="btn btn-outline-light" onclick="deleteResource({{ $r->id }})" style="background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.2); color:#fca5a5; padding:5px 10px; font-size:0.8rem; cursor:pointer;">
                                        Fshi
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; color:var(--text-secondary);">Nuk ka materiale të ngarkuara.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="dashboard.js?v=final"></script>
    <div id="dashToastWrap" class="dash-toast-wrap"></div>
    
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
