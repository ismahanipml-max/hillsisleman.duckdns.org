<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>@yield('title', 'DPC HILLSI Kabupaten Sleman')</title>
<link rel="icon" type="image/png" href="{{ asset('images/logo-hillsi.png') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="{{ asset('style.css') }}">
@stack('styles')
</head>
<body>
<header class="nav"><div class="wrap">
<a href="{{ url('/') }}" class="logo"><img src="{{ asset('images/logo-hillsi.png') }}" alt="Logo HILLSI Sleman"><span>HILLSI Sleman</span></a>
<nav>
  <a href="{{ url('/') }}">Beranda</a>
  <a href="{{ url('/#tentang') }}">Tentang</a>
  <a href="{{ url('/#lembaga') }}">LPK Pelatihan</a>
  <a href="{{ url('/#kontak') }}">Kontak</a>
</nav>
</div></header>

<main id="app">
@yield('content')
</main>

<div id="lb" class="lb" onclick="closeLb(event)">
  <button class="lb-c" onclick="closeLb()" aria-label="Tutup">&times;</button>
  <button class="lb-btn lb-prev" onclick="prevLb(event)" aria-label="Sebelumnya">&#10094;</button>
  <img id="lb-img" src="" alt="Perbesar Foto">
  <button class="lb-btn lb-next" onclick="nextLb(event)" aria-label="Selanjutnya">&#10095;</button>
  <div id="lb-cnt" class="lb-cnt"></div>
</div>

<script>
var curLbIdx = 0;
var curGallery = [];

function openLb(idx) {
  if (!window._galleryList || !window._galleryList.length) return;
  curGallery = window._galleryList;
  curLbIdx = idx;
  updateLb();
  var lb = document.getElementById("lb");
  if (lb) lb.classList.add("on");
}

function updateLb() {
  if (!curGallery.length) return;
  if (curLbIdx < 0) curLbIdx = curGallery.length - 1;
  if (curLbIdx >= curGallery.length) curLbIdx = 0;
  var img = document.getElementById("lb-img"), cnt = document.getElementById("lb-cnt");
  if (img) img.src = curGallery[curLbIdx];
  if (cnt) cnt.textContent = "Foto " + (curLbIdx + 1) + " dari " + curGallery.length;
}

function nextLb(e) {
  if (e) e.stopPropagation();
  curLbIdx++;
  updateLb();
}

function prevLb(e) {
  if (e) e.stopPropagation();
  curLbIdx--;
  updateLb();
}

function closeLb(e) {
  if (e && e.target === document.getElementById("lb-img")) return;
  var lb = document.getElementById("lb");
  if (lb) lb.classList.remove("on");
}

document.addEventListener("keydown", function(e) {
  var lb = document.getElementById("lb");
  if (!lb || !lb.classList.contains("on")) return;
  if (e.key === "Escape") closeLb();
  if (e.key === "ArrowRight") nextLb();
  if (e.key === "ArrowLeft") prevLb();
});

// Scroll reveal observer
document.addEventListener("DOMContentLoaded", function() {
  var els = document.querySelectorAll(".rv");
  if (!("IntersectionObserver" in window)) {
    els.forEach(function(e) { e.classList.add("in"); });
    return;
  }
  var io = new IntersectionObserver(function(es) {
    es.forEach(function(e) {
      if (e.isIntersecting) {
        e.target.classList.add("in");
        io.unobserve(e.target);
      }
    });
  }, { threshold: .12 });
  els.forEach(function(e) { io.observe(e); });
  setTimeout(function() {
    els.forEach(function(e) { e.classList.add("in"); });
  }, 2500);

  document.querySelectorAll("[data-to]").forEach(function(el) {
    if (el.dataset.plain) return;
    var t = +el.dataset.to, s = null;
    function st(ts) {
      s = s || ts;
      var p = Math.min((ts - s) / 900, 1);
      el.textContent = Math.round(t * p);
      if (p < 1) requestAnimationFrame(st);
    }
    requestAnimationFrame(st);
  });
});
</script>
@stack('scripts')
</body>
</html>

