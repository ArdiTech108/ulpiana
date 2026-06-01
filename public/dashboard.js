/**
 * Dashboard Logic for Gjimnazi "Ulpiana"
 * Handles Teacher and Admin views
 */

const API_BASE = 'api.php';
let currentUser = null;
let csrfToken = '';
let allBookingsCache = [];

async function api(action, method = 'GET', data = null) {
  const makeReq = async () => {
    const url = `${API_BASE}?action=${action}`;
    const options = {
      method,
      headers: {},
      credentials: 'same-origin'
    };
    if (method !== 'GET' && csrfToken) options.headers['X-CSRF-Token'] = csrfToken;
    if (data) {
      if (data instanceof FormData) {
        options.body = data;
      } else {
        options.headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(data);
      }
    }
    const res = await fetch(url, options);
    const json = await res.json();
    if (!res.ok) throw new Error(json.message || 'Gabim nga serveri');
    return json;
  };

  try {
    return await makeReq();
  } catch (err) {
    if (/CSRF/i.test(err.message || '') && method !== 'GET') {
      const t = await fetch(`${API_BASE}?action=csrf`, { credentials: 'same-origin' }).then(r => r.json());
      csrfToken = t.csrfToken || csrfToken;
      return await makeReq();
    }
    throw err;
  }
}

function toast(msg, type = 'success') {
  const t = document.createElement('div');
  t.className = `toast toast-${type}`;
  t.innerText = msg;
  document.body.appendChild(t);
  setTimeout(() => t.classList.add('show'), 100);
  setTimeout(() => {
    t.classList.remove('show');
    setTimeout(() => t.remove(), 300);
  }, 3000);
}

function esc(str) {
  if (!str) return '';
  const div = document.createElement('div');
  div.innerText = str;
  return div.innerHTML;
}

