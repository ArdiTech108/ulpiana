// --- Custom Cursor (Disabled for performance) ---

// --- Navigation & Scroll ---
const navbar = document.getElementById('navbar');
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobileMenu');
const navLinks = document.querySelectorAll('.nav-link');

let scrollRaf = null;
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        if (navbar) navbar.classList.add('scrolled');
    } else {
        if (navbar) navbar.classList.remove('scrolled');
    }
    if (!scrollRaf) {
        scrollRaf = requestAnimationFrame(() => {
            updateActiveLinks();
            scrollRaf = null;
        });
    }
}, { passive: true });

if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        mobileMenu.classList.toggle('active');
    });
}

document.querySelectorAll('.mobile-link').forEach(link => {
    link.addEventListener('click', () => {
        if (hamburger) hamburger.classList.remove('active');
        if (mobileMenu) mobileMenu.classList.remove('active');
    });
});

function updateActiveLinks() {
    let current = '';
    const sections = document.querySelectorAll('section');
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (scrollY >= sectionTop - 200) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').includes(current)) {
            link.classList.add('active');
        }
    });
}

// --- Reveal Animations ---
const revealElements = document.querySelectorAll('.reveal');
const revealObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
            
            // Trigger counters if it's the stats section
            if(entry.target.querySelector('.counter')) {
                const counters = entry.target.querySelectorAll('.counter');
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const duration = 2000; // 2 seconds
                    const increment = target / (duration / 16); // 60fps
                    let current = 0;
                    
                    const updateCounter = () => {
                        current += increment;
                        if (current < target) {
                            counter.innerText = Math.ceil(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    updateCounter();
                });
            }
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.15, rootMargin: "0px 0px -50px 0px" });

revealElements.forEach(el => revealObserver.observe(el));


// --- Modals ---
const authModal = document.getElementById('authModal');
const imageLightbox = document.getElementById('imageLightbox');
const lightboxImg = document.getElementById('lightboxImg');

function openAuthModal() {
    authModal.classList.add('active');
    document.body.style.overflow = 'hidden';
    resetAuthModalState();
}

function closeAuthModal() {
    authModal.classList.remove('active');
    document.body.style.overflow = '';
    resetAuthModalState();
}

function resetAuthModalState() {
    // Rikthe modalin gjithmonë në login clean state
    const loginTab = document.getElementById('tabLoginBtn');
    const signupTab = document.getElementById('tabSignupBtn');
    if (loginTab && signupTab) {
        loginTab.classList.add('active');
        signupTab.classList.remove('active');
    }
    switchAuthView('formLogin');

    const authTitle = document.getElementById('authTitle');
    const authDesc = document.getElementById('authDesc');
    if (authTitle) authTitle.innerText = 'Hyrja në Platformë';
    if (authDesc) authDesc.innerText = 'Identifikohuni për të rezervuar takime ose regjistrohuni si përdorues i ri.';
}

function openImage(src) {
    imageLightbox.classList.add('active');
    lightboxImg.src = src;
    document.body.style.overflow = 'hidden';
}

function closeImage() {
    imageLightbox.classList.remove('active');
    document.body.style.overflow = '';
}

// Video Modal
const videoModal = document.getElementById('videoModal');
const youtubeIframe = document.getElementById('youtubeIframe');

function openVideoModal(videoId) {
    youtubeIframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
    videoModal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeVideoModal() {
    videoModal.classList.remove('active');
    youtubeIframe.src = '';
    document.body.style.overflow = '';
}

// Auth Tabs
function switchAuthTab(type) {
    document.getElementById('tabLoginBtn').classList.remove('active');
    document.getElementById('tabSignupBtn').classList.remove('active');
    document.getElementById('formLogin').classList.remove('active');
    document.getElementById('formSignup').classList.remove('active');
    const forgotForm = document.getElementById('formForgot');
    const resetForm = document.getElementById('formReset');
    if (forgotForm) forgotForm.classList.remove('active');
    if (resetForm) resetForm.classList.remove('active');
    
    document.getElementById('authTitle').innerText = type === 'login' ? 'Hyrja në Platformë' : 'Krijo Llogari të Re';
    document.getElementById('authDesc').innerText = type === 'login' ? 'Identifikohuni për të rezervuar takime ose regjistrohuni si përdorues i ri.' : 'Plotësoni të dhënat për t\'u bërë pjesë e platformës dixhitale.';

    if(type === 'login') {
        document.getElementById('tabLoginBtn').classList.add('active');
        document.getElementById('formLogin').classList.add('active');
    } else {
        document.getElementById('tabSignupBtn').classList.add('active');
        document.getElementById('formSignup').classList.add('active');
    }
}

function switchAuthView(view) {
    const forms = ['formLogin', 'formSignup', 'formForgot', 'formReset'];
    forms.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.classList.remove('active');
    });
    const target = document.getElementById(view);
    if (target) target.classList.add('active');
}


