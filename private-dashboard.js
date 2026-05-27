const API_BASE = 'api.php';
let csrfToken = '';

async function api(action, method = 'GET', body = null) {
  const opt = { method, headers: {}, credentials: 'same-origin' };
  if (method !== 'GET' && csrfToken) opt.headers['X-CSRF-Token'] = csrfToken;
  if (body) {
    opt.headers['Content-Type'] = 'application/json';
    opt.body = JSON.stringify(body);
  }
  const res = await fetch(`${API_BASE}?action=${encodeURIComponent(action)}`, opt);
  const data = await res.json();
  if (!data.ok) throw new Error(data.message || 'Gabim');
  return data;
}

function setMsg(id, text, isErr = false) {
  const el = document.getElementById(id);
  if (!el) return;
  el.className = isErr ? 'err' : 'ok';
  el.textContent = text;
}

function renderRows(rows = []) {
  const tbody = document.getElementById('rows');
  if (!tbody) return;
  tbody.innerHTML = rows.map(r => `
    <tr>
      <td>${r.id}</td>
      <td>${(r.title || '').replace(/</g, '&lt;')}</td>
      <td>${r.publish_at || '-'}</td>
      <td>${r.status || '-'}</td>
      <td>${r.published_at || '-'}</td>
    </tr>
  `).join('');
}

async function refreshScheduled() {
  try {
    const d = await api('private_list_scheduled_posts');
    renderRows(d.posts || []);
  } catch (e) {
    setMsg('actionMsg', e.message, true);
  }
}

function setAuthenticatedUI(on) {
  document.getElementById('loginCard').style.display = on ? 'none' : 'block';
  document.getElementById('app').style.display = on ? 'block' : 'none';
}

document.getElementById('loginBtn').addEventListener('click', async () => {
  const key = document.getElementById('privateKey').value.trim();
  try {
    await api('private_login', 'POST', { key });
    setMsg('loginMsg', 'Kyçja private u kry me sukses.');
    setAuthenticatedUI(true);
    await refreshScheduled();
  } catch (e) {
    setMsg('loginMsg', e.message, true);
  }
});

document.getElementById('scheduleBtn').addEventListener('click', async () => {
  const prompt = document.getElementById('prompt').value.trim();
  try {
    await api('private_schedule_from_prompt', 'POST', { prompt });
    setMsg('actionMsg', 'Postimi u planifikua me sukses.');
    document.getElementById('prompt').value = '';
    await refreshScheduled();
  } catch (e) {
    setMsg('actionMsg', e.message, true);
  }
});

document.getElementById('publishDueBtn').addEventListener('click', async () => {
  try {
    const d = await api('private_publish_due_posts', 'POST');
    setMsg('actionMsg', `U publikuan ${d.published || 0} postime.`);
    await refreshScheduled();
  } catch (e) {
    setMsg('actionMsg', e.message, true);
  }
});

document.getElementById('logoutBtn').addEventListener('click', async () => {
  try {
    await api('private_logout', 'POST');
    setAuthenticatedUI(false);
    setMsg('loginMsg', 'Dole nga dashboard-i privat.');
  } catch (e) {
    setMsg('actionMsg', e.message, true);
  }
});

document.getElementById('manualCreateBtn').addEventListener('click', async () => {
  try {
    const fd = new FormData();
    fd.append('title', document.getElementById('manualTitle').value.trim());
    fd.append('content', document.getElementById('manualContent').value.trim());
    fd.append('publishAt', document.getElementById('manualPublishAt').value.trim());
    fd.append('audience', document.getElementById('manualAudience').value);
    fd.append('prompt', 'manual_create');

    const img = document.getElementById('manualImage').files[0];
    if (img) fd.append('image', img);

    const res = await fetch(`${API_BASE}?action=private_create_scheduled_post`, {
      method: 'POST',
      headers: csrfToken ? { 'X-CSRF-Token': csrfToken } : {},
      credentials: 'same-origin',
      body: fd
    });
    const data = await res.json();
    if (!data.ok) throw new Error(data.message || 'Gabim gjatë ruajtjes');

    setMsg('actionMsg', 'Postimi u ruajt me sukses (edhe foto nëse u ngarkua).');
    document.getElementById('manualTitle').value = '';
    document.getElementById('manualContent').value = '';
    document.getElementById('manualPublishAt').value = '';
    document.getElementById('manualImage').value = '';
    await refreshScheduled();
  } catch (e) {
    setMsg('actionMsg', e.message, true);
  }
});

(async function init() {
  try {
    const who = await api('private_whoami');
    csrfToken = who.csrfToken || '';
    const auth = !!who.authenticated;
    setAuthenticatedUI(auth);
    if (auth) await refreshScheduled();
  } catch {
    setAuthenticatedUI(false);
  }
})();
