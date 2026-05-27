document.addEventListener('DOMContentLoaded', async () => {
    // Check if logged in and role is student
    let user = null;
    let csrfToken = '';

    async function api(action, method = 'GET') {
        const opt = { method, headers: {}, credentials: 'same-origin' };
        if (method !== 'GET' && csrfToken) opt.headers['X-CSRF-Token'] = csrfToken;
        const res = await fetch(`api.php?action=${encodeURIComponent(action)}`, opt);
        const data = await res.json();
        if (!data.ok) throw new Error(data.message || 'Gabim nga serveri');
        return data;
    }

    try {
        const data = await api('whoami');
        if (!data.ok || !data.user || data.user.role !== 'student') {
            window.location.href = 'index.html';
            return;
        }
        user = data.user;
        csrfToken = data.csrfToken || '';
        document.getElementById('sName').innerText = user.full_name;
        document.getElementById('sAvatar').innerText = user.full_name.charAt(0).toUpperCase();
    } catch (e) {
        window.location.href = 'index.html';
    }

    // Navigation
    const links = document.querySelectorAll('.sidebar-menu a');
    const panels = document.querySelectorAll('.view-panel');
    const viewTitle = document.getElementById('viewTitle');
    const viewDesc = document.getElementById('viewDesc');

    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const view = link.dataset.view;
            
            links.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
            
            panels.forEach(p => p.classList.remove('active'));
            document.getElementById(`view-${view}`).classList.add('active');

            if (view === 'grades') { viewTitle.innerText = 'Notat e Mia'; viewDesc.innerText = 'Suksesi juaj akademik'; loadGrades(); }
            if (view === 'resources') { viewTitle.innerText = 'Libraria Digjitale'; viewDesc.innerText = 'Materiale mësimore për shkarkim'; loadResources(); }
            if (view === 'news') { viewTitle.innerText = 'Njoftimet'; viewDesc.innerText = 'Lajmet e fundit nga shkolla'; loadNews(); }
        });
    });

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', async () => {
        try {
            await api('logout', 'POST');
        } catch (_) {}
        window.location.href = 'index.html';
    });

    // Data Loaders
    async function loadGrades() {
        const list = document.getElementById('gradesList');
        list.innerHTML = '<p>Duke u ngarkuar...</p>';
        try {
            const data = await api('list_grades');
            const grades = data.grades || [];
            if (!grades.length) {
                list.innerHTML = '<div class="empty-dash"><i class="fa-solid fa-face-smile"></i><h3>Nuk ka nota ende.</h3><p>Sapo profesori të vendosë notën, do të shfaqet këtu.</p></div>';
                return;
            }
            list.innerHTML = grades.map(g => `
                <div class="grade-card">
                    <div style="display:flex; gap:20px; align-items:center;">
                        <div class="grade-val">${g.grade_value}</div>
                        <div class="grade-info">
                            <h4>${g.subject}</h4>
                            <p>${g.comment_text || 'Pa koment'}</p>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <small style="color:var(--text-secondary)">Data: ${g.created_at.split(' ')[0]}</small>
                    </div>
                </div>
            `).join('');
        } catch (e) {
            list.innerHTML = '<p style="color:red">Gabim gjatë ngarkimit.</p>';
        }
    }

    async function loadResources() {
        const list = document.getElementById('resourcesList');
        list.innerHTML = '<tr><td colspan="4">Duke u ngarkuar...</td></tr>';
        try {
            const data = await api('list_resources');
            const items = data.resources || [];
            if (!items.length) {
                list.innerHTML = '<tr><td colspan="4">Nuk ka materiale për momentin.</td></tr>';
                return;
            }
            list.innerHTML = items.map(r => `
                <tr>
                    <td style="color:white; font-weight:600">${r.title}</td>
                    <td>${r.category}</td>
                    <td>${r.created_at.split(' ')[0]}</td>
                    <td><a href="${r.file_path}" target="_blank" class="btn btn-outline-light" style="padding:5px 10px; font-size:0.8rem">Shkarko</a></td>
                </tr>
            `).join('');
        } catch (e) {
            list.innerHTML = '<tr><td colspan="4" style="color:#fca5a5;">Gabim gjatë ngarkimit të materialeve.</td></tr>';
        }
    }

    async function loadNews() {
        const list = document.getElementById('newsList');
        list.innerHTML = '<p>Duke u ngarkuar...</p>';
        try {
            const data = await api('list_announcements');
            const news = data.announcements || [];
            if (!news.length) {
                list.innerHTML = '<p>Nuk ka njoftime për momentin.</p>';
                return;
            }
            list.innerHTML = news.map(n => `
                <div class="grade-card" style="flex-direction:column; align-items:flex-start; gap:10px;">
                    <h4 style="color:var(--accent)">${n.title}</h4>
                    <p style="color:white">${n.content}</p>
                    <small style="color:var(--text-secondary)">${n.created_at}</small>
                </div>
            `).join('');
        } catch (e) {
            list.innerHTML = '<p style="color:#fca5a5;">Gabim gjatë ngarkimit të njoftimeve.</p>';
        }
    }

    // Initial load
    loadGrades();
});