// --- Dynamic Booking System ---
let TEACHERS_DB = [
    { id: 't1', name: 'Hysri Rrahmani', subject: 'Gjuhë Shqipe', initials: 'HR', email: 'hysri.rrahmani@ulpiana.edu' },
    { id: 't2', name: 'Sebahate Gashi', subject: 'Gjuhë Shqipe', initials: 'SG', email: 'sebahate.gashi@ulpiana.edu' },
    { id: 't3', name: 'Sebahate Lekaj', subject: 'Gjuhë Shqipe', initials: 'SL', email: 'sebahate.lekaj@ulpiana.edu' },
    { id: 't4', name: 'Shqipe Jashanica', subject: 'Gjuhë Shqipe', initials: 'SJ', email: 'shqipe.jashanica@ulpiana.edu' },
    { id: 't5', name: 'Ylber Shala', subject: 'Gjuhë Shqipe', initials: 'YSH', email: 'ylber.shala@ulpiana.edu' },
    { id: 't6', name: 'Arlinda Ademi', subject: 'Gjuhë Shqipe', initials: 'AA', email: 'arlinda.ademi@ulpiana.edu' },
    { id: 't7', name: 'Luljeta Retkoceri', subject: 'Gjuhë Shqipe', initials: 'LR', email: 'luljeta.retkoceri@ulpiana.edu' },
    { id: 't8', name: 'Albana Haliti', subject: 'Gjuhë Shqipe', initials: 'AH', email: 'albana.haliti@ulpiana.edu' },
    { id: 't9', name: 'Ylber Dedushi', subject: 'Gjuhë Angleze', initials: 'YD', email: 'ylber.dedushi@ulpiana.edu' },
    { id: 't10', name: 'Besa Tmava', subject: 'Gjuhë Angleze', initials: 'BT', email: 'besa.tmava@ulpiana.edu' },
    { id: 't11', name: 'Fitim Mustafa', subject: 'Gjuhë Angleze', initials: 'FM', email: 'fitim.mustafa@ulpiana.edu' },
    { id: 't12', name: 'Albulena Kelmendi', subject: 'Gjuhë Angleze', initials: 'AK', email: 'albulena.kelmendi@ulpiana.edu' },
    { id: 't13', name: 'Blerina Salihu', subject: 'Gjuhë Angleze', initials: 'BS', email: 'blerina.salihu@ulpiana.edu' },
    { id: 't14', name: 'Flakresa Jashari', subject: 'Gjuhë Angleze', initials: 'FJ', email: 'flakresa.jashari@ulpiana.edu' },
    { id: 't15', name: 'Arben Lekaj', subject: 'Gjuhë e dytë e huaj', initials: 'AL', email: 'arben.lekaj@ulpiana.edu' },
    { id: 't16', name: 'Gjejlane Shashivari', subject: 'Gjuhë e dytë e huaj', initials: 'GSH', email: 'gjyljane.shashivari@ulpiana.edu' },
    { id: 't17', name: 'Sevdaim Tasholli', subject: 'Gjuhë e dytë e huaj', initials: 'ST', email: 'sevdaim.tasholli@ulpiana.edu' },
    { id: 't18', name: 'Minire Bytyqi', subject: 'Gjuhë e dytë e huaj', initials: 'MB', email: 'minire.bytyqi@ulpiana.edu' },
    { id: 't19', name: 'Zyrafete Murseli', subject: 'Matematikë', initials: 'ZM', email: 'zyrafete.murseli@ulpiana.edu' },
    { id: 't20', name: 'Xhejlane Fetahu', subject: 'Matematikë', initials: 'XHF', email: 'xhejlane.fetahu@ulpiana.edu' },
    { id: 't21', name: 'Lendita Demiri', subject: 'Matematikë', initials: 'LD', email: 'lendita.demiri@ulpiana.edu' },
    { id: 't22', name: 'Shqipe Salihu', subject: 'Matematikë', initials: 'SHS', email: 'shqipe.salihu@ulpiana.edu' },
    { id: 't23', name: 'Arbnora Retkoceri', subject: 'Matematikë', initials: 'AR', email: 'arbnora.retkoceri@ulpiana.edu' },
    { id: 't24', name: 'Albulena Bytyqi', subject: 'Matematikë', initials: 'AB', email: 'albulena.bytyqi@ulpiana.edu' },
    { id: 't25', name: 'Izjadin Qeriqi', subject: 'Matematikë', initials: 'IQ', email: 'izjadin.qeriqi@ulpiana.edu' },
    { id: 't26', name: 'Edi Reqica', subject: 'Matematikë', initials: 'ER', email: 'edi.reqica@ulpiana.edu' },
    { id: 't27', name: 'Ramadan Berisha', subject: 'Biologji', initials: 'RB', email: 'ramadan.berisha@ulpiana.edu' },
    { id: 't28', name: 'Blerina Gërxhaliu', subject: 'Biologji', initials: 'BG', email: 'blerina.gerxhaliu@ulpiana.edu' },
    { id: 't29', name: 'Xhemile Shabiu', subject: 'Biologji', initials: 'XHSH', email: 'xhemile.shabiu@ulpiana.edu' },
    { id: 't30', name: 'Sabrie Asllani', subject: 'Biologji', initials: 'SA', email: 'sabrie.asllani@ulpiana.edu' },
    { id: 't31', name: 'Arben Spahiu', subject: 'Fizikë', initials: 'AS', email: 'arben.spahiu@ulpiana.edu' },
    { id: 't32', name: 'Qamile Xheladini', subject: 'Fizikë', initials: 'QXH', email: 'qamile.xheladini@ulpiana.edu' },
    { id: 't33', name: 'Valbona Kryeziu', subject: 'Fizikë', initials: 'VK', email: 'valbona.kryeziu@ulpiana.edu' },
    { id: 't34', name: 'Lirim Dragaqina', subject: 'Fizikë', initials: 'LD', email: 'lirim.dragaqina@ulpiana.edu' },
    { id: 't35', name: 'Fatime Limani', subject: 'Fizikë', initials: 'FL', email: 'fatime.limani@ulpiana.edu' },
    { id: 't36', name: 'Nerxhivane Tasholli', subject: 'Kimi', initials: 'NT', email: 'nexhmije.tasholli@ulpiana.edu' },
    { id: 't37', name: 'Ilir Kolshi', subject: 'Kimi', initials: 'IK', email: 'ilir.kolshi@ulpiana.edu' },
    { id: 't38', name: 'Lendita Pirraku', subject: 'Kimi', initials: 'LP', email: 'lendita.pirraku@ulpiana.edu' },
    { id: 't39', name: 'Sebahate Konjufca', subject: 'Kimi', initials: 'SK', email: 'sebahate.konjufca@ulpiana.edu' },
    { id: 't40', name: 'Naser Kaqara', subject: 'Gjeografi', initials: 'NK', email: 'naser.kaqara@ulpiana.edu' },
    { id: 't41', name: 'Alban Aliu', subject: 'Gjeografi', initials: 'AA', email: 'alban.aliu@ulpiana.edu' },
    { id: 't42', name: 'Arben Hasani', subject: 'Gjeografi', initials: 'AH', email: 'arben.hasani@ulpiana.edu' },
    { id: 't43', name: 'Xhevrije Shabani', subject: 'Gjeografi', initials: 'XHSH', email: 'xhevrije.shabani@ulpiana.edu' },
    { id: 't44', name: 'Ismet Jetullahu', subject: 'Gjeografi', initials: 'IJ', email: 'ismet.jetullahu@ulpiana.edu' },
    { id: 't45', name: 'Liridona Rashiti', subject: 'Gjeografi', initials: 'LR', email: 'liridona.rashiti@ulpiana.edu' },
    { id: 't46', name: 'Qendrim Ibrahimi', subject: 'Histori - Ed. Qytetare', initials: 'QI', email: 'qendrim.ibrahimi@ulpiana.edu' },
    { id: 't47', name: 'Aida Gashi', subject: 'Histori - Ed. Qytetare', initials: 'AG', email: 'aida.gashi@ulpiana.edu' },
    { id: 't48', name: 'Emine Dedushi', subject: 'Histori - Ed. Qytetare', initials: 'ED', email: 'emine.dedushi@ulpiana.edu' },
    { id: 't49', name: 'Liridon Agushi', subject: 'Histori - Ed. Qytetare', initials: 'LA', email: 'liridon.agushi@ulpiana.edu' },
    { id: 't50', name: 'Enis Shala', subject: 'Histori - Ed. Qytetare', initials: 'ESH', email: 'enis.shala@ulpiana.edu' },
    { id: 't51', name: 'Jehona Luma', subject: 'Histori - Ed. Qytetare', initials: 'JL', email: 'jehona.luma@ulpiana.edu' },
    { id: 't52', name: 'Feride Thaqi', subject: 'Histori - Ed. Qytetare', initials: 'FTH', email: 'feride.thaqi@ulpiana.edu' },
    { id: 't53', name: 'Rineta Durmishi', subject: 'Histori - Ed. Qytetare', initials: 'RD', email: 'rineta.durmishi@ulpiana.edu' },
    { id: 't54', name: 'Pranvera Ilazi', subject: 'Psikologji', initials: 'PI', email: 'pranvera.ilazi@ulpiana.edu' },
    { id: 't55', name: 'Shpetim Azemi', subject: 'Psikologji', initials: 'SHAZ', email: 'shpetim.azemi@ulpiana.edu' },
    { id: 't56', name: 'Fatmir Grajqevci', subject: 'Filozofi - Sociologji', initials: 'FG', email: 'fatmir.grajqevci@ulpiana.edu' },
    { id: 't57', name: 'Elmi Dragusha', subject: 'Filozofi - Sociologji', initials: 'ED', email: 'elmi.dragusha@ulpiana.edu' },
    { id: 't58', name: 'Xhejlane Bytyqi', subject: 'Filozofi - Sociologji', initials: 'XHB', email: 'xhejlane.bytyqi@ulpiana.edu' },
    { id: 't59', name: 'Alban Zeqiri', subject: 'T.I.K', initials: 'AZ', email: 'alban.zeqiri@ulpiana.edu' },
    { id: 't60', name: 'Naime Krasniqi', subject: 'T.I.K', initials: 'NK', email: 'naime.krasniqi@ulpiana.edu' },
    { id: 't61', name: 'Ekrem Salihu', subject: 'T.I.K', initials: 'ES', email: 'ekrem.salihu@ulpiana.edu' },
    { id: 't62', name: 'Leutrim Luma', subject: 'T.I.K', initials: 'LL', email: 'leutrim.luma@ulpiana.edu' },
    { id: 't63', name: 'Armend Rexhepi', subject: 'Art Muzikor-Figurativ', initials: 'AR', email: 'armend.rexhepi@ulpiana.edu' },
    { id: 't64', name: 'Hysen Bytyqi', subject: 'Art Muzikor-Figurativ', initials: 'HB', email: 'hysen.bytyqi@ulpiana.edu' },
    { id: 't65', name: 'Nexhmije Mustafa', subject: 'Art Muzikor-Figurativ', initials: 'NM', email: 'nexhmije.mustafa@ulpiana.edu' },
    { id: 't66', name: 'Behar Sylejmani', subject: 'Art Muzikor-Figurativ', initials: 'BS', email: 'behar.sylejmani@ulpiana.edu' },
    { id: 't67', name: 'Milazim Sadiku', subject: 'Edukatë Fizike', initials: 'MS', email: 'milazim.sadiku@ulpiana.edu' },
    { id: 't68', name: 'Naser Magashi', subject: 'Edukatë Fizike', initials: 'NM', email: 'naser.magashi@ulpiana.edu' },
    { id: 't69', name: 'Fidan Tmava', subject: 'Edukatë Fizike', initials: 'FT', email: 'fidan.tmava@ulpiana.edu' },
    { id: 't70', name: 'Valon Sylejmani', subject: 'Edukatë Fizike', initials: 'VS', email: 'valon.sylejmani@ulpiana.edu' },
    { id: 't71', name: 'Filloreta Azemi', subject: 'Edukatë Fizike', initials: 'FA', email: 'filloreta.azemi@ulpiana.edu' },
    { id: 't72', name: 'Adil Hashani', subject: 'Edukatë Fizike', initials: 'AH', email: 'adil.hashani@ulpiana.edu' },
    { id: 't73', name: 'Minife Sukaj', subject: 'Edukatë Fizike', initials: 'MS', email: 'minife.sukaj@ulpiana.edu' },
    { id: 't74', name: 'Albiona Bahtiri', subject: 'Edukatë Fizike', initials: 'AB', email: 'albiona.bahtiri@ulpiana.edu' },
    { id: 't75', name: 'Nurije Shala', subject: 'Mësim Zgjedhor', initials: 'NSH', email: 'nurije.shala@ulpiana.edu' },
    { id: 't76', name: 'Arben Tasholli', subject: 'Mësim Zgjedhor', initials: 'AT', email: 'arben.tasholli@ulpiana.edu' },
    { id: 't77', name: 'Emine Konxheli', subject: 'Mësim Zgjedhor', initials: 'EK', email: 'emine.konxheli@ulpiana.edu' },
    { id: 't78', name: 'Muhamet Kozhani', subject: 'Mësim Zgjedhor', initials: 'MK', email: 'muhamet.kozhani@ulpiana.edu' },
    { id: 't79', name: 'Betim Krasniqi', subject: 'Mësim Zgjedhor', initials: 'BK', email: 'betim.krasniqi@ulpiana.edu' },
    { id: 't80', name: 'Ramadan Bajraktari', subject: 'Mësim Zgjedhor', initials: 'RB', email: 'ramadan.bajraktari@ulpiana.edu' }
];

const TIME_SLOTS = ["09:00", "09:45", "10:30", "11:15", "13:00", "13:45", "14:30", "15:15", "16:00", "16:45", "17:30", "18:15"];
let activeTeacher = null;
let activeSlot = null;
const API_BASE = 'api.php';
let csrfToken = '';
let announcementsCache = null;
let announcementsCacheTs = 0;
const ANNOUNCEMENTS_TTL_MS = 60 * 1000;

async function api(action, method = 'GET', body = null) {
    const makeRequest = async () => {
        const opt = { method, headers: {}, credentials: 'same-origin' };
        if (method !== 'GET' && csrfToken) opt.headers['X-CSRF-Token'] = csrfToken;
        if (body) {
            opt.headers['Content-Type'] = 'application/json';
            opt.body = JSON.stringify(body);
        }
        const res = await fetch(`${API_BASE}?action=${encodeURIComponent(action)}`, opt);
        return res.json();
    };

    let data = await makeRequest();

    // Auto-refresh CSRF once and retry
    if (!data.ok && /CSRF/i.test(data.message || '') && method !== 'GET') {
        try {
            const t = await fetch(`${API_BASE}?action=csrf`, { credentials: 'same-origin' }).then(r => r.json());
            csrfToken = t.csrfToken || '';
            data = await makeRequest();
        } catch (_) {}
    }

    if (!data.ok) throw new Error(data.message || 'Gabim nga serveri');
    return data;
}

