<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'Dashboard') ?> — MyHR</title>
<link rel="stylesheet" href="<?= app_url('assets/vendor/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= app_url('assets/vendor/bootstrap-icons.css') ?>">
<style>
:root{--sw:260px;--navy:#0f2547;--bg:#f4f6fb;--card-bg:#fff;--text:#1e293b;--muted:#64748b;--border:#e5e9f0}
[data-bs-theme="dark"]{--bg:#0a1830;--card-bg:#0f2547;--text:#e2e8f0;--muted:#94a3b8;--border:#1e3559}
body{background:var(--bg);color:var(--text);font-family:system-ui,'Segoe UI',Roboto,sans-serif;margin:0;font-size:15px}
.app{display:flex;min-height:100vh}
.sidebar{width:var(--sw);background:var(--navy);color:#cfd8e6;position:fixed;inset:0 auto 0 0;overflow-y:auto;z-index:100;display:flex;flex-direction:column}
.brand{padding:1.5rem 1.25rem 1rem;font-weight:700;font-size:1.55rem;color:#fff;border-bottom:1px solid rgba(255,255,255,.08)}
.brand small{display:block;font-size:.62rem;color:#8a94a6;font-weight:400;letter-spacing:1.5px;text-transform:uppercase;margin-top:.35rem}
.nav{flex:1;padding:.5rem .75rem 1rem}
.nav-section{font-size:.68rem;color:#6b7a8f;text-transform:uppercase;letter-spacing:1px;padding:1rem .75rem .4rem;font-weight:600}
.nav-item{display:flex;align-items:center;gap:.75rem;padding:.55rem .75rem;border-radius:.5rem;color:#cfd8e6;text-decoration:none;font-size:.88rem;margin-bottom:1px}
.nav-item:hover{background:rgba(255,255,255,.06);color:#fff}
.nav-item.active{background:#1b3a68;color:#fff;font-weight:500}
.nav-badge{margin-left:auto;background:#dc2626;color:#fff;font-size:.65rem;font-weight:700;padding:.1rem .4rem;border-radius:1rem}
.main{flex:1;margin-left:var(--sw);min-width:0}
.topbar{background:var(--card-bg);border-bottom:1px solid var(--border);padding:.65rem 1.5rem;display:flex;align-items:center;gap:1rem;position:sticky;top:0;z-index:50}
.hamburger{display:none;background:none;border:none;font-size:1.4rem;color:var(--text);cursor:pointer}
.topbar-actions{display:flex;align-items:center;gap:.4rem;margin-left:auto}
.icon-btn{background:none;border:none;width:2.25rem;height:2.25rem;border-radius:.5rem;color:var(--text);font-size:1.1rem;cursor:pointer;position:relative;display:inline-flex;align-items:center;justify-content:center}
.icon-btn:hover{background:var(--bg)}
.badge-dot{position:absolute;top:.5rem;right:.5rem;width:.5rem;height:.5rem;background:#dc2626;border-radius:50%}
.avatar{width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,var(--navy),#1b3a68);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700}
.avatar-lg{width:4rem;height:4rem;font-size:1.3rem}
.user-name{font-size:.82rem;font-weight:600}
.user-role{font-size:.68rem;color:var(--muted)}
.demo-ribbon{background:#fef3c7;color:#78350f;padding:.5rem 1.5rem;font-size:.82rem;border-bottom:1px solid #fde68a}
.content{padding:1.5rem;max-width:1600px}
.page-header{display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem}
.page-title{font-size:1.5rem;font-weight:700;margin:0}
.page-subtitle{color:var(--muted);font-size:.875rem;margin-top:.25rem}
.stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:1.5rem}
.stat-card{background:var(--card-bg);border:1px solid var(--border);border-radius:.75rem;padding:1.25rem}
.stat-label{color:var(--muted);font-size:.72rem;text-transform:uppercase;letter-spacing:.6px;font-weight:600;margin-bottom:.5rem}
.stat-value{font-size:2rem;font-weight:700;line-height:1}
.stat-delta{font-size:.78rem;margin-top:.55rem;color:var(--muted)}
.stat-delta .up{color:#16a34a;font-weight:600}
.card{background:var(--card-bg);border:1px solid var(--border);border-radius:.75rem}
.card-header{padding:1rem 1.25rem;font-weight:600;font-size:.9rem;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center}
.card-body{padding:1.25rem}
table{width:100%;border-collapse:collapse}
thead th{background:var(--bg);font-size:.72rem;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);font-weight:600;padding:.75rem 1rem;text-align:left;white-space:nowrap}
tbody td{padding:.75rem 1rem;border-bottom:1px solid var(--border);vertical-align:middle;font-size:.875rem}
tbody tr:hover{background:var(--bg)}
tbody tr:last-child td{border-bottom:0}
.status{display:inline-flex;align-items:center;gap:.35rem;padding:.18rem .6rem;border-radius:1rem;font-size:.72rem;font-weight:600;text-transform:capitalize}
.s-regular,.s-active,.s-completed,.s-paid,.s-present,.s-approved,.s-success,.s-verified,.s-assigned,.s-available{background:#dcfce7;color:#166534}
.s-probationary,.s-in_progress,.s-open,.s-late,.s-processing{background:#fef3c7;color:#92400e}
.s-pending,.s-pre_employment,.s-draft{background:#dbeafe;color:#1e40af}
.s-resigned,.s-terminated,.s-absent,.s-failed,.s-rejected,.s-unverified{background:#fee2e2;color:#991b1b}
.s-inactive,.s-archived{background:#e2e8f0;color:#475569}
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.45rem .9rem;border-radius:.5rem;font-size:.82rem;font-weight:500;cursor:pointer;border:1px solid transparent;text-decoration:none;color:inherit}
.btn-dark{background:var(--navy);color:#fff}
.btn-outline{background:transparent;border-color:var(--border);color:var(--text)}
.btn-outline:hover{background:var(--bg)}
.btn-sm{padding:.3rem .7rem;font-size:.78rem}
.btn-success{background:#16a34a;color:#fff}
.progress-line{height:.4rem;border-radius:1rem;background:var(--border);overflow:hidden}
.progress-line>div{height:100%;background:linear-gradient(90deg,var(--navy),#2f5b9e);border-radius:1rem}
.row{display:flex;gap:1rem;flex-wrap:wrap}
.col-2{flex:1 1 calc(50% - .5rem);min-width:280px}
.kv{display:flex;justify-content:space-between;padding:.6rem 0;border-bottom:1px solid var(--border);font-size:.875rem}
.kv:last-child{border-bottom:0}
.kv .k{color:var(--muted)}
.kv .v{font-weight:600}
.empty{text-align:center;padding:2.5rem 1rem;color:var(--muted)}
a.back{color:var(--muted);font-size:.82rem;text-decoration:none}
a.back:hover{text-decoration:underline}
.kanban{display:flex;gap:1rem;overflow-x:auto;padding-bottom:1rem}
.kanban-col{min-width:260px;flex-shrink:0}
.kanban-card{background:var(--card-bg);border:1px solid var(--border);border-radius:.5rem;padding:.75rem;margin-bottom:.5rem;text-decoration:none;color:var(--text);display:block}
.kanban-card:hover{border-color:var(--navy)}
.terminal-input{width:100%;padding:1rem;font-family:monospace;font-size:1.3rem;border:2px solid var(--navy);border-radius:.5rem;background:var(--card-bg);color:var(--text)}
.action-btn{padding:.4rem .75rem;font-size:.78rem;background:transparent;border:1px solid var(--border);border-radius:.5rem;color:var(--text);cursor:pointer;margin-right:.25rem;margin-bottom:.25rem}
.action-btn.active{background:var(--navy);color:#fff}
@media print{.sidebar,.topbar,.demo-ribbon,.page-header a.btn,.page-header button{display:none!important}.main{margin-left:0!important}.content{padding:0!important}}
@media (max-width:991px){.sidebar{transform:translateX(-100%);transition:transform .2s}.sidebar.open{transform:translateX(0)}.main{margin-left:0}.hamburger{display:block}.user-name,.user-role{display:none}.content{padding:1rem}.col-2{flex:1 1 100%}}
</style>
</head>
<body>
<div class="app">
<aside class="sidebar" id="sidebar">
  <div class="brand">MyHR<small>Natkram-Systems</small></div>
  <nav class="nav">
    <div class="nav-section">Overview</div>
    <a class="nav-item" href="<?= app_url('dashboard') ?>">◈ Dashboard</a>
    <div class="nav-section">People</div>
    <a class="nav-item" href="<?= app_url('employees') ?>">◉ Employees</a>
    <a class="nav-item" href="<?= app_url('departments') ?>">◇ Departments</a>
    <a class="nav-item" href="<?= app_url('positions') ?>">◇ Positions</a>
    <a class="nav-item" href="<?= app_url('employees/8/onboarding') ?>">◇ Onboarding <span class="nav-badge">1</span></a>
    <div class="nav-section">Recruitment</div>
    <a class="nav-item" href="<?= app_url('jobs') ?>">◇ Job Postings</a>
    <a class="nav-item" href="<?= app_url('jobs/1/pipeline') ?>">◇ Pipeline</a>
    <div class="nav-section">Timekeeping</div>
    <a class="nav-item" href="<?= app_url('timekeeping') ?>">◇ Timekeeping</a>
    <a class="nav-item" href="<?= app_url('timekeeping/terminal') ?>">◇ DTR Terminal</a>
    <a class="nav-item" href="<?= app_url('employees/1/dtr') ?>">◇ DTR Summary</a>
    <a class="nav-item" href="<?= app_url('timekeeping/devices') ?>">◇ Devices</a>
    <div class="nav-section">Leave</div>
    <a class="nav-item" href="<?= app_url('leave') ?>">◇ Leave Requests</a>
    <a class="nav-item" href="<?= app_url('leave/types') ?>">◇ Leave Types</a>
    <a class="nav-item" href="<?= app_url('overtime') ?>">◇ Overtime</a>
    <div class="nav-section">Payroll</div>
    <a class="nav-item" href="<?= app_url('payroll') ?>">◇ Payroll</a>
    <a class="nav-item" href="<?= app_url('loans') ?>">◇ Loans</a>
    <a class="nav-item" href="<?= app_url('benefits') ?>">◇ Benefits</a>
    <div class="nav-section">Other</div>
    <a class="nav-item" href="<?= app_url('assets') ?>">◇ Assets</a>
    <a class="nav-item" href="<?= app_url('performance') ?>">◇ Performance</a>
    <a class="nav-item" href="<?= app_url('training') ?>">◇ Training</a>
    <a class="nav-item" href="<?= app_url('announcements') ?>">◇ Announcements</a>
    <div class="nav-section">Admin</div>
    <a class="nav-item" href="<?= app_url('reports') ?>">◇ Reports</a>
    <a class="nav-item" href="<?= app_url('audit') ?>">◇ Audit Trail</a>
    <a class="nav-item" href="<?= app_url('settings') ?>">◇ Settings</a>
  </nav>
</aside>
<div class="main">
  <header class="topbar">
    <button class="hamburger" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
    <div class="topbar-actions">
      <button class="icon-btn" onclick="toggleTheme()" id="themeBtn" title="Toggle theme">🌙</button>
      <button class="icon-btn" title="Notifications">🔔<span class="badge-dot"></span></button>
      <div style="display:flex;align-items:center;gap:.6rem;padding:.25rem .6rem .25rem .25rem">
        <div class="avatar"><?= e(substr($auth['display_name'] ?? 'U', 0, 1)) ?></div>
        <div><div class="user-name"><?= e($auth['display_name'] ?? '') ?></div><div class="user-role">HR Administrator</div></div>
      </div>
    </div>
  </header>
  <?php if (!empty($demo)): ?>
    <div class="demo-ribbon">ⓘ Demo mode — sample data. Not the live app.</div>
  <?php endif; ?>
  <main class="content">
    <?php foreach ($flash ?? [] as [$type, $msg]): ?>
      <div class="alert alert-<?= e($type) ?>"><?= e($msg) ?></div>
    <?php endforeach; ?>
    <?= $content ?>
  </main>
</div>
</div>
<script>
function toggleTheme(){const h=document.documentElement;const n=h.getAttribute('data-bs-theme')==='dark'?'light':'dark';h.setAttribute('data-bs-theme',n);document.getElementById('themeBtn').textContent=n==='dark'?'☀':'🌙';localStorage.setItem('myhr-theme',n);}
(function(){const s=localStorage.getItem('myhr-theme')||'light';document.documentElement.setAttribute('data-bs-theme',s);const b=document.getElementById('themeBtn');if(b)b.textContent=s==='dark'?'☀':'🌙';})();
</script>
<script src="<?= app_url('assets/vendor/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>