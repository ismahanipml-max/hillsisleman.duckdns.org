@extends('layouts.public')

@section('title', 'Login Admin · DPC HILLSI Sleman')

@section('content')
<div class="login-wrapper" style="min-height: calc(100vh - 62px - 78px); display: flex; align-items: center; justify-content: center; padding: 48px 20px; background: linear-gradient(135deg, #213A58 0%, #0C6478 100%); position: relative; overflow: hidden;">
  <div class="blob b1" style="opacity: 0.4;"></div>
  <div class="blob b2" style="opacity: 0.35;"></div>

  <div class="wrap" style="width: 100%; max-width: 460px; position: relative; z-index: 2;">
    <div style="background: var(--surface); border-radius: 20px; padding: 36px 30px; box-shadow: 0 24px 60px rgba(33, 58, 88, 0.35); border: 1px solid var(--line);">
      
      <!-- Brand & Header -->
      <div style="text-align: center; margin-bottom: 24px;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 78px; height: 78px; border-radius: 20px; background: #ffffff; padding: 6px; margin-bottom: 14px; box-shadow: 0 8px 24px rgba(12, 100, 120, 0.18); border: 1px solid var(--line);">
          <img src="{{ asset('images/logo-hillsi.png') }}" alt="Logo HILLSI Sleman" style="width: 100%; height: 100%; object-fit: contain;">
        </div>
        <div style="margin-bottom: 8px;">
          <span class="tag" style="background: rgba(70, 223, 177, 0.16); color: #0C6478; border-color: rgba(70, 223, 177, 0.35); font-size: 11px; letter-spacing: 0.05em; font-weight: 800;">
            PANEL ADMINISTRATOR
          </span>
        </div>
        <h1 style="font-size: 22px; font-weight: 800; color: var(--text); margin: 6px 0 6px; line-height: 1.25;">
          DPC HILLSI Sleman
        </h1>
        <p style="font-size: 13px; color: var(--muted); margin: 0; line-height: 1.5;">
          Masukkan password admin untuk mengelola direktori LPK dan pengaturan website.
        </p>
      </div>

      <!-- Alert Status -->
      @if (session('status'))
        <div style="background: rgba(70, 223, 177, 0.15); border: 1px solid #46DFB1; color: #0C6478; padding: 12px 14px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px;">
          {{ session('status') }}
        </div>
      @endif

      <!-- Form Login -->
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom: 18px;">
          <label for="password" style="display: block; font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 8px;">
            Password Admin
          </label>
          <div style="position: relative;">
            <input 
              id="password" 
              type="password" 
              name="password" 
              required 
              autofocus 
              autocomplete="current-password"
              placeholder="Ketik password admin..."
              style="width: 100%; box-sizing: border-box; padding: 13px 44px 13px 14px; border-radius: 12px; border: 2px solid {{ $errors->has('password') ? '#ef4444' : 'var(--line)' }}; background: var(--bg); color: var(--text); font: inherit; font-size: 15px; outline: none; transition: 0.2s;"
              onfocus="this.style.borderColor='#15919B'; this.style.boxShadow='0 0 0 4px rgba(9, 209, 199, 0.25)'"
              onblur="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : 'var(--line)' }}'; this.style.boxShadow='none'"
            >
            <button type="button" onclick="togglePasswordVisibility()" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--muted); padding: 4px; font-size: 16px;" title="Tampilkan/Sembunyikan Password">
              👁️
            </button>
          </div>
          @if ($errors->has('password'))
            <div style="color: #dc2626; font-size: 13px; font-weight: 600; margin-top: 8px; display: flex; align-items: center; gap: 6px;">
              <span>⚠️</span>
              <span>{{ $errors->first('password') }}</span>
            </div>
          @endif
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 22px;">
          <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; color: var(--muted); cursor: pointer; user-select: none;">
            <input type="checkbox" name="remember" checked style="accent-color: #15919B; width: 15px; height: 15px; cursor: pointer;">
            <span>Ingat sesi masuk</span>
          </label>
        </div>

        <button 
          type="submit" 
          style="width: 100%; border: none; border-radius: 12px; padding: 13px 20px; font: 700 15px inherit; font-family: inherit; cursor: pointer; background: linear-gradient(135deg, #0C6478, #15919B); color: #ffffff; transition: 0.25s; box-shadow: 0 8px 22px rgba(12, 100, 120, 0.35); display: flex; align-items: center; justify-content: center; gap: 8px;"
          onmouseover="this.style.background='linear-gradient(135deg, #15919B, #09D1C7)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 26px rgba(9, 209, 199, 0.45)'"
          onmouseout="this.style.background='linear-gradient(135deg, #0C6478, #15919B)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 22px rgba(12, 100, 120, 0.35)'"
        >
          <span>Masuk ke Dashboard</span>
          <span style="font-size: 16px;">&rarr;</span>
        </button>
      </form>

      <div style="text-align: center; margin-top: 22px; padding-top: 18px; border-top: 1px solid var(--line);">
        <a href="{{ url('/') }}" style="color: #0C6478; font-weight: 700; font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s;" onmouseover="this.style.color='#15919B'" onmouseout="this.style.color='#0C6478'">
          <span>&larr;</span>
          <span>Kembali ke Beranda</span>
        </a>
      </div>

    </div>

    <div style="text-align: center; color: rgba(230, 248, 247, 0.8); font-size: 12px; margin-top: 18px;">
      Dewan Pimpinan Cabang HILLSI Kabupaten Sleman
    </div>
  </div>
</div>

<script>
function togglePasswordVisibility() {
  var p = document.getElementById('password');
  if (p) {
    p.type = (p.type === 'password') ? 'text' : 'password';
  }
}
</script>
@endsection