async function getAnnouncementsCached(force = false) {
    const now = Date.now();
    if (!force && announcementsCache && (now - announcementsCacheTs) < ANNOUNCEMENTS_TTL_MS) {
        return announcementsCache;
    }
    const data = await api('list_announcements');
    announcementsCache = data;
    announcementsCacheTs = now;
    return data;
}

// Utility: Button Loading State
function setBtnLoading(btn, isLoading, loadingText = 'Duke u dërguar...') {
    if (!btn) return;
    if (isLoading) {
        btn.dataset.prevText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> ${loadingText}`;
    } else {
        btn.disabled = false;
        btn.innerHTML = btn.dataset.prevText || btn.innerHTML;
    }
}

function debounce(fn, delay = 250) {
    let t;
    return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), delay);
    };
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((email || '').trim());
}

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function safeUrl(url) {
    const raw = String(url || '').trim();
    if (!raw) return '#';
    if (raw.startsWith('/') || raw.startsWith('./') || raw.startsWith('../')) return raw;
    if (/^https?:\/\//i.test(raw)) return raw;
    return '#';
}

// Initialization
document.addEventListener('DOMContentLoaded', () => {
    // Set Current Date
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const dateBadge = document.getElementById('currentDateBadge');
    if (dateBadge) dateBadge.innerText = new Date().toLocaleDateString('sq-AL', options);
    
    renderTeachers(TEACHERS_DB);
    updateAuthUI();
    initAnnouncements();
    initSafeguarding();
    initContact();
    initHomeResources();
    initNotifications();
    initCalendar();
    
    // Fetch teachers from DB and merge with defaults
    api('list_teachers').then(d => {
        const dbTeachers = d.teachers || [];
        dbTeachers.forEach(dbT => {
            const index = TEACHERS_DB.findIndex(t => t.email === dbT.email);
            if (index !== -1) {
                TEACHERS_DB[index] = dbT; // Update existing
            } else {
                TEACHERS_DB.push(dbT); // Add new
            }
        });
        applyTeacherFilters();
    }).catch(err => {
        console.error("Teachers fetch error:", err);
        applyTeacherFilters(); // Fallback to defaults + ruan filtrat aktive
    });
    

    const forgotLink = document.getElementById('forgotPasswordLink');
    const backToLoginBtn = document.getElementById('backToLoginBtn');
    if (forgotLink) {
        forgotLink.addEventListener('click', (e) => {
            e.preventDefault();
            switchAuthView('formForgot');
        });
    }
    if (backToLoginBtn) {
        backToLoginBtn.addEventListener('click', () => resetAuthModalState());
    }

    const hash = window.location.hash || '';
    if (hash.startsWith('#reset=')) {
        openAuthModal();
        switchAuthView('formReset');
        const tokenField = document.getElementById('resetToken');
        if (tokenField) tokenField.value = decodeURIComponent(hash.replace('#reset=', ''));
    }
});

// Search functionality
const searchTeacherInput = document.getElementById('searchTeacher');
const filterSubjectEl = document.getElementById('filterSubject');

function getFilteredTeachers() {
    const term = (searchTeacherInput?.value || '').toLowerCase().trim();
    const subject = filterSubjectEl?.value || '';

    return TEACHERS_DB.filter(t => {
        const matchesName = (t.name || '').toLowerCase().includes(term);
        const matchesSubject = subject === '' || (t.subject || '').includes(subject);
        return matchesName && matchesSubject;
    });
}

function applyTeacherFilters() {
    const filtered = getFilteredTeachers();

    // Nëse profesori aktiv nuk është më në filtër, pastro selektimin
    if (activeTeacher && !filtered.some(t => t.id === activeTeacher)) {
        activeTeacher = null;
        activeSlot = null;
        const stName = document.getElementById('stName');
        const stSubject = document.getElementById('stSubject');
        const bookingForm = document.getElementById('bookingForm');
        const timeSlots = document.getElementById('timeSlots');
        if (stName) stName.innerText = 'Zgjidhni Profesorin';
        if (stSubject) stSubject.innerText = 'Për të parë oraret e rezervuara dhe të lira';
        if (bookingForm) bookingForm.classList.remove('active');
        if (timeSlots) {
            timeSlots.innerHTML = `
                <div class="empty-state">
                    <i class="fa-solid fa-hand-pointer"></i>
                    <p>Zgjidhni profesorin nga paneli i majtë</p>
                </div>
            `;
        }
    }

    renderTeachers(filtered);
}

if (searchTeacherInput) {
    searchTeacherInput.addEventListener('input', debounce(() => applyTeacherFilters(), 220));
}
if (filterSubjectEl) {
    filterSubjectEl.addEventListener('change', () => applyTeacherFilters());
}

function renderTeachers(teachers) {
    const list = document.getElementById('teachersList');
    list.innerHTML = '';
    
    teachers.forEach(t => {
        const item = document.createElement('div');
        item.className = `t-item ${activeTeacher === t.id ? 'active' : ''}`;
        item.onclick = () => selectTeacher(t.id);
        item.innerHTML = `
            <div class="t-avatar">${escapeHtml(t.initials)}</div>
            <div class="t-info">
                <h4>Prof. ${escapeHtml(t.name)}</h4>
                <p><i class="fa-solid fa-book-open"></i> ${escapeHtml(t.subject)}</p>
            </div>
        `;
        list.appendChild(item);
    });
}

function selectTeacher(id) {
    activeTeacher = id;
    activeSlot = null;
    renderTeachers(getFilteredTeachers()); // ruaj listën e filtruar + active state
    
    const teacher = TEACHERS_DB.find(t => t.id === id);
    document.getElementById('stName').innerText = `Prof. ${teacher.name}`;
    document.getElementById('stSubject').innerText = `Lënda: ${teacher.subject}`;
    
    document.getElementById('bookingForm').classList.remove('active');
    
    renderSlots();
}

async function renderSlots() {
    const container = document.getElementById('timeSlots');
    container.innerHTML = '';
    
    let bookedSlots = [];
    try {
        const res = await fetch(`${API_BASE}?action=get_teacher_booked_slots&teacherId=${encodeURIComponent(activeTeacher)}`);
        const data = await res.json();
        if (!data.ok) throw new Error(data.message || 'Gabim');
        bookedSlots = data.slots || [];
    } catch (_) {}
    let hasFree = false;

    TIME_SLOTS.forEach(time => {
        const isBooked = bookedSlots.includes(time);

        const slot = document.createElement('div');
        slot.className = `slot ${isBooked ? 'booked' : ''} ${activeSlot === time ? 'selected' : ''}`;
        slot.innerText = time;
        
        if (!isBooked) {
            hasFree = true;
            slot.onclick = () => selectSlot(time);
        }
        
        container.appendChild(slot);
    });
    
    if(!hasFree) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fa-solid fa-calendar-xmark"></i>
                <p>Nuk ka orare të lira për sot.</p>
            </div>
        `;
    }
}

