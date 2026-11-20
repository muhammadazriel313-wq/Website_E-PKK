@extends('backend.layouts.template')

@section('content1')

@verbatim
<style>
  .pk { --pk-blue:#016AA3; --pk-blue-dark:#014d77; --pk-blue-soft:#e6f2f9; --pk-ink:#1e293b; --pk-muted:#64748b; --pk-line:#e2e8f0; --pk-bg:#f8fafc;
        font-family:'Poppins',sans-serif; color:var(--pk-ink); }
  .pk * { font-family:'Poppins',sans-serif; box-sizing:border-box; }
  .pk-head h1 { font-size:24px; font-weight:600; margin:0 0 4px; }
  .pk-head p { margin:0 0 18px; color:var(--pk-muted); font-size:14px; max-width:70ch; }

  .pk-bar { background:#fff; border:1px solid var(--pk-line); border-radius:12px; padding:14px 16px; display:flex; flex-wrap:wrap; gap:12px 20px; align-items:center; }
  .pk-seg { display:inline-flex; background:var(--pk-bg); border:1px solid var(--pk-line); border-radius:10px; padding:3px; }
  .pk-seg button { border:0; background:transparent; padding:7px 18px; border-radius:8px; font-size:14px; font-weight:500; color:var(--pk-muted); cursor:pointer; }
  .pk-seg button[aria-selected="true"] { background:var(--pk-blue); color:#fff; }
  .pk-chips { display:flex; flex-wrap:wrap; gap:8px; align-items:center; }
  .pk-chip { border:1px solid var(--pk-line); background:#fff; color:var(--pk-ink); padding:7px 14px; border-radius:999px; font-size:13px; cursor:pointer; display:inline-flex; gap:7px; align-items:center; }
  .pk-chip:hover { border-color:var(--pk-blue); }
  .pk-chip[aria-pressed="true"] { background:var(--pk-blue-soft); border-color:var(--pk-blue); color:var(--pk-blue-dark); font-weight:600; }
  .pk button:focus-visible, .pk input:focus-visible { outline:3px solid rgba(1,106,163,.35); outline-offset:2px; }

  .pk-pick { position:relative; }
  .pk-pop { position:absolute; top:calc(100% + 8px); left:0; z-index:50; width:340px; background:#fff; border-radius:16px; box-shadow:0 12px 40px rgba(15,23,42,.22); padding:14px 16px 12px; }
  .pk-pop[hidden] { display:none; }
  .pk-ch { display:flex; align-items:center; gap:4px; margin-bottom:6px; }
  .pk-ch .pk-title { flex:1; border:0; background:transparent; font-weight:600; font-size:15px; cursor:pointer; padding:6px 8px; border-radius:8px; text-align:left; }
  .pk-ch .pk-title:hover { background:var(--pk-bg); }
  .pk-ic { border:0; background:transparent; width:34px; height:34px; border-radius:50%; cursor:pointer; color:var(--pk-ink); font-size:15px; }
  .pk-ic:hover { background:var(--pk-bg); }
  .pk-wd, .pk-days { display:grid; grid-template-columns:repeat(7,1fr); }
  .pk-wd span { text-align:center; font-size:12px; color:var(--pk-muted); padding:6px 0; }
  .pk-day { border:0; background:transparent; height:38px; font-size:13px; cursor:pointer; position:relative; color:var(--pk-ink); isolation:isolate; padding:0; }
  .pk-day.empty { cursor:default; }
  .pk-day.inrange { background:var(--pk-blue-soft); }
  .pk-day.s { background:linear-gradient(90deg, transparent 50%, var(--pk-blue-soft) 50%); }
  .pk-day.e { background:linear-gradient(90deg, var(--pk-blue-soft) 50%, transparent 50%); }
  .pk-day.edge { color:#fff; font-weight:600; }
  .pk-day.edge::before { content:""; position:absolute; top:1px; bottom:1px; left:50%; width:36px; margin-left:-18px; border-radius:50%; background:var(--pk-blue); z-index:-1; }
  .pk-day.today:not(.edge) { color:var(--pk-blue); font-weight:700; }
  .pk-months { display:grid; grid-template-columns:repeat(3,1fr); gap:6px; padding:6px 0; }
  .pk-months button { border:0; background:transparent; padding:11px 0; border-radius:10px; font-size:14px; cursor:pointer; }
  .pk-months button:hover { background:var(--pk-bg); }
  .pk-months button[aria-current="true"] { background:var(--pk-blue); color:#fff; }
  .pk-foot { display:flex; align-items:center; gap:8px; border-top:1px solid var(--pk-line); margin-top:8px; padding-top:10px; }
  .pk-foot .pk-sel { flex:1; font-size:12.5px; color:var(--pk-muted); }
  .pk-btn { border:1px solid var(--pk-line); background:#fff; border-radius:8px; padding:7px 14px; font-size:13px; cursor:pointer; }
  .pk-btn.primary { background:var(--pk-blue); border-color:var(--pk-blue); color:#fff; }
  .pk-btn:disabled { opacity:.45; cursor:not-allowed; }

  .pk-meta { display:flex; flex-wrap:wrap; justify-content:space-between; gap:10px; align-items:center; margin:18px 2px 10px; }
  .pk-meta .pk-per { font-size:14px; color:var(--pk-muted); }
  .pk-meta .pk-per b { color:var(--pk-ink); font-weight:600; }
  .pk-search { border:1px solid var(--pk-line); border-radius:10px; padding:8px 12px; font-size:14px; width:240px; max-width:100%; background:#fff; }

  .pk-list { background:#fff; border:1px solid var(--pk-line); border-radius:12px; overflow:hidden; }
  .pk-row { display:grid; grid-template-columns:44px 44px 1fr minmax(120px,38%) 76px; gap:14px; align-items:center; padding:12px 16px; border-bottom:1px solid var(--pk-line); }
  .pk-row:last-child { border-bottom:0; }
  .pk-rank { width:34px; height:34px; border-radius:50%; display:grid; place-items:center; font-weight:600; font-size:14px; color:var(--pk-muted); background:var(--pk-bg); }
  .pk-row.r1 .pk-rank { background:#fcd34d; color:#78350f; } .pk-row.r2 .pk-rank { background:#cbd5e1; color:#334155; } .pk-row.r3 .pk-rank { background:#f4b183; color:#7c2d12; }
  .pk-av { width:44px; height:44px; border-radius:50%; background:var(--pk-blue-soft); color:var(--pk-blue-dark); display:grid; place-items:center; font-weight:600; overflow:hidden; }
  .pk-av img { width:100%; height:100%; object-fit:cover; display:block; }
  .pk-name { font-weight:600; font-size:15px; line-height:1.25; }
  .pk-sub { font-size:12.5px; color:var(--pk-muted); }
  .pk-barwrap { height:8px; background:var(--pk-bg); border-radius:99px; overflow:hidden; }
  .pk-barwrap i { display:block; height:100%; background:var(--pk-blue); border-radius:99px; min-width:0; }
  .pk-row.r1 .pk-barwrap i { background:#d99a00; }
  .pk-pts { text-align:right; font-weight:700; font-size:18px; line-height:1; }
  .pk-pts small { display:block; font-weight:400; font-size:11.5px; color:var(--pk-muted); margin-top:3px; }
  .pk-row.zero .pk-pts, .pk-row.zero .pk-name { color:#94a3b8; }

  .pk-note { padding:28px 20px; text-align:center; color:var(--pk-muted); font-size:14px; }
  .pk-note b { display:block; color:var(--pk-ink); font-size:15px; margin-bottom:4px; }
  .pk-banner { background:#fff8e1; border:1px solid #fde68a; color:#78530a; border-radius:10px; padding:10px 14px; font-size:13.5px; margin-bottom:10px; }

  @media (max-width: 767px) {
    .pk-row { grid-template-columns:34px 40px 1fr 64px; gap:10px; padding:11px 12px; }
    .pk-row .pk-bar-col { display:none; }
    .pk-av { width:40px; height:40px; }
    .pk-pop { position:fixed; left:12px; right:12px; top:90px; width:auto; }
  }
  @media (prefers-reduced-motion: no-preference) { .pk-barwrap i { transition:width .5s ease; } }
</style>
@endverbatim

<main id="main" class="main">
  <section class="section">
    <div class="pk" id="pk"
         data-desa="{{ url('api/ranking/desa') }}"
         data-kecamatan="{{ url('api/ranking/kecamatan') }}">

      <div class="pk-head">
        <h1>Peringkat</h1>
        <p>Satu laporan atau galeri kegiatan yang sudah disetujui akhir oleh admin kabupaten bernilai satu poin. Laporan dan galeri yang masih diproses tidak dihitung.</p>
      </div>

      <div class="pk-bar">
        <div class="pk-seg" role="tablist" aria-label="Jenis peringkat">
          <button type="button" role="tab" data-jenis="desa" aria-selected="true">Desa</button>
          <button type="button" role="tab" data-jenis="kecamatan" aria-selected="false">Kecamatan</button>
        </div>

        <div class="pk-chips" id="pkChips">
          <button type="button" class="pk-chip" data-periode="bulan_ini" aria-pressed="false">Bulan ini</button>
          <button type="button" class="pk-chip" data-periode="bulan_lalu" aria-pressed="false">Bulan lalu</button>
          <button type="button" class="pk-chip" data-periode="tahun_ini" aria-pressed="false">Tahun ini</button>
          <button type="button" class="pk-chip" data-periode="tahun_lalu" aria-pressed="false">Tahun lalu</button>

          <div class="pk-pick">
            <button type="button" class="pk-chip" id="pkRangeBtn" aria-pressed="false" aria-haspopup="dialog" aria-expanded="false">
              <i class="bi bi-calendar3"></i><span id="pkRangeLabel">Pilih tanggal</span>
            </button>
            <div class="pk-pop" id="pkPop" role="dialog" aria-label="Pilih rentang tanggal" hidden>
              <div class="pk-ch">
                <button type="button" class="pk-ic" id="pkPrev" aria-label="Bulan sebelumnya"><i class="bi bi-chevron-left"></i></button>
                <button type="button" class="pk-title" id="pkTitle" aria-label="Pilih bulan dan tahun"></button>
                <button type="button" class="pk-ic" id="pkNext" aria-label="Bulan berikutnya"><i class="bi bi-chevron-right"></i></button>
                <button type="button" class="pk-ic" id="pkClose" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
              </div>
              <div id="pkBody"></div>
              <div class="pk-foot">
                <span class="pk-sel" id="pkSel">Pilih tanggal awal</span>
                <button type="button" class="pk-btn" id="pkReset">Hapus</button>
                <button type="button" class="pk-btn primary" id="pkApply" disabled>Terapkan</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="pk-meta">
        <div class="pk-per" id="pkPer">Memuat peringkat...</div>
        <input type="search" class="pk-search" id="pkSearch" placeholder="Cari nama desa atau kecamatan" aria-label="Cari">
      </div>

      <div id="pkBanner"></div>
      <div class="pk-list" id="pkList" aria-live="polite"></div>
    </div>
  </section>
</main>

@push('scripts')
@verbatim
<script>
(function () {
  var root = document.getElementById('pk');
  var API = { desa: root.dataset.desa, kecamatan: root.dataset.kecamatan };
  var DEFAULT_PERIODE = 'tahun_ini';
  var BULAN = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
  var BULAN_S = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

  var state = { jenis: 'desa', periode: DEFAULT_PERIODE, mulai: null, akhir: null, items: [], meta: null, req: 0 };

  // ---------- util ----------
  function pad(n) { return (n < 10 ? '0' : '') + n; }
  function iso(y, m, d) { return y + '-' + pad(m + 1) + '-' + pad(d); }
  function parseIso(s) { var p = s.split('-'); return { y: +p[0], m: +p[1] - 1, d: +p[2] }; }
  function fmt(s, short) { var p = parseIso(s); return p.d + ' ' + (short ? BULAN_S[p.m] : BULAN[p.m]) + ' ' + p.y; }
  function rangeShort(a, b) {
    if (a === b) return fmt(a, true);
    var x = parseIso(a), y = parseIso(b);
    return x.y === y.y ? x.d + ' ' + BULAN_S[x.m] + ' \u2013 ' + fmt(b, true) : fmt(a, true) + ' \u2013 ' + fmt(b, true);
  }
  function fmtRange(a, b) { return a === b ? fmt(a) : fmt(a) + ' \u2013 ' + fmt(b); }
  function el(tag, cls, text) { var e = document.createElement(tag); if (cls) e.className = cls; if (text != null) e.textContent = text; return e; }
  var today = new Date(), TODAY = iso(today.getFullYear(), today.getMonth(), today.getDate());

  // ---------- ambil data ----------
  function buildUrl() {
    var q = new URLSearchParams();
    if (state.periode === 'custom') { q.set('periode', 'custom'); q.set('mulai', state.mulai); q.set('akhir', state.akhir); }
    else { q.set('periode', state.periode); }
    return API[state.jenis] + '?' + q.toString();
  }

  function load() {
    var my = ++state.req;
    renderControls();
    document.getElementById('pkPer').textContent = 'Memuat peringkat...';
    document.getElementById('pkBanner').innerHTML = '';
    var list = document.getElementById('pkList');
    list.innerHTML = ''; list.appendChild(noteBox('Memuat data', 'Mohon tunggu sebentar.'));

    fetch(buildUrl(), { headers: { 'Accept': 'application/json' } })
      .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, j: j }; }); })
      .then(function (res) {
        if (my !== state.req) return;
        if (!res.ok || !res.j || !res.j.data) {
          var msg = (res.j && res.j.error && res.j.error.message) || 'Data peringkat tidak bisa dimuat.';
          return showError(msg);
        }
        state.items = res.j.data.items || [];
        state.meta = res.j.data;
        render();
      })
      .catch(function () { if (my === state.req) showError('Tidak bisa terhubung ke server. Pastikan Apache dan MySQL menyala, lalu coba lagi.'); });

    var u = new URL(location.href);
    u.searchParams.set('jenis', state.jenis); u.searchParams.set('periode', state.periode);
    if (state.periode === 'custom') { u.searchParams.set('mulai', state.mulai); u.searchParams.set('akhir', state.akhir); }
    else { u.searchParams.delete('mulai'); u.searchParams.delete('akhir'); }
    history.replaceState(null, '', u);
  }

  function noteBox(title, text) { var d = el('div', 'pk-note'); d.appendChild(el('b', null, title)); d.appendChild(document.createTextNode(text)); return d; }

  function showError(msg) {
    document.getElementById('pkPer').textContent = 'Gagal memuat';
    var list = document.getElementById('pkList'); list.innerHTML = '';
    var box = noteBox('Peringkat gagal dimuat', msg);
    var b = el('button', 'pk-btn primary', 'Coba lagi'); b.type = 'button'; b.style.marginTop = '12px'; b.onclick = load;
    box.appendChild(document.createElement('br')); box.appendChild(b);
    list.appendChild(box);
  }

  // ---------- tampilan daftar ----------
  function render() {
    var m = state.meta, p = m.periode;
    var unit = state.jenis === 'desa' ? 'desa' : 'kecamatan';
    var per = document.getElementById('pkPer'); per.innerHTML = '';
    var b = el('b', null, p.label + ': '); per.appendChild(b);
    per.appendChild(document.createTextNode(fmtRange(p.mulai, p.akhir) + ' \u00b7 ' + m.total + ' ' + unit));

    var q = document.getElementById('pkSearch').value.trim().toLowerCase();
    var max = 0, totalPoin = 0;
    state.items.forEach(function (it) { if (it.poin > max) max = it.poin; totalPoin += it.poin; });

    var banner = document.getElementById('pkBanner'); banner.innerHTML = '';
    if (totalPoin === 0 && state.items.length) {
      banner.appendChild(el('div', 'pk-banner', 'Belum ada laporan yang disetujui akhir pada periode ini, jadi semua poin masih 0. Coba pilih periode lain.'));
    }

    var list = document.getElementById('pkList'); list.innerHTML = '';
    var shown = state.items.filter(function (it) {
      if (!q) return true;
      return (it.nama + ' ' + (it.kecamatan || '')).toLowerCase().indexOf(q) !== -1;
    });
    if (!shown.length) {
      list.appendChild(noteBox(state.items.length ? 'Tidak ada hasil' : 'Belum ada data', state.items.length ? 'Tidak ada ' + unit + ' dengan kata kunci itu.' : 'Data ' + unit + ' belum tersedia.'));
      return;
    }
    var frag = document.createDocumentFragment();
    shown.forEach(function (it) { frag.appendChild(row(it, max)); });
    list.appendChild(frag);
  }

  function row(it, max) {
    var r = el('div', 'pk-row' + (it.rank <= 3 && it.poin > 0 ? ' r' + it.rank : '') + (it.poin === 0 ? ' zero' : ''));
    r.appendChild(el('div', 'pk-rank', it.rank));

    var av = el('div', 'pk-av');
    var initial = (it.nama || '?').replace(/^(kelurahan|desa)\s+/i, '').charAt(0).toUpperCase();
    if (it.foto) {
      var img = new Image(); img.alt = ''; img.loading = 'lazy'; img.src = it.foto;
      img.onerror = function () { av.textContent = initial; };
      av.appendChild(img);
    } else { av.textContent = initial; }
    r.appendChild(av);

    var who = el('div'); who.appendChild(el('div', 'pk-name', it.nama));
    who.appendChild(el('div', 'pk-sub', state.jenis === 'desa' ? 'Kecamatan ' + it.kecamatan : it.jumlah_desa + ' desa'));
    r.appendChild(who);

    var bc = el('div', 'pk-bar-col'); var bw = el('div', 'pk-barwrap'); var bi = document.createElement('i');
    bi.style.width = (max > 0 ? Math.round(it.poin / max * 100) : 0) + '%';
    bw.appendChild(bi); bc.appendChild(bw); r.appendChild(bc);

    var pts = el('div', 'pk-pts', new Intl.NumberFormat('id-ID').format(it.poin)); pts.appendChild(el('small', null, 'poin'));
    r.appendChild(pts);
    return r;
  }

  // ---------- kontrol ----------
  function renderControls() {
    document.querySelectorAll('.pk-seg button').forEach(function (b) { b.setAttribute('aria-selected', b.dataset.jenis === state.jenis); });
    document.querySelectorAll('.pk-chip[data-periode]').forEach(function (b) { b.setAttribute('aria-pressed', b.dataset.periode === state.periode); });
    var rb = document.getElementById('pkRangeBtn'), isC = state.periode === 'custom';
    rb.setAttribute('aria-pressed', isC);
    document.getElementById('pkRangeLabel').textContent = isC ? rangeShort(state.mulai, state.akhir) : 'Pilih tanggal';
  }

  document.querySelectorAll('.pk-seg button').forEach(function (b) { b.addEventListener('click', function () { if (state.jenis !== b.dataset.jenis) { state.jenis = b.dataset.jenis; load(); } }); });
  document.querySelectorAll('.pk-chip[data-periode]').forEach(function (b) { b.addEventListener('click', function () { state.periode = b.dataset.periode; closePop(); load(); }); });
  document.getElementById('pkSearch').addEventListener('input', function () { if (state.meta) render(); });

  // ---------- kalender rentang tanggal ----------
  var pop = document.getElementById('pkPop'), body = document.getElementById('pkBody');
  var cal = { y: today.getFullYear(), m: today.getMonth(), a: null, b: null, mode: 'days', yearView: today.getFullYear() };

  function openPop() {
    if (state.periode === 'custom') { cal.a = state.mulai; cal.b = state.akhir; var p = parseIso(state.mulai); cal.y = p.y; cal.m = p.m; }
    else { cal.a = cal.b = null; }
    cal.mode = 'days'; pop.hidden = false;
    document.getElementById('pkRangeBtn').setAttribute('aria-expanded', 'true'); drawCal();
  }
  function closePop() { pop.hidden = true; document.getElementById('pkRangeBtn').setAttribute('aria-expanded', 'false'); }

  document.getElementById('pkRangeBtn').addEventListener('click', function () { pop.hidden ? openPop() : closePop(); });
  document.getElementById('pkClose').addEventListener('click', closePop);
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !pop.hidden) { closePop(); document.getElementById('pkRangeBtn').focus(); } });

  // PERBAIKAN: composedPath() dicatat sebelum tombol dihapus oleh drawCal(),
  // jadi klik di dalam kalender tidak dianggap klik di luar.
  document.addEventListener('click', function (e) {
    var box = document.querySelector('.pk-pick');
    if (!pop.hidden && e.composedPath().indexOf(box) === -1) closePop();
  });

  document.getElementById('pkPrev').addEventListener('click', function () {
    if (cal.mode === 'months') { cal.yearView--; } else { cal.m--; if (cal.m < 0) { cal.m = 11; cal.y--; } }
    drawCal();
  });
  document.getElementById('pkNext').addEventListener('click', function () {
    if (cal.mode === 'months') { cal.yearView++; } else { cal.m++; if (cal.m > 11) { cal.m = 0; cal.y++; } }
    drawCal();
  });
  document.getElementById('pkTitle').addEventListener('click', function () {
    cal.mode = cal.mode === 'days' ? 'months' : 'days'; cal.yearView = cal.y; drawCal();
  });
  document.getElementById('pkReset').addEventListener('click', function () { cal.a = cal.b = null; drawCal(); });
  document.getElementById('pkApply').addEventListener('click', function () {
    if (!cal.a || !cal.b) return;
    state.periode = 'custom'; state.mulai = cal.a; state.akhir = cal.b; closePop(); load();
  });

  function drawCal() {
    var title = document.getElementById('pkTitle');
    title.innerHTML = '';
    title.appendChild(document.createTextNode(cal.mode === 'months' ? String(cal.yearView) : BULAN[cal.m] + ' ' + cal.y + ' '));
    var caret = document.createElement('i'); caret.className = 'bi bi-caret-down-fill'; caret.style.cssText = 'font-size:10px;color:var(--pk-blue)'; title.appendChild(caret);
    body.innerHTML = '';

    if (cal.mode === 'months') {
      var g = el('div', 'pk-months');
      BULAN.forEach(function (n, i) {
        var b = el('button', null, n); b.type = 'button';
        if (cal.yearView === cal.y && i === cal.m) b.setAttribute('aria-current', 'true');
        b.onclick = function () { cal.y = cal.yearView; cal.m = i; cal.mode = 'days'; drawCal(); };
        g.appendChild(b);
      });
      body.appendChild(g);
    } else {
      var wd = el('div', 'pk-wd'); ['Sen','Sel','Rab','Kam','Jum','Sab','Min'].forEach(function (d) { wd.appendChild(el('span', null, d)); });
      body.appendChild(wd);
      var grid = el('div', 'pk-days');
      var first = (new Date(cal.y, cal.m, 1).getDay() + 6) % 7;      // Senin = 0
      var n = new Date(cal.y, cal.m + 1, 0).getDate();
      for (var i = 0; i < first; i++) grid.appendChild(el('span', 'pk-day empty'));
      for (var d = 1; d <= n; d++) {
        (function (d) {
          var s = iso(cal.y, cal.m, d), b = el('button', 'pk-day', d); b.type = 'button'; b.dataset.d = s;
          if (s === TODAY) b.classList.add('today');
          b.onclick = function () { pick(s); };
          b.onmouseenter = function () { if (cal.a && !cal.b) paint(s); };
          grid.appendChild(b);
        })(d);
      }
      grid.onmouseleave = function () { paint(null); };
      body.appendChild(grid);
      paint(null);
    }
    var ok = cal.a && cal.b;
    document.getElementById('pkApply').disabled = !ok;
    document.getElementById('pkSel').textContent = ok ? fmtRange(cal.a, cal.b) : (cal.a ? 'Pilih tanggal akhir' : 'Pilih tanggal awal');
  }

  function pick(s) {
    if (!cal.a || cal.b) { cal.a = s; cal.b = null; }
    else if (s < cal.a) { cal.b = cal.a; cal.a = s; }
    else { cal.b = s; }
    drawCal();
  }

  function paint(hover) {
    var a = cal.a, b = cal.b || (a && hover && hover > a ? hover : null);
    body.querySelectorAll('.pk-day[data-d]').forEach(function (btn) {
      var s = btn.dataset.d, isS = !!a && s === a, isE = !!b && s === b, span = !!(a && b && a !== b);
      btn.classList.toggle('edge', isS || isE);
      btn.classList.toggle('s', isS && span);
      btn.classList.toggle('e', isE && span);
      btn.classList.toggle('inrange', span && s > a && s < b);
    });
  }

  // ---------- mulai ----------
  var qs = new URLSearchParams(location.search);
  if (qs.get('jenis') === 'kecamatan') state.jenis = 'kecamatan';
  var kode = qs.get('periode');
  if (['bulan_ini','bulan_lalu','tahun_ini','tahun_lalu'].indexOf(kode) !== -1) state.periode = kode;
  else if (kode === 'custom' && /^\d{4}-\d{2}-\d{2}$/.test(qs.get('mulai') || '') && /^\d{4}-\d{2}-\d{2}$/.test(qs.get('akhir') || '')) {
    state.periode = 'custom'; state.mulai = qs.get('mulai'); state.akhir = qs.get('akhir');
  }
  load();
})();
</script>
@endverbatim
@endpush

@endsection
