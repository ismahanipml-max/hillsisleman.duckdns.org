<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Tambah LPK Baru') }}
            </h2>
            <a href="{{ route('admin.lpks.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                ← Kembali ke Daftar LPK
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-lg">
                    <p class="font-bold">Terjadi kesalahan input:</p>
                    <ul class="list-disc list-inside text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.lpks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Card 1: Informasi Pokok -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">1. Informasi Utama</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama LPK *</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Bidang Pelatihan *</label>
                            <input type="text" name="bidang" value="{{ old('bidang') }}" placeholder="mis. Teknologi Drone, Tata Boga" required class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Slug URL (opsional, otomatis jika kosong)</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" placeholder="mis. drone-indonesia" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tagline / Motto</label>
                            <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="mis. Berilmu untuk Berbagi" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tentang Lembaga</label>
                            <textarea name="tentang" rows="3" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('tentang') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ikon / Emoji (default: 🏛️)</label>
                            <input type="text" name="ikon" value="{{ old('ikon', '🏛️') }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Warna Aksen Hex (default: #0b5d63)</label>
                            <input type="text" name="warna" value="{{ old('warna', '#0b5d63') }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Urutan Tampil</label>
                            <input type="number" name="urutan" value="{{ old('urutan', $nextUrutan) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="flex items-center pt-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="aktif" value="1" {{ old('aktif', '1') ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500">
                                <span class="ms-2 text-sm font-semibold text-gray-700">Tampilkan LPK (Status Aktif)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Upload Media -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">2. Upload Gambar & Logo (Maksimal 2 MB per file)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Logo LPK (PNG/JPG, maks 2 MB)</label>
                            <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Cover Header (JPG/PNG, maks 2 MB)</label>
                            <input type="file" name="cover" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tambah Foto Galeri Kegiatan (Bisa pilih beberapa sekaligus, maks 2 MB/foto)</label>
                            <input type="file" name="galleries[]" multiple accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        </div>
                    </div>
                </div>

                <!-- Card 3: Kontak & Alamat -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">3. Kontak & Media Sosial</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin / PIC</label>
                            <input type="text" name="nama_admin" value="{{ old('nama_admin') }}" placeholder="mis. Admin IDTC" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="mis. +62 856-0060-4388" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('alamat') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="info@example.com" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Instagram</label>
                            <input type="text" name="instagram" value="{{ old('instagram') }}" placeholder="mis. @idtc.drone" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Website Resmi</label>
                            <input type="url" name="website" value="{{ old('website') }}" placeholder="https://..." class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tautan Google Maps</label>
                            <input type="text" name="link_maps" value="{{ old('link_maps') }}" placeholder="https://www.google.com/maps/..." class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>
                    </div>
                </div>

                <!-- Card 4: Layanan & Mitra -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">4. Layanan & Mitra</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Daftar Layanan (Satu baris untuk setiap layanan)</label>
                            <textarea name="layanan" rows="4" placeholder="Pelatihan drone dasar&#10;Pemetaan dan fotogrametri&#10;Pertanian" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('layanan') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Daftar Mitra (Pisahkan dengan koma atau baris baru)</label>
                            <textarea name="mitra" rows="3" placeholder="UGM, AMIKOM, Pemkab Sleman, BPBD Bantul" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('mitra') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.lpks.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow transition">
                        Simpan LPK
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