function selectSlot(time) {
    activeSlot = time;
    renderSlots(); // Update selected state
    
    document.getElementById('slotToBook').innerText = time;
    const form = document.getElementById('bookingForm');
    form.classList.add('active');
    form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Handle Form Submissions
const bookingFormEl = document.getElementById('bookingForm');
if (bookingFormEl) bookingFormEl.addEventListener('submit', async (e) => {
    e.preventDefault();
    if(!activeSlot || !activeTeacher) return;

    if (!window.__activeUser) {
        openAuthModal();
        return;
    }
    
    const parentName = document.getElementById('parentName').value.trim();
    const studentName = document.getElementById('studentName').value.trim();
    const parentEmail = document.getElementById('parentEmail').value.trim();
    const topic = document.getElementById('topic').value.trim();

    if (!parentName || !studentName) {
        createToast('Plotësoni emrin e prindit dhe të nxënësit.', 'error');
        return;
    }
    if (!isValidEmail(parentEmail)) {
        createToast('Ju lutem shkruani një email valid.', 'error');
        return;
    }
    
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const teacher = TEACHERS_DB.find(t => t.id === activeTeacher);
    
    try {
        setBtnLoading(submitBtn, true, 'Duke u rezervuar...');
        await api('book_slot', 'POST', {
            teacherId: teacher.id,
            teacherName: teacher.name,
            teacherSubject: teacher.subject,
            teacherEmail: teacher.email,
            time: activeSlot,
            parentName,
            studentName,
            parentEmail,
            topic
        });
        createToast(`Takimi me Prof. ${teacher.name} në orën ${activeSlot} u rezervua me sukses!`, 'success');
        
        e.target.reset();
        e.target.classList.remove('active');
        activeSlot = null;
        renderSlots();
    } catch (err) {
        createToast(err.message, 'error');
    } finally {
        setBtnLoading(submitBtn, false);
    }
});

// --- Auth State Management ---
function updateAuthUI() {
    const isUserLoggedIn = !!window.__activeUser;
    const navAuthText = document.getElementById('navAuthText');
    const mobileAuthBtn = document.getElementById('mobileAuthBtn');
    if (isUserLoggedIn) {
        if(navAuthText) navAuthText.innerText = 'Dil nga Sistemi';
        if(mobileAuthBtn) mobileAuthBtn.innerText = 'Dil nga Sistemi';
    } else {
        if(navAuthText) navAuthText.innerText = 'Kyçu në Sistem';
        if(mobileAuthBtn) mobileAuthBtn.innerText = 'Kyçu / Regjistrohu';
    }
}

async function initNotifications() {
    if (!("Notification" in window)) return;

    if (Notification.permission === "default") {
        // Shfaq një njoftim të vogël në UI që kërkon leje (më profesionale se dritarja e vdekur e browserit)
        setTimeout(() => {
        // Hoqëm konfirmimin e njoftimeve për një përvojë më të mirë
        console.log("Sistemi i njoftimeve është gati.");
        Notification.requestPermission();
        }, 3000);
    }
}

async function checkNewAnnouncements(items) {
    if (!items.length || Notification.permission !== "granted") return;

    const lastSeenId = localStorage.getItem('lastAnnouncementId');
    const latest = items[0]; // Njoftimi i parë është më i riu

    if (lastSeenId && parseInt(latest.id) > parseInt(lastSeenId)) {
        // Kemi një njoftim të ri!
        new Notification("Njoftim i ri nga Ulpiana", {
            body: latest.title,
            icon: 'assets/logo.png'
        });
    }
    
    localStorage.setItem('lastAnnouncementId', latest.id);
}

async function initAnnouncements() {
    const box = document.getElementById('announcementsList');
    if (!box) return;
    try {
        const data = await getAnnouncementsCached();
        const items = data.announcements || [];
        
        // Kontrollo për njoftime të reja për Notification API
        checkNewAnnouncements(items);

        if (!items.length) {
            box.innerHTML = `
                <div class="empty-state" style="height:auto; padding: 24px 0;">
                    <i class="fa-regular fa-bell-slash"></i>
                    <p>Nuk ka njoftime për momentin.</p>
                </div>
            `;
            return;
        }
        box.innerHTML = items.map(a => `
            <article style="padding:14px 0;border-bottom:1px solid rgba(255,255,255,0.08)">
                <h4 style="color:white;margin-bottom:6px;">${escapeHtml(a.title)}</h4>
                <p style="color:var(--text-secondary);margin-bottom:4px;">${escapeHtml(a.content)}</p>
                <small style="color:#93c5fd;">Publikuar: ${escapeHtml(a.created_at)}</small>
            </article>
        `).join('');
    } catch (_) {
        box.innerHTML = '<p style="color:#fca5a5;">Gabim gjatë ngarkimit të njoftimeve.</p>';
    }
}

function initSafeguarding() {
    const form = document.getElementById('safeguardingForm');
    if (!form) return;
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const payload = {
            reporterName: document.getElementById('safeName').value,
            reporterEmail: document.getElementById('safeEmail').value,
            category: document.getElementById('safeCategory').value,
            message: document.getElementById('safeMessage').value,
            isAnonymous: document.getElementById('safeAnon').checked
        };
        try {
            setBtnLoading(submitBtn, true, 'Duke dërguar...');
            await api('submit_safeguarding_report', 'POST', payload);
            form.reset();
            document.getElementById('safeAnon').checked = true;
            createToast('Raporti u dërgua me sukses. Faleminderit!', 'success');
        } catch (err) {
            createToast(err.message, 'error');
        } finally {
            setBtnLoading(submitBtn, false);
        }
    });
}

