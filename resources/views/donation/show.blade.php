@extends('layouts.app')

@section('title', 'Detail Donasi')

@section('content')

<div class="w-full">

    <div class="bg-emerald-600 text-white py-10 text-center">
        <h1 class="text-3xl font-extrabold">💚 Detail Donasi</h1>
        <p class="text-emerald-100 mt-1 text-sm">Bukti donasi #{{ $donation->id }}</p>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-lg">

        <nav class="text-sm text-gray-500 flex items-center gap-1 mb-6">
            <a href="{{ route('donation.index') }}" class="hover:text-emerald-600 transition">Donasi</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">Detail</span>
        </nav>

        {{-- Card Detail --}}
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">

            {{-- Header --}}
            <div class="bg-emerald-600 text-white text-center py-8 px-6">
                <div class="text-5xl mb-3">💚</div>
                <p class="text-3xl font-extrabold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                <p class="text-emerald-100 text-sm mt-1">Donasi berhasil dicatat</p>
            </div>

            {{-- Info Donatur --}}
            <div class="px-6 py-5 space-y-4">

                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Donatur</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $donation->donor_name }}</span>
                </div>

                @if($donation->donor_email)
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Email</span>
                    <span class="text-sm text-gray-600">{{ $donation->donor_email }}</span>
                </div>
                @endif

                {{-- Relasi One to Many (inverse) --}}
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-500">Campaign</span>
                    <div class="text-right">
                        @if($donation->campaign)
                            <a href="{{ route('campaign.show', $donation->campaign->id) }}"
                               class="text-sm font-semibold text-emerald-600 hover:underline">
                                {{ $donation->campaign->title }}
                            </a>
                        @else
                            <span class="text-sm text-gray-400">—</span>
                        @endif
                    </div>
                </div>

                @if($donation->message)
                <div class="py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-500 block mb-1">Pesan</span>
                    <p class="text-sm text-gray-700 italic bg-gray-50 rounded-lg px-3 py-2">
                        "{{ $donation->message }}"
                    </p>
                </div>
                @endif

                <div class="flex justify-between items-center py-3">
                    <span class="text-sm text-gray-500">Tanggal</span>
                    <span class="text-sm text-gray-600">{{ $donation->created_at->format('d M Y, H:i') }}</span>
                </div>

            </div>

            {{-- Footer Aksi --}}
            <div class="px-6 pb-6 flex gap-3">
                <a href="{{ route('donation.index') }}"
                   class="flex-1 text-center border border-gray-300 text-gray-600 rounded-lg py-2.5 text-sm font-semibold hover:bg-gray-50 transition">
                    ← Kembali
                </a>
                <a href="{{ route('donation.create', ['campaign_id' => $donation->campaign_id]) }}"
                   class="flex-1 text-center bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg py-2.5 text-sm font-bold transition">
                    + Donasi Lagi
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
