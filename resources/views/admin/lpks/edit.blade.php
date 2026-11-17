<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Edit LPK: ') }} {{ $lpk->nama }}
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ url('/lpk/' . $lpk->slug) }}" target="_blank" class="text-sm font-semibold text-teal-600 hover:text-teal-800">
                    Lihat Publik ↗
                </a>
                <a href="{{ route('admin.lpks.index') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-teal-50 border-l-4 border-teal-500 text-teal-800 rounded-r-lg shadow-sm">
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            @endif

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

            <form action="{{ route('admin.lpks.update', $lpk) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Card 1: Informasi Pokok -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">1. Informasi Utama</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama LPK *</label>
                            <input type="text" name="nama" value="{{ old('nama', $lpk->nama) }}" required class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Bidang Pelatihan *</label>
                            <input type="text" name="bidang" value="{{ old('bidang', $lpk->bidang) }}" required class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Slug URL *</label>
                            <input type="text" name="slug" value="{{ old('slug', $lpk->slug) }}" required class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tagline / Motto</label>
                            <input type="text" name="tagline" value="{{ old('tagline', $lpk->tagline) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tentang Lembaga</label>
                            <textarea name="tentang" rows="3" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('tentang', $lpk->tentang) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ikon / Emoji</label>
                            <input type="text" name="ikon" value="{{ old('ikon', $lpk->ikon) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Warna Aksen Hex</label>
                            <input type="text" name="warna" value="{{ old('warna', $lpk->warna) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Urutan Tampil</label>
                            <input type="number" name="urutan" value="{{ old('urutan', $lpk->urutan) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="flex items-center pt-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="aktif" value="1" {{ old('aktif', $lpk->aktif) ? 'checked' : '' }} class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500">
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
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ganti Logo LPK</label>
                            @if($lpk->logo_url)
                                <div class="mb-2 p-2 bg-gray-50 rounded-lg inline-block">
                                    <img src="{{ $lpk->logo_url }}" alt="Logo Saat Ini" class="h-12 object-contain">
                                </div>
                            @endif
                            <input type="file" name="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Ganti Foto Cover Header</label>
                            @if($lpk->cover_url)
                                <div class="mb-2 p-2 bg-gray-50 rounded-lg inline-block">
                                    <img src="{{ $lpk->cover_url }}" alt="Cover Saat Ini" class="h-12 w-24 object-cover rounded">
                                </div>
                            @endif
                            <input type="file" name="cover" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        </div>

                        <div class="md:col-span-2 pt-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tambah Foto ke Galeri Kegiatan (Maks 2 MB/foto)</label>
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
                            <input type="text" name="nama_admin" value="{{ old('nama_admin', $lpk->nama_admin) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $lpk->whatsapp) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('alamat', $lpk->alamat) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $lpk->email) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Instagram</label>
                            <input type="text" name="instagram" value="{{ old('instagram', $lpk->instagram) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Website Resmi</label>
                            <input type="url" name="website" value="{{ old('website', $lpk->website) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tautan Google Maps</label>
                            <input type="text" name="link_maps" value="{{ old('link_maps', $lpk->link_maps) }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>
                    </div>
                </div>

                <!-- Card 4: Layanan & Mitra -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">4. Layanan & Mitra</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Daftar Layanan (Satu baris untuk setiap layanan)</label>
                            <textarea name="layanan" rows="5" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('layanan', $lpk->services->pluck('nama_layanan')->implode("\n")) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Daftar Mitra (Pisahkan dengan koma atau baris baru)</label>
                            <textarea name="mitra" rows="3" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('mitra', $lpk->partners->pluck('nama_mitra')->implode(', ')) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.lpks.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <!-- Card 5: Kelola Foto Galeri Saat Ini -->
            @if($lpk->galleries->count() > 0)
                <div class="mt-8 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">
                        Foto Galeri Saat Ini ({{ $lpk->galleries->count() }} Foto)
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-3">
                        @foreach($lpk->galleries as $gallery)
                            <div class="relative group rounded-lg overflow-hidden border aspect-video bg-gray-100">
                                <img src="{{ $gallery->foto_url }}" alt="Foto" class="w-full h-full object-cover">
                                <form action="{{ route('admin.lpks.gallery.destroy', [$lpk, $gallery]) }}" method="POST" onsubmit="return confirm('Hapus foto ini?');" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-6 h-6 rounded-full bg-red-600 text-white font-bold flex items-center justify-center text-xs hover:bg-red-700 shadow" title="Hapus foto">
                                        &times;
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