function initContact() {
    const form = document.getElementById('contactForm');
    if (!form) return;
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const payload = {
            name: document.getElementById('contactName').value.trim(),
            email: document.getElementById('contactEmail').value.trim(),
            subject: document.getElementById('contactSubject').value.trim(),
            message: document.getElementById('contactMessage').value.trim()
        };
        if (!payload.name || payload.name.length < 2) {
            createToast('Emri duhet të ketë të paktën 2 karaktere.', 'error');
            return;
        }
        if (!isValidEmail(payload.email)) {
            createToast('Email adresa nuk është valide.', 'error');
            return;
        }
        if (!payload.subject || payload.subject.length < 3) {
            createToast('Subjekti duhet të ketë të paktën 3 karaktere.', 'error');
            return;
        }
        if (!payload.message || payload.message.length < 10) {
            createToast('Mesazhi duhet të ketë të paktën 10 karaktere.', 'error');
            return;
        }
        try {
            setBtnLoading(submitBtn, true, 'Duke u dërguar...');
            await api('submit_contact', 'POST', payload);
            form.reset();
            createToast('Mesazhi u dërgua me sukses!', 'success');
        } catch (err) {
            createToast(err.message, 'error');
        } finally {
            setBtnLoading(submitBtn, false);
        }
    });
}

let resourcesCache = [];

async function initHomeResources() {
    const box = document.getElementById('resourcesList');
    if (!box) return;
    try {
        const data = await api('list_resources');
        resourcesCache = data.resources || [];
        renderHomeResources(resourcesCache);
    } catch (_) {
        box.innerHTML = '<p style="color:#fca5a5;grid-column:1/-1;text-align:center;">Gabim gjatë ngarkimit të materialeve.</p>';
    }
}

