<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Pengaturan Beranda & Kontak DPC HILLSI Sleman') }}
        </h2>
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

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Card 1: Teks Hero Beranda -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">1. Teks Hero Beranda</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tagline Atas</label>
                            <input type="text" name="hero_tagline" value="{{ old('hero_tagline', $settings['hero_tagline'] ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Utama Hero (H1)</label>
                            <input type="text" name="hero_judul" value="{{ old('hero_judul', $settings['hero_judul'] ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat Hero</label>
                            <textarea name="hero_deskripsi" rows="3" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('hero_deskripsi', $settings['hero_deskripsi'] ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Berdiri HILLSI (Statistik)</label>
                            <input type="text" name="tahun_berdiri" value="{{ old('tahun_berdiri', $settings['tahun_berdiri'] ?? '1982') }}" class="w-full max-w-xs rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>
                    </div>
                </div>

                <!-- Card 2: Kontak Sekretariat DPC -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">2. Kontak Sekretariat DPC HILLSI Sleman</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Sekretariat</label>
                            <textarea name="alamat" rows="2" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">{{ old('alamat', $settings['alamat'] ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon', $settings['telepon'] ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Resmi</label>
                            <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Link Instagram Resmi DPC</label>
                            <input type="text" name="instagram" value="{{ old('instagram', $settings['instagram'] ?? '') }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow transition">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