function setBtnLoading(btn, isLoading, text = 'Duke u procesuar...') {
  if (!btn) return;
  if (isLoading) {
    btn.dataset.original = btn.innerHTML;
    btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> ${text}`;
    btn.disabled = true;
  } else {
    btn.innerHTML = btn.dataset.original;
    btn.disabled = false;
  }
}

document.addEventListener('DOMContentLoaded', async () => {
  try {
    const who = await api('whoami');
    if (!who.user || !['admin', 'teacher'].includes(who.user.role)) {
      window.location.href = 'index.html';
      return;
    }
    currentUser = who.user;
    csrfToken = who.csrfToken || '';
    hydrateProfile();
    // await loadMeetings(); // Pre-populated server-side by Blade
    initSidebarViews();
    initStudentsSection();
    initSettingsSection();
    initGradesSection();
    initAnnouncementsSection();
    initResourcesSection();
    initAdminSections();
    initCalendarSection();
    initPrintAction();
    // loadAnalytics(); // Pre-populated server-side by Blade
  } catch (err) {
    console.error(err);
    window.location.href = 'index.html';
  }
});

function hydrateProfile() {
  const dAvatar = document.getElementById('dAvatar');
  const dName = document.getElementById('dName');
  const dSubject = document.getElementById('dSubject');
  if (!dAvatar || !dName || !dSubject) return;

  if (currentUser.role === 'admin') {
    dAvatar.innerHTML = '<i class="fa-solid fa-users"></i>';
    dName.innerText = 'Drejtoria / Profesorët';
    dSubject.innerText = 'Të gjitha terminet aktive';
  } else {
    const initials = (currentUser.full_name || 'P').split(' ').map(s => s[0]).join('').toUpperCase();
    dAvatar.innerText = initials;
    dName.innerText = currentUser.full_name;
    dSubject.innerText = currentUser.email;
  }
}

async function loadMeetings() {
  const body = document.getElementById('meetingsTableBody');
  if (!body) return;
  try {
    const data = await api('get_bookings');
    allBookingsCache = data.bookings || [];
    if (!allBookingsCache.length) {
      body.innerHTML = '<tr><td colspan="7" class="text-center" style="padding:40px; color:var(--text-secondary);">Nuk ka takime të rezervuara.</td></tr>';
      return;
    }
    body.innerHTML = allBookingsCache.map(b => `
      <tr>
        <td>${esc(b.student_name)}</td>
        <td>${esc(b.parent_name)}</td>
        <td>${esc(b.topic || 'Konsultime')}</td>
        <td>${esc(b.slot_time)}</td>
        <td><span class="badge ${b.status || 'pending'}">${(b.status || 'në pritje').toUpperCase()}</span></td>
        <td>
          <button class="btn btn-outline-light" style="padding:4px 8px;font-size:0.8rem;" onclick="updateBookingStatus(${b.id}, 'accepted', this)">Prano</button>
          <button class="btn btn-outline-light" style="padding:4px 8px;font-size:0.8rem;color:#fca5a5;" onclick="updateBookingStatus(${b.id}, 'rejected', this)">Anulo</button>
        </td>
      </tr>
    `).join('');
  } catch (e) {
    toast('Dështoi ngarkimi i takimeve.', 'error');
  }
}

async function updateBookingStatus(id, status, btnEl) {
  try {
    setBtnLoading(btnEl, true, '...');
    await api('update_booking_status', 'POST', { id, status });
    toast('Statusi u ndryshua.');
    await loadMeetings();
  } catch (e) {
    toast(e.message, 'error');
  } finally {
    setBtnLoading(btnEl, false);
  }
}
window.updateBookingStatus = updateBookingStatus;

function initSidebarViews() {
  const menu = document.getElementById('sidebarMenu');
  if (!menu) return;

  // Thjeshto panelin për jo-admin
  if (currentUser.role !== 'admin') {
    const adminViews = ['users', 'safeguarding', 'audit', 'calendar'];
    adminViews.forEach(v => {
      const link = menu.querySelector(`a[data-view="${v}"]`);
      if (link && link.parentElement) link.parentElement.style.display = 'none';
    });
  }

  const navLinks = document.querySelectorAll('#sidebarMenu a[data-view]');
  const viewTitle = document.getElementById('viewTitle');
  const viewDesc = document.getElementById('viewDesc');
  
  const meta = {
    meetings: { title: 'Paneli i Profesorit', desc: 'Menaxhimi i takimeve me prindër' },
    students: { title: 'Të Gjithë Nxënësit', desc: 'Përmbledhje e nxënësve nga takimet' },
    settings: { title: 'Cilësimet', desc: 'Personalizoni llogarinë tuaj' },
    grades: { title: 'Vlerësimet', desc: 'Regjistrimi dhe publikimi i notave' },
    announcements: { title: 'Njoftime', desc: 'Publiko lajme për shkollën' },
    resources: { title: 'Libraria Digjitale', desc: 'Ngarkoni materiale mësimore' },
    calendar: { title: 'Kalendari Shkollor', desc: 'Menaxho datat e provimeve dhe aktiviteteve' },
    users: { title: 'Menaxhimi', desc: 'Shto profesorë të rinj' },
    safeguarding: { title: 'Raportimet', desc: 'Shiko shqetësimet e nxënësve' },
    audit: { title: 'Audit Logs', desc: 'Gjurmët e veprimeve' }
  };

  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const view = link.dataset.view;
      navLinks.forEach(l => l.parentElement.classList.remove('active'));
      link.parentElement.classList.add('active');
      
      document.querySelectorAll('.view-panel').forEach(p => p.classList.remove('active'));
      const target = document.getElementById(`view-${view}`);
      if (target) target.classList.add('active');
      
      if (meta[view]) {
        viewTitle.innerText = meta[view].title;
        viewDesc.innerText = meta[view].desc;
      }
    });
  });
}

function initStudentsSection() {
  const search = document.getElementById('studentsSearch');
  if (!search) return;
  search.addEventListener('input', (e) => {
    const q = e.target.value.toLowerCase();
    const filtered = allBookingsCache.filter(b => 
      b.student_name.toLowerCase().includes(q) || 
      b.parent_name.toLowerCase().includes(q)
    );
    renderStudentsTable(filtered);
  });

  const exportBtn = document.getElementById('studentsExportBtn');
  if (exportBtn) {
    exportBtn.addEventListener('click', () => {
      if (!allBookingsCache.length) return toast('Nuk ka të dhëna.', 'error');
      const csv = "Nxënësi,Prindi,Data\n" + allBookingsCache.map(b => `${b.student_name},${b.parent_name},${b.slot_time}`).join("\n");
      const blob = new Blob([csv], { type: 'text/csv' });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'nxenesit.csv';
      a.click();
    });
  }
}

function renderStudentsTable(rows) {
  const body = document.getElementById('studentsTableBody');
  if (!body) return;
  body.innerHTML = rows.map(b => `
    <tr>
      <td>${esc(b.student_name)}</td>
      <td>${esc(b.parent_name)}</td>
      <td>${esc(b.teacher_name)}</td>
      <td>${esc(b.teacher_subject)}</td>
      <td>${esc(b.slot_time)}</td>
      <td>${esc(b.topic || '-')}</td>
    </tr>
  `).join('');
}

async function initSettingsSection() {
  const saveBtn = document.getElementById('saveSettingsBtn');
  if (!saveBtn) return;
  
  try {
    const data = await api('get_settings');
    const s = data.settings || {};
    if (document.getElementById('settingDisplayName')) document.getElementById('settingDisplayName').value = s.display_name || '';
  } catch (e) {}

  saveBtn.addEventListener('click', async () => {
    const name = document.getElementById('settingDisplayName').value;
    try {
      setBtnLoading(saveBtn, true);
      await api('save_settings', 'POST', { displayName: name });
      toast('Cilësimet u ruajtën.');
    } catch (e) {
      toast(e.message, 'error');
    } finally {
      setBtnLoading(saveBtn, false);
    }
  });
}

async function initGradesSection() {
  const btn = document.getElementById('saveGradeBtn');
  if (!btn) return;
  btn.addEventListener('click', async () => {
    const payload = {
      studentName: document.getElementById('gradeStudent').value,
      subject: document.getElementById('gradeSubject').value,
      gradeValue: document.getElementById('gradeValue').value,
      commentText: document.getElementById('gradeComment').value,
      isPublished: 0
    };
    if (!payload.studentName || !payload.gradeValue) return toast('Plotëso fushat.', 'error');
    try {
      setBtnLoading(btn, true);
      await api('save_grade', 'POST', payload);
      toast('Nota u ruajt.');
      loadGrades();
    } catch (e) { toast(e.message, 'error'); }
    finally { setBtnLoading(btn, false); }
  });
  // loadGrades(); // Pre-populated server-side by Blade
}

async function loadGrades() {
  const body = document.getElementById('gradesTableBody');
  if (!body) return;
  const data = await api('list_grades');
  body.innerHTML = (data.grades || []).map(g => `
    <tr>
      <td>${esc(g.student_name)}</td>
      <td>${esc(g.subject)}</td>
      <td>${esc(g.grade_value)}</td>
      <td>${esc(g.comment_text)}</td>
      <td>${g.is_published ? 'PO' : 'JO'}</td>
      <td><button class="btn btn-outline-light" onclick="toggleGrade(${g.id}, ${g.is_published?0:1})">${g.is_published?'Fshih':'Publiko'}</button></td>
    </tr>
  `).join('');
}

async function toggleGrade(id, pub) {
  await api('publish_grade', 'POST', { id, isPublished: pub });
  loadGrades();
}
window.toggleGrade = toggleGrade;

async function initAnnouncementsSection() {
  const btn = document.getElementById('saveAnnouncementBtn');
  if (!btn) return;
  btn.addEventListener('click', async () => {
    const title = document.getElementById('annTitle').value;
    const content = document.getElementById('annContent').value;
    try {
      setBtnLoading(btn, true);
      await api('create_announcement', 'POST', { title, content });
      toast('Njoftimi u dërgua.');
      loadAnnouncements();
    } catch (e) { toast(e.message, 'error'); }
    finally { setBtnLoading(btn, false); }
  });
  // loadAnnouncements(); // Pre-populated server-side by Blade
}

async function loadAnnouncements() {
  // Logic to load announcements if needed in a table
}

async function initResourcesSection() {
  const btn = document.getElementById('uploadResBtn');
  if (!btn) return;
  btn.addEventListener('click', async () => {
    const file = document.getElementById('resFile').files[0];
    const title = document.getElementById('resTitle').value;
    const cat = document.getElementById('resCategory').value;
    if (!file || !title) return toast('Zgjidh skedarin dhe titullin.', 'error');
    
    const fd = new FormData();
    fd.append('file', file);
    fd.append('title', title);
    fd.append('category', cat);
    
    try {
      setBtnLoading(btn, true);
      const res = await fetch('api.php?action=upload_resource', {
        method: 'POST',
        headers: { 'X-CSRF-Token': csrfToken },
        body: fd
      }).then(r => r.json());
      if (!res.ok) throw new Error(res.message);
      toast('Materiali u ngarkua.');
      loadResources();
    } catch (e) { toast(e.message, 'error'); }
    finally { setBtnLoading(btn, false); }
  });
  // loadResources(); // Pre-populated server-side by Blade
}

async function loadResources() {
  const body = document.getElementById('resourcesTableBody');
  const body2 = document.getElementById('resourcesTableBody2');
  if (!body && !body2) return;
  const data = await api('list_resources');
  const html = (data.resources || []).map(r => `
    <tr>
      <td><a href="${esc(r.file_path)}" target="_blank" style="color:#93c5fd; text-decoration:none;">${esc(r.title)}</a></td>
      <td><span class="event-tag tag-activity">${esc(r.category)}</span></td>
      <td>${esc(r.uploader_name)}</td>
      <td>${esc(r.created_at)}</td>
      <td><button class="btn btn-outline-light" onclick="deleteRes(${r.id})">Fshij</button></td>
    </tr>
  `).join('');
  if (body) body.innerHTML = html;
  if (body2) body2.innerHTML = html;
}

async function deleteRes(id) {
  await api('delete_resource', 'POST', { id });
  loadResources();
}
window.deleteRes = deleteRes;

function initAdminSections() {
  if (currentUser.role !== 'admin') return;
  
  // Show admin links in sidebar
  document.querySelectorAll('.admin-only').forEach(li => li.style.display = 'block');
  
  // loadAdminUsers(); // Pre-populated server-side by Blade
  // loadSafeguarding(); // Pre-populated server-side by Blade
  // loadAuditLogs(); // Pre-populated server-side by Blade
}

async function loadAdminUsers() {
  const body = document.getElementById('usersTableBody');
  if (!body) return;
  const data = await api('list_users');
  body.innerHTML = (data.users || []).map(u => `
    <tr><td>${esc(u.full_name)}</td><td>${esc(u.email)}</td><td>${u.role}</td><td>${u.created_at}</td></tr>
  `).join('');
}

async function loadSafeguarding() {
  const body = document.getElementById('safeguardingTableBody');
  if (!body) return;
  const data = await api('list_safeguarding');
  body.innerHTML = (data.reports || []).map(r => `
    <tr><td>${esc(r.reporter_name)}</td><td>${esc(r.category)}</td><td>${esc(r.message_text)}</td><td>${r.created_at}</td></tr>
  `).join('');
}

async function loadAuditLogs() {
  const body = document.getElementById('auditTableBody');
  if (!body) return;
  const data = await api('list_audit_logs');
  body.innerHTML = (data.logs || []).map(l => `
    <tr><td>${esc(l.actor_name || 'System')}</td><td>${esc(l.action_name)}</td><td>${esc(l.target_type)}</td><td>${l.created_at}</td></tr>
  `).join('');
}

async function loadAnalytics() {
  const wrap = document.getElementById('analyticsCards');
  if (!wrap) return;
  const data = await api('dashboard_analytics');
  const a = data.analytics || {};
  wrap.innerHTML = `
    <div class="setting-card"><h3>Termine</h3><p>${a.totalBookings || 0}</p></div>
    <div class="setting-card"><h3>Pranuar</h3><p>${a.acceptedBookings || 0}</p></div>
    <div class="setting-card"><h3>Nxënës</h3><p>${a.totalStudents || 0}</p></div>
  `;
}

function initPrintAction() {
  const btn = document.getElementById('printReportBtn');
  if (btn) btn.addEventListener('click', () => window.print());
}

async function logout() {
  try {
    await api('logout', 'POST');
    toast('Keni dalë nga sistemi me sukses.');
    setTimeout(() => {
      window.location.href = 'index.html';
    }, 300);
  } catch (err) {
    toast(err.message || 'Nuk u realizua dalja nga sistemi.', 'error');
  }
}
window.logout = logout;

function initCalendarSection() {
  if (currentUser.role !== 'admin') return;
  const form = document.getElementById('eventForm');
  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = form.querySelector('button[type="submit"]');
      const payload = {
        title: document.getElementById('eventTitle').value,
        description: document.getElementById('eventDesc').value,
        event_date: document.getElementById('eventDate').value,
        category: document.getElementById('eventCategory').value
      };
      try {
        setBtnLoading(btn, true);
        await api('create_event', 'POST', payload);
        form.reset();
        toast('Ngjarja u shtua me sukses!');
        loadCalendarEvents();
      } catch (err) {
        toast(err.message, 'error');
      } finally {
        setBtnLoading(btn, false);
      }
    });
  }
  // loadCalendarEvents(); // Pre-populated server-side by Blade
}

async function loadCalendarEvents() {
  const body = document.getElementById('eventsTableBody');
  if (!body) return;
  const data = await api('list_events');
  body.innerHTML = (data.events || []).map(e => `
    <tr>
      <td>${esc(e.event_date)}</td>
      <td>${esc(e.title)}</td>
      <td>${esc(e.category)}</td>
      <td><button class="btn btn-outline-light" onclick="deleteEvent(${e.id})">Fshij</button></td>
    </tr>
  `).join('');
}

async function deleteEvent(id) {
  if (!confirm('A jeni të sigurt?')) return;
  await api('delete_event', 'POST', { id });
  loadCalendarEvents();
}
window.deleteEvent = deleteEvent;