function renderHomeResources(items) {
    const box = document.getElementById('resourcesList');
    if (!box) return;
    if (!items.length) {
        box.innerHTML = `
            <div class="empty-state" style="grid-column:1/-1; height:auto; padding: 24px 0;">
                <i class="fa-regular fa-folder-open"></i>
                <p>Nuk ka materiale të ngarkuara për momentin.</p>
            </div>
        `;
        return;
    }
    box.innerHTML = items.map(r => `
        <a href="${escapeHtml(safeUrl(r.file_path))}" target="_blank" rel="noopener noreferrer" class="resource-card-home">
            <div class="res-icon"><i class="fa-solid fa-file-pdf"></i></div>
            <div class="res-info-h">
                <h4>${escapeHtml(r.title)}</h4>
                <p>${escapeHtml(r.category)} • Nga: ${escapeHtml(r.uploader_name)}</p>
            </div>
        </a>
    `).join('');
}

function filterResources(cat, btn) {
    // Update active UI
    const btns = document.querySelectorAll('.resource-filters .btn');
    btns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    if (cat === 'all') {
        renderHomeResources(resourcesCache);
    } else {
        const filtered = resourcesCache.filter(r => (r.category || '').includes(cat));
        renderHomeResources(filtered);
    }
}
window.filterResources = filterResources;

function handleAuthAction() {
    const isUserLoggedIn = !!window.__activeUser;
    if (isUserLoggedIn) {
        api('logout', 'POST').then(() => {
            window.__activeUser = null;
            updateAuthUI();
            createToast('Keni dalë nga sistemi me sukses.', 'success');
        });
    } else {
        openAuthModal();
    }
}

// Mock Auth
async function initCalendar() {
    const box = document.getElementById('calendarEventsList');
    if (!box) return;
    try {
        const data = await api('list_events');
        renderCalendarEvents(data.events || []);
    } catch (_) {
        box.innerHTML = '<p style="color:#fca5a5; text-align:center; grid-column:1/-1;">Gabim gjatë ngarkimit të kalendarit.</p>';
    }
}

function renderCalendarEvents(events) {
    const box = document.getElementById('calendarEventsList');
    if (!box) return;
    if (!events.length) {
        box.innerHTML = '<p style="color:var(--text-secondary); text-align:center; grid-column:1/-1;">Nuk ka ngjarje të planifikuara për momentin.</p>';
        return;
    }

    const monthNames = ["JAN", "SHK", "MAR", "PRI", "MAJ", "QER", "KOR", "GUS", "SHT", "TET", "NËN", "DHJ"];

    box.innerHTML = events.map(e => {
        const d = new Date(e.event_date);
        const day = d.getDate();
        const month = monthNames[d.getMonth()];
        const tagMap = {
            'exam': 'Provim',
            'holiday': 'Pushim',
            'activity': 'Aktivitet',
            'other': 'Tjetër'
        };

        return `
            <div class="event-card">
                <div class="event-date-box">
                    <span>${day}</span>
                    <small>${month}</small>
                </div>
                <div class="event-info-c">
                    <h4>${escapeHtml(e.title)}</h4>
                    <p>${escapeHtml(e.description || '')}</p>
                    <span class="event-tag tag-${e.category}">${tagMap[e.category] || 'Tjetër'}</span>
                </div>
            </div>
        `;
    }).join('');
}

const formLoginEl = document.getElementById('formLogin');
if (formLoginEl) formLoginEl.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const emailInput = e.target.querySelector('input[type="email"]').value.toLowerCase();
    const passInput = e.target.querySelector('input[type="password"]').value;
    
    try {
        const data = await api('login', 'POST', { email: emailInput, password: passInput });
        window.__activeUser = data.user;
        const privateOwnerEmail = 'ardi@ulpiana.edu';
        if ((data.user.email || '').toLowerCase() === privateOwnerEmail) {
            window.location.href = 'private-dashboard.html';
            return;
        }
        if (data.user.role === 'teacher' || data.user.role === 'admin') {
            window.location.href = 'dashboard.html';
            return;
        }
        if (data.user.role === 'student') {
            window.location.href = 'student-dashboard.html';
            return;
        }
        updateAuthUI();
        closeAuthModal();
        createToast('Jeni kyçur me sukses!', 'success');
    } catch (err) {
        createToast(err.message, 'error');
    }
});

const formSignupEl = document.getElementById('formSignup');
if (formSignupEl) formSignupEl.addEventListener('submit', async (e) => {
    e.preventDefault();
    const regName = document.getElementById('regName');
    const regRole = document.getElementById('regRole');
    const regEmail = document.getElementById('regEmail');
    const regPass = document.getElementById('regPass');

    if (!regName || !regEmail || !regPass) {
        createToast('Gabim teknik: Fushat nuk u gjetën.', 'error');
        return;
    }

    const payload = {
        fullName: regName.value.trim(),
        role: regRole ? regRole.value : 'parent',
        email: regEmail.value.trim(),
        password: regPass.value
    };

    if (!payload.fullName || !payload.email || payload.password.length < 6) {
        createToast('Ju lutem plotësoni të gjitha fushat saktë.', 'warning');
        return;
    }

    try {
        const data = await api('signup', 'POST', payload);
        window.__activeUser = data.user;
        
        if (data.user.role === 'student') {
            window.location.href = 'student-dashboard.html';
            return;
        }
        
        updateAuthUI();
        closeAuthModal();
        createToast('Llogaria u krijua me sukses!', 'success');
    } catch (err) {
        createToast(err.message, 'error');
    }
});

const formForgot = document.getElementById('formForgot');
if (formForgot) {
    formForgot.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('forgotEmail').value.trim();
        try {
            const d = await api('request_password_reset', 'POST', { email });
            createToast(d.message || 'Kontrollo email-in për udhëzime.', 'success');
            switchAuthView('formReset');
            const resetEmailField = document.getElementById('resetEmail');
            if (resetEmailField) resetEmailField.value = email;
        } catch (err) {
            createToast(err.message, 'error');
        }
    });
}

