var IG="https://www.instagram.com/dpc.hillsi.sleman/";
var HQ={addr:"[Alamat sekretariat DPC HILLSI Sleman — isi alamat lengkap]",tel:"(0274) 000 000",email:"dpc.hillsi.sleman@example.com"};
var G=["#0b5d63","#c2410c","#4338ca","#047857","#b45309","#be185d","#1d4ed8","#7e22ce","#0f766e","#a16207","#9f1239","#334155"];

var idtcGallery=[];
for(var gi=1;gi<=104;gi++){idtcGallery.push("images/idtc/foto"+gi+".jpg");}

var L=[
{
  id:"drone-indonesia",
  n:"Indonesia Drone Training Center (IDTC, PT Jogja Creative Production)",
  f:"Teknologi Drone",
  e:"🚁",
  logo:"images/idtc/logo.png",
  gallery:idtcGallery,
  a:"Lembaga pelatihan drone profesional yang fokus pada keterampilan terbang, pengoperasian kamera, dan keselamatan penerbangan langsung di lapangan. Founder: Franko Nero. Moto: \"Berilmu untuk Berbagi.\"",
  s:[
    "Pelatihan drone dasar",
    "Pemetaan dan fotogrametri",
    "Pertanian",
    "Pertambangan",
    "Inspeksi industri",
    "Fotografi udara",
    "Pencarian dan penyelamatan (SAR)"
  ],
  adm:"Admin IDTC",
  wa:"+62 856-0060-4388",
  walink:"https://wa.me/6285600604388",
  addr:"Perum Jl. Griya Mlati Indah No. B4, Mulungan Kulon, Sendangadi, Mlati, Sleman, DIY 55285",
  mail:"jogjacreativeproduction@gmail.com",
  ig:"@idtc.drone",
  iglink:"https://www.instagram.com/idtc.drone",
  web:"https://pelatihandronejogja.my.id",
  maps:"https://www.google.com/maps/search/?api=1&query=Indonesia+Drone+Training+Center+Mlati+Sleman",
  why:[
    {t:"Instruktur Berpengalaman",d:"Dibimbing langsung oleh praktisi dan instruktur drone profesional berlisensi dengan jam terbang tinggi di berbagai industri."},
    {t:"Safety dan SOP Standar",d:"Menjunjung tinggi standar keselamatan penerbangan ketat, regulasi resmi, serta manajemen operasional yang aman di lapangan."},
    {t:"Footage Stabil dan Presisi",d:"Teknik navigasi akurat dan penguasaan kamera tingkat lanjut untuk menghasilkan visual sinematik serta data spasial presisi tinggi."}
  ],
  partners:[
    "UGM","AMIKOM","Mercu Buana Yogyakarta","Atma Jaya Yogyakarta","UAD","UNU Yogyakarta","BSI","ISI Padangpanjang","Pemkab Sleman","Dinas Pendidikan Sleman","Disnaker Sleman","BPBD Bantul","BPBD Gunungkidul"
  ]
},
{n:"LPK Contoh Tata Boga",f:"Tata Boga",e:"🍳"},{n:"LPK Contoh Tata Busana",f:"Tata Busana",e:"🧵"},
{n:"LPK Contoh Komputer dan Desain",f:"Teknologi Informasi",e:"💻"},{n:"LPK Contoh Bahasa Jepang",f:"Bahasa Asing",e:"🗾"},
{n:"LPK Contoh Perhotelan",f:"Perhotelan",e:"🏨"},{n:"LPK Contoh Otomotif",f:"Otomotif",e:"🔧"},
{n:"LPK Contoh Tata Rias",f:"Kecantikan",e:"💄"},{n:"LPK Contoh Perawat Lansia",f:"Kesehatan",e:"🩺"},
{n:"LPK Contoh Las dan Konstruksi",f:"Konstruksi",e:"🏗️"},{n:"LPK Contoh Barista",f:"Kuliner dan Kafe",e:"☕"},
{n:"LPK Contoh Administrasi Perkantoran",f:"Administrasi",e:"📊"}
];
L.forEach(function(x,i){
x.id=x.id||(i?"lpk-"+(i+1):"drone-indonesia");
x.c=G[i];
x.a=x.a||"[Deskripsi singkat "+x.n+": profil, sejarah, dan keunggulan lembaga. Data contoh, ganti dengan data asli.]";
x.s=x.s||["Pelatihan "+x.f+" dasar","Pelatihan "+x.f+" lanjutan","Sertifikasi kompetensi","Penyaluran kerja"];
x.adm=x.adm||"[Nama Admin]";
x.wa=x.wa||"0812 0000 0000";
x.walink=x.walink||"https://wa.me/6281200000000";
x.addr=x.addr||("["+"Alamat "+x.n+", Kabupaten Sleman, D.I. Yogyakarta]");
x.mail=x.mail||"info@lpk-contoh.example";
x.ig=x.ig||"@lpk_contoh";
x.iglink=x.iglink||IG;
x.maps=x.maps||("https://www.google.com/maps/search/?api=1&query="+encodeURIComponent(x.n+" Sleman"));
x.k=(x.n+" "+x.f+" "+x.s.join(" ")+" "+(x.a||"")).toLowerCase();
});
var Q="",CAT="Semua";
var $=function(i){return document.getElementById(i)};
function go(h){if(location.hash.replace("#","")===h&&!h){window.scrollTo(0,0);return}location.hash=h}
function sec(id){if(location.hash&&location.hash!=="#"){location.hash="";setTimeout(function(){sec(id)},80);return}var el=$(id);if(el)el.scrollIntoView()}
function esc(s){return String(s).replace(/[&<>"]/g,function(c){return{"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;"}[c]})}
function match(x,q){q=q.trim().toLowerCase();return !q||q.split(/\s+/).every(function(w){return x.k.indexOf(w)>-1})}
function home(){
var cats=["Semua"].concat(L.map(function(x){return x.f}));
return `<div class="hero"><div class="blob b1"></div><div class="blob b2"></div><div class="wrap">
<span class="tag">Sejak 1982 · Dewan Pimpinan Cabang Sleman</span>
<h1>Wadah Bersama <em>Lembaga Pelatihan Kerja</em> di Kabupaten Sleman</h1>
<p class="lead">Mengoordinasikan LPK untuk meningkatkan mutu kompetensi SDM, bersinergi dengan pemerintah dan industri, serta menekan angka pengangguran.</p>
<div class="sbox"><div class="sbar"><input id="hq" value="${esc(Q)}" placeholder="Cari pelatihan, mis. drone, tata boga, bahasa…" autocomplete="off" oninput="suggest()" onfocus="suggest()" onkeydown="if(event.key==='Enter')doSearch()"><button onclick="doSearch()">Cari</button></div><div class="sg" id="sg"></div></div>
<div class="hot">Populer: <a onclick="quick('drone')">Drone</a><a onclick="quick('tata')">Tata</a><a onclick="quick('bahasa')">Bahasa</a><a onclick="quick('komputer')">Komputer</a></div>
<div class="stats"><div><b data-to="1982" data-plain="1">1982</b><span>Tahun berdiri HILLSI</span></div><div><b data-to="12">12</b><span>LPK ditampilkan</span></div><div><b data-to="4">4</b><span>Layanan utama per LPK</span></div></div></div></div>
<section id="tentang"><div class="wrap"><div class="eye rv">Tentang Kami</div><h2 class="rv">Mengenal HILLSI dan DPC Sleman</h2><p class="sub rv">Himpunan yang menjadi jembatan antara lembaga pelatihan, pemerintah, dan dunia industri.</p><div class="grid3">
<div class="card rv"><div class="ic">🏛️</div><h3>HILLSI</h3><p>Himpunan Lembaga Pelatihan Seluruh Indonesia, didirikan sejak 1982. Berkiprah sebagai wadah dan wahana komunikasi, informasi, representasi, konsultasi, dan fasilitasi penyelenggaraan pelatihan di seluruh Indonesia.</p></div>
<div class="card rv"><div class="ic">📍</div><h3>DPC Kabupaten Sleman</h3><p>Dewan Pimpinan Cabang yang menaungi dan mengoordinasikan puluhan Lembaga Pelatihan Kerja (LPK) di wilayah Kabupaten Sleman, D.I. Yogyakarta.</p></div>
<div class="card rv"><div class="ic">🎯</div><h3>Tujuan Utama</h3><p>Meningkatkan mutu kompetensi SDM, memperkuat sinergi dengan pemerintah dan industri (link and match), dan membantu menekan pengangguran melalui pelatihan vokasi.</p></div></div>
<div class="roles rv"><span>Komunikasi</span><span>Informasi</span><span>Representasi</span><span>Konsultasi</span><span>Fasilitasi</span></div></div></section>
<section id="lembaga" class="alt"><div class="wrap"><div class="eye rv">Direktori</div><h2 class="rv">Lembaga Pelatihan</h2><p class="sub rv">LPK di bawah koordinasi HILLSI Sleman. Gunakan kolom pencarian di atas, atau pilih bidang di bawah.</p>
<div class="lsearch"><span class="cnt" id="cnt"></span><span id="rs"></span></div>
<div class="chips" id="chips">${cats.map(function(c){return'<button class="chip" data-c="'+esc(c)+'" onclick="setCat(this.dataset.c)">'+esc(c)+'</button>'}).join("")}</div>
<div class="lpk" id="list"></div></div></section>
<section id="kontak"><div class="wrap"><div class="eye rv">Kontak</div><h2 class="rv">Hubungi Kami</h2><p class="sub rv">Sekretariat DPC HILLSI Kabupaten Sleman</p><div class="contact"><div class="card rv">
<div class="row"><span>📍</span><span>${esc(HQ.addr)}</span></div><div class="row"><span>📞</span><span>${HQ.tel}</span></div>
<div class="row"><span>✉️</span><a href="mailto:${HQ.email}">${HQ.email}</a></div><div class="row"><span>📸</span><a href="${IG}" target="_blank" rel="noopener">@dpc.hillsi.sleman</a></div>
<p class="note">Alamat, telepon, dan email masih contoh.</p></div>
<div class="mapbox rv"><div><div style="font-size:44px">🗺️</div><p>Lokasi sekretariat di Google Maps</p><a class="btn p" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query=Sleman+Yogyakarta">Buka Maps</a></div></div></div></div></section>`;
}
function draw(){
var h="",n=0;
L.forEach(function(x){if((CAT!=="Semua"&&x.f!==CAT)||!match(x,Q))return;n++;
h+=`<div class="lc" onclick="go('${x.id}')"><div class="cv" style="background:linear-gradient(135deg,${x.c},#000a)">${x.logo?`<img src="${x.logo}" alt="${esc(x.n)}" style="max-height:76px;max-width:80%;object-fit:contain;position:relative;z-index:1;filter:drop-shadow(0 2px 6px rgba(0,0,0,.45))">`:x.e}</div><div class="b"><h4>${esc(x.n)}</h4><span class="pill">${esc(x.f)}</span></div><span class="go">→</span></div>`});
$("list").innerHTML=h||'<div class="empty">😕 Tidak ada lembaga yang cocok. Coba kata kunci lain.</div>';
$("cnt").textContent=n+" dari "+L.length+" lembaga";
$("rs").innerHTML=Q.trim()?'· Hasil untuk “'+esc(Q.trim())+'” <button class="rst" onclick="resetQ()">Reset</button>':"";
document.querySelectorAll(".chip").forEach(function(c){c.classList.toggle("on",c.dataset.c===CAT)});
}
function setCat(c){CAT=c;draw()}
function resetQ(){Q="";CAT="Semua";if($("hq"))$("hq").value="";draw()}
function suggest(){
var v=$("hq").value,box=$("sg");
if(!v.trim()){box.classList.remove("on");return}
var r=L.filter(function(x){return match(x,v)}).slice(0,5);
box.innerHTML=r.length?r.map(function(x){return`<div onclick="go('${x.id}')"><span class="e">${x.e}</span><span><b>${esc(x.n)}</b><small>${esc(x.f)}</small></span></div>`}).join(""):'<div class="none">Tidak ditemukan</div>';
box.classList.add("on");
}
function doSearch(){Q=$("hq").value;CAT="Semua";$("sg").classList.remove("on");draw();$("lembaga").scrollIntoView()}
function quick(w){$("hq").value=w;doSearch()}
document.addEventListener("click",function(e){var s=$("sg");if(s&&!e.target.closest(".sbox"))s.classList.remove("on")});

function renderGal(x){
  var galLimit=24;
  var isAll=window._showAllGal;
  var displayed=x.gallery?x.gallery.slice(0,isAll?x.gallery.length:galLimit):[];
  var h="";
  if(x.gallery&&x.gallery.length){
    h=displayed.map(function(src,idx){
      return `<div class="gal-item" onclick="openLb(${idx})" title="Klik untuk memperbesar (Foto ${idx+1})">`+
             `<img src="${src}" alt="Foto Kegiatan IDTC ${idx+1}" loading="lazy">`+
             `<div class="gal-overlay">🔍</div>`+
             `</div>`;
    }).join("");
  } else {
    for(var i=1;i<=6;i++)h+=`<div style="background:linear-gradient(135deg,${x.c},#000a)">${x.e}<br>Foto ${i}</div>`;
  }
  return h;
}

function toggleGal(){
  window._showAllGal=!window._showAllGal;
  var x=L.filter(function(l){return l.id===(location.hash.replace("#","")||"drone-indonesia")})[0];
  if(x&&$("gal-container")){
    $("gal-container").innerHTML=renderGal(x);
    var btn=$("gal-toggle-btn");
    if(btn)btn.textContent=window._showAllGal?'Tampilkan Lebih Sedikit':('Tampilkan Semua '+x.gallery.length+' Foto Kegiatan');
  }
}

function detail(x){
var gal=renderGal(x);
var whySec="";
if(x.why&&x.why.length){
  whySec=`<h2 style="margin-top:40px">Mengapa IDTC?</h2><div class="grid3" style="margin-top:16px">`+
  x.why.map(function(w,idx){
    var icons=["👨‍✈️","🛡️","🎯"];
    return `<div class="card"><div class="ic">${icons[idx]||"✨"}</div><h3>${esc(w.t)}</h3><p>${esc(w.d)}</p></div>`;
  }).join("")+`</div>`;
}
var partnerSec="";
if(x.partners&&x.partners.length){
  partnerSec=`<h2 style="margin-top:40px">Mitra</h2><div class="roles" style="margin-top:16px">`+
  x.partners.map(function(p){return `<span>${esc(p)}</span>`}).join("")+`</div>`;
}
return `<div class="wrap"><button class="back" onclick="go('')">← Kembali ke Beranda</button>
<div class="dcover" style="background:linear-gradient(160deg,${x.c},#000c);position:relative">
  ${x.logo?`
    <div style="position:absolute;right:-15px;bottom:-15px;opacity:0.12;pointer-events:none">
      <img src="${x.logo}" alt="" style="height:240px;object-fit:contain;filter:brightness(2)">
    </div>
    <div style="position:absolute;right:30px;top:24px;background:#ffffff;padding:10px 18px;border-radius:16px;box-shadow:0 8px 24px rgba(0,0,0,.3);display:grid;place-items:center">
      <img src="${x.logo}" alt="Logo ${esc(x.n)}" style="height:68px;max-width:190px;object-fit:contain;display:block">
    </div>
  `:`<span class="big">${x.e}</span>`}
  <div><small>${esc(x.f)} · Profil Resmi</small><h1>${esc(x.n)}</h1></div>
</div>
<div class="two"><div><div class="card"><h3>Tentang LPK</h3><p>${esc(x.a)}</p></div>
<div class="card" style="margin-top:20px"><h3>Layanan</h3><ul class="svc">${x.s.map(function(s){return"<li>"+esc(s)+"</li>"}).join("")}</ul></div></div>
<div><div class="card"><h3>Kontak Admin</h3><p>${x.adm}</p><p style="margin:4px 0 14px">${x.wa}</p><div style="display:flex;gap:10px;flex-wrap:wrap"><a class="btn s" target="_blank" rel="noopener" href="${x.walink}">Chat WhatsApp</a>${x.web?`<a class="btn p" target="_blank" rel="noopener" href="${x.web}">Kunjungi Website Resmi</a>`:""}</div></div>
<div class="card" style="margin-top:20px"><h3>Info dan Media Sosial</h3><div class="row"><span>📍</span><span>${esc(x.addr)}</span></div><div class="row"><span>✉️</span><a href="mailto:${x.mail}">${x.mail}</a></div><div class="row"><span>📸</span><a href="${x.iglink}" target="_blank" rel="noopener">${x.ig}</a></div>${x.web?`<div class="row"><span>🌐</span><a href="${x.web}" target="_blank" rel="noopener">${x.web.replace(/^https?:\/\//,"")}</a></div>`:""}
<a target="_blank" rel="noopener" href="${x.maps}">Buka di Google Maps →</a></div></div></div>
${whySec}
${partnerSec}
<h2 style="margin-top:40px">${x.gallery?'Galeri Sertifikasi dan Pelatihan ('+x.gallery.length+' Foto)':'Galeri'}</h2>
<div class="gal" id="gal-container">${gal}</div>
${x.gallery&&x.gallery.length>24?`
  <div style="text-align:center;margin-top:24px">
    <button id="gal-toggle-btn" class="btn s" onclick="toggleGal()" style="cursor:pointer">
      ${window._showAllGal?'Tampilkan Lebih Sedikit':('Tampilkan Semua '+x.gallery.length+' Foto Kegiatan')}
    </button>
  </div>
`:''}
${x.gallery?`<p class="note">Dokumentasi kegiatan dan pelatihan resmi IDTC dari pelatihandronejogja.my.id. Klik foto untuk memperbesar.</p>`:`<p class="note">Data dan foto masih contoh.</p>`}
<div style="height:60px"></div></div>`;
}

var curLbIdx=0;
var curGallery=[];

function openLb(idx){
  var x=L.filter(function(l){return l.id===(location.hash.replace("#","")||"drone-indonesia")})[0];
  curGallery=(x&&x.gallery)?x.gallery:[];
  curLbIdx=idx;
  updateLb();
  var lb=$("lb");
  if(lb)lb.classList.add("on");
}

function updateLb(){
  if(!curGallery.length)return;
  if(curLbIdx<0)curLbIdx=curGallery.length-1;
  if(curLbIdx>=curGallery.length)curLbIdx=0;
  var img=$("lb-img"),cnt=$("lb-cnt");
  if(img)img.src=curGallery[curLbIdx];
  if(cnt)cnt.textContent="Foto "+(curLbIdx+1)+" dari "+curGallery.length;
}

function nextLb(e){
  if(e)e.stopPropagation();
  curLbIdx++;
  updateLb();
}

function prevLb(e){
  if(e)e.stopPropagation();
  curLbIdx--;
  updateLb();
}

function closeLb(e){
  if(e&&e.target===$("lb-img"))return;
  var lb=$("lb");if(lb)lb.classList.remove("on");
}

document.addEventListener("keydown",function(e){
  var lb=$("lb");
  if(!lb||!lb.classList.contains("on"))return;
  if(e.key==="Escape")closeLb();
  if(e.key==="ArrowRight")nextLb();
  if(e.key==="ArrowLeft")prevLb();
});

function reveal(){
var els=document.querySelectorAll(".rv");
if(!("IntersectionObserver" in window)){els.forEach(function(e){e.classList.add("in")});return}
var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add("in");io.unobserve(e.target)}})},{threshold:.12});
els.forEach(function(e){io.observe(e)});
setTimeout(function(){els.forEach(function(e){e.classList.add("in")})},2500);
document.querySelectorAll("[data-to]").forEach(function(el){if(el.dataset.plain)return;var t=+el.dataset.to,s=null;
function st(ts){s=s||ts;var p=Math.min((ts-s)/900,1);el.textContent=Math.round(t*p);if(p<1)requestAnimationFrame(st)}requestAnimationFrame(st)});
}
function route(){
var h=location.hash.replace("#",""),x=L.filter(function(l){return l.id===h})[0];
$("app").innerHTML=x?detail(x):home();
if(x){window.scrollTo(0,0)}else{draw();reveal();if(!window._seen)window.scrollTo(0,0)}
window._seen=1;
}
window.addEventListener("hashchange",route);route();
