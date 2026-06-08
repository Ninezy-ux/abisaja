@extends('layouts.app')

@section('title', 'Tambah Donasi')

@section('content')

<div class="w-full">

    {{-- Hero --}}
    <div class="bg-emerald-600 text-white py-10 text-center">
        <h1 class="text-3xl font-extrabold">💚 Buat Donasi</h1>
        <p class="text-emerald-100 mt-1 text-sm">Bantu campaign pilihan kamu</p>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-xl">

        <nav class="text-sm text-gray-500 flex items-center gap-1 mb-6">
            <a href="{{ route('donation.index') }}" class="hover:text-emerald-600 transition">Donasi</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">Tambah</span>
        </nav>

        {{-- Info Campaign yang dipilih --}}
        @if($campaign)
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-6 flex items-center gap-3">
            <div class="text-2xl">🎯</div>
            <div>
                <p class="text-xs text-gray-500">Berdonasi untuk</p>
                <p class="font-bold text-gray-800">{{ $campaign->title }}</p>
                <p class="text-xs text-emerald-600">
                    Target: Rp {{ number_format($campaign->target_donation, 0, ',', '.') }}
                    &nbsp;|&nbsp; Terkumpul: Rp {{ number_format($campaign->collected_donation, 0, ',', '.') }}
                </p>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">

            <div class="bg-emerald-50 border-b border-emerald-200 px-6 py-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white text-lg">💚</div>
                <h2 class="text-lg font-bold text-gray-800">Form Donasi</h2>
            </div>

            <form action="{{ route('donation.store') }}" method="POST" class="px-6 py-6 space-y-5">
                @csrf

                {{-- Pilih Campaign (relasi One to Many) --}}
                <div>
                    <label for="campaign_id" class="block text-sm font-semibold text-gray-700 mb-1">
                        Campaign <span class="text-red-500">*</span>
                    </label>
                    <select id="campaign_id" name="campaign_id"
                            class="w-full border rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition
                                   {{ $errors->has('campaign_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        <option value="">-- Pilih Campaign --</option>
                        @foreach($campaigns as $c)
                            <option value="{{ $c->id }}"
                                {{ old('campaign_id', $campaign?->id) == $c->id ? 'selected' : '' }}>
                                {{ $c->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('campaign_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Donatur --}}
                <div>
                    <label for="donor_name" class="block text-sm font-semibold text-gray-700 mb-1">
                        Nama Donatur <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="donor_name" name="donor_name"
                        value="{{ old('donor_name') }}"
                        placeholder="Nama lengkap kamu"
                        class="w-full border rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition
                               {{ $errors->has('donor_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" />
                    @error('donor_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Donatur --}}
                <div>
                    <label for="donor_email" class="block text-sm font-semibold text-gray-700 mb-1">
                        Email <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="email" id="donor_email" name="donor_email"
                        value="{{ old('donor_email') }}"
                        placeholder="email@contoh.com"
                        class="w-full border rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition
                               {{ $errors->has('donor_email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" />
                    @error('donor_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah Donasi --}}
                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-1">
                        Jumlah Donasi (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Rp</span>
                        <input type="number" id="amount" name="amount"
                            value="{{ old('amount') }}"
                            placeholder="50000" min="1000"
                            class="w-full border rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition
                                   {{ $errors->has('amount') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" />
                    </div>
                    <p class="text-gray-400 text-xs mt-1">Minimum donasi Rp 1.000</p>
                    @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Shortcut Nominal --}}
                    <div class="flex gap-2 mt-2">
                        @foreach([10000, 25000, 50000, 100000] as $nominal)
                            <button type="button"
                                    onclick="document.getElementById('amount').value = {{ $nominal }}"
                                    class="flex-1 bg-gray-100 hover:bg-emerald-100 text-gray-600 hover:text-emerald-700 text-xs py-1.5 rounded-lg font-medium transition">
                                {{ number_format($nominal/1000, 0) }}rb
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Pesan --}}
                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-1">
                        Pesan <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea id="message" name="message" rows="3"
                        placeholder="Tuliskan semangat atau doa kamu..."
                        class="w-full border rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition resize-none
                               {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-gray-100" />

                <div class="flex items-center gap-3 pt-1">
                    <a href="{{ route('donation.index') }}"
                       class="flex-1 text-center border border-gray-300 text-gray-600 rounded-lg py-2.5 text-sm font-semibold hover:bg-gray-50 transition">
                        ← Batal
                    </a>
                    <button type="submit"
                            class="flex-1 bg-emerald-600 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-emerald-700 active:scale-95 transition">
                        💚 Kirim Donasi
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