const formReset = document.getElementById('formReset');
if (formReset) {
    formReset.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('resetEmail')?.value?.trim() || '';
        const token = document.getElementById('resetToken').value.trim();
        const newPassword = document.getElementById('resetNewPassword').value;
        try {
            await api('reset_password', 'POST', { email, token, newPassword });
            createToast('Fjalëkalimi u rivendos me sukses.', 'success');
            resetAuthModalState();
            history.replaceState(null, '', window.location.pathname + window.location.search);
        } catch (err) {
            createToast(err.message, 'error');
        }
    });
}

api('whoami').then(d => {
    window.__activeUser = d.user;
    csrfToken = d.csrfToken || csrfToken;
    updateAuthUI();
}).catch(() => {});

api('csrf').then(d => {
    csrfToken = d.csrfToken || csrfToken;
}).catch(() => {});

// Toast Notifications
function createToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    const icon = type === 'success' ? '<i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-exclamation"></i>';
    
    toast.innerHTML = `
        ${icon}
        <div>
            <h4 style="font-size:1rem; margin-bottom:3px;">${type === 'success' ? 'Sukses' : 'Gabim'}</h4>
            <p style="font-size:0.9rem; color:var(--text-secondary);">${message}</p>
        </div>
    `;
    
    container.appendChild(toast);
    
    // Animate in
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Remove after 4 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    }, 4000);
}

// --- FAQ Accordion Logic ---
document.querySelectorAll('.accordion-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const willOpen = !this.classList.contains('active');

        // Close others
        document.querySelectorAll('.accordion-btn').forEach(other => {
            if (other !== this) {
                other.classList.remove('active');
                other.setAttribute('aria-expanded', 'false');
                other.nextElementSibling.style.maxHeight = null;
            }
        });

        this.classList.toggle('active', willOpen);
        this.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
        const content = this.nextElementSibling;
        content.style.maxHeight = willOpen ? (content.scrollHeight + "px") : null;
    });
});


// --- Scroll Progress Bar ---
const scrollProgressBar = document.getElementById('scrollProgressBar');
if (scrollProgressBar) {
    window.addEventListener('scroll', () => {
        const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (scrollTop / scrollHeight) * 100;
        scrollProgressBar.style.width = scrolled + '%';
    }, { passive: true });
}

// --- Page Transitions ---
const pageTransition = document.getElementById('pageTransition');
if (pageTransition) {
    document.querySelectorAll('a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetUrl = this.getAttribute('href');
            if (targetUrl && !targetUrl.startsWith('#') && !targetUrl.startsWith('http') && targetUrl.endsWith('.html') && this.getAttribute('target') !== '_blank') {
                e.preventDefault();
                pageTransition.classList.add('active');
                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 600);
            }
        });
    });
}

// --- Parallax Effect ---
let parallaxRaf = null;
let parallaxX = 0;
let parallaxY = 0;

const renderParallax = () => {
    parallaxRaf = null;
    const x = (window.innerWidth - parallaxX * 2) / 100;
    const y = (window.innerHeight - parallaxY * 2) / 100;

    const heroImage = document.querySelector('.hero-image-wrapper');
    if (heroImage) {
        heroImage.style.transform = `rotateY(-5deg) rotateX(5deg) translateX(${x}px) translateY(${y}px)`;
    }

    const image1 = document.querySelector('.img-1');
    const image2 = document.querySelector('.img-2');
    if (image1 && image2) {
        image1.style.transform = `translateX(${x * 1.5}px) translateY(${y * 1.5}px)`;
        image2.style.transform = `translateX(${-x * 1.5}px) translateY(${-y * 1.5}px)`;
    }
};

document.addEventListener('mousemove', (e) => {
    if (window.innerWidth < 768) return;

    parallaxX = e.pageX;
    parallaxY = e.pageY;
    if (!parallaxRaf) parallaxRaf = requestAnimationFrame(renderParallax);
}, { passive: true });

// --- Text Highlighting on Scroll ---
const highlightObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5, rootMargin: "0px 0px -100px 0px" });

document.querySelectorAll('.highlight').forEach(el => highlightObserver.observe(el));

// --- Pulse Automation & Soul ---
async function initPulseAutomation() {
    const pulseContainer = document.querySelector('.pulse-news-cards');
    if (!pulseContainer) return;

    try {
        const data = await getAnnouncementsCached();
        const items = (data.announcements || []).slice(0, 3); // Merre vetëm 3 lajmet e fundit

        if (items.length > 0) {
            pulseContainer.innerHTML = items.map((a, index) => {
                const date = new Date(a.created_at);
                const day = date.getDate();
                const month = date.toLocaleString('sq-AL', { month: 'short' }).toUpperCase();
                
                return `
                    <div class="news-mini-card ${index === 0 ? 'active' : ''}">
                        <div class="news-date">${day} ${month}</div>
                        <div class="news-body">
                            <h4>${escapeHtml(a.title)}</h4>
                            <p>${escapeHtml(a.content.substring(0, 80))}${a.content.length > 80 ? '...' : ''}</p>
                        </div>
                        <i class="fa-solid fa-chevron-right"></i>
                    </div>
                `;
            }).join('');
        }
    } catch (err) {
        console.warn("Pulse automation error:", err);
        // Do të mbesin lajmet statike si fallback
    }
}

// Call automation on load
document.addEventListener('DOMContentLoaded', () => {
    initPulseAutomation();
});

// (FAQ logic handled above)

if ('serviceWorker' in navigator && window.location.protocol !== 'file:') {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('sw.js').catch(() => {});
    });
}
