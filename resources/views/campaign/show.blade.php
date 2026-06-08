@extends('layouts.app')

@section('title', 'Detail Campaign')

@section('content')

<div class="w-full">

    <div class="bg-green-500 text-white py-10 text-center">
        <h1 class="text-3xl font-extrabold">Detail Campaign</h1>
        <p class="text-green-100 mt-1 text-sm">{{ $campaign->title }}</p>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-3xl">

        <nav class="text-sm text-gray-500 flex items-center gap-1 mb-6">
            <a href="{{ route('campaign.index') }}" class="hover:text-green-600 transition">Campaign</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">Detail</span>
        </nav>

        {{-- Info Campaign --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">{{ $campaign->title }}</h2>
                <div class="flex gap-2">
                    @foreach($campaign->categories as $cat)
                        <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">{{ $cat->name }}</span>
                    @endforeach
                </div>
            </div>

            <p class="text-gray-600 text-sm mb-4">{{ $campaign->description }}</p>

            {{-- Progress Bar --}}
            @php
                $persen = $campaign->target_donation > 0
                    ? min(100, ($campaign->collected_donation / $campaign->target_donation) * 100)
                    : 0;
            @endphp
            <div class="mb-4">
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>Terkumpul: <strong class="text-green-600">Rp {{ number_format($campaign->collected_donation, 0, ',', '.') }}</strong></span>
                    <span>Target: <strong>Rp {{ number_format($campaign->target_donation, 0, ',', '.') }}</strong></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-green-500 h-3 rounded-full transition-all"
                         style="width: {{ $persen }}%"></div>
                </div>
                <p class="text-right text-xs text-gray-400 mt-1">{{ number_format($persen, 1) }}%</p>
            </div>

            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>🗓️ Deadline: <strong>{{ \Carbon\Carbon::parse($campaign->deadline)->format('d M Y') }}</strong></span>
                <span>💰 Total donasi: <strong>{{ $campaign->donations->count() }}</strong> orang</span>
            </div>
        </div>

        {{-- Rekening (One to One) --}}
        @if($campaign->account)
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <h3 class="text-base font-bold text-gray-800 mb-3">🏦 Rekening Penerima Donasi</h3>
            <div class="grid grid-cols-3 gap-3 text-sm">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-500 text-xs">Bank</p>
                    <p class="font-semibold text-gray-800">{{ $campaign->account->bank_name }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-500 text-xs">No. Rekening</p>
                    <p class="font-semibold text-gray-800">{{ $campaign->account->account_number }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-gray-500 text-xs">Atas Nama</p>
                    <p class="font-semibold text-gray-800">{{ $campaign->account->account_holder }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Daftar Donasi (One to Many) --}}
        <div class="bg-white rounded-2xl shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-gray-800">💚 Donasi Masuk</h3>
                <a href="{{ route('donation.create', ['campaign_id' => $campaign->id]) }}"
                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                    + Tambah Donasi
                </a>
            </div>

            @forelse($campaign->donations as $donation)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">{{ $donation->donor_name }}</p>
                        @if($donation->message)
                            <p class="text-gray-500 text-xs italic mt-0.5">"{{ $donation->message }}"</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-green-600 font-bold text-sm">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                        <p class="text-gray-400 text-xs">{{ $donation->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-sm text-center py-4">Belum ada donasi untuk campaign ini.</p>
            @endforelse
        </div>

        <a href="{{ route('campaign.index') }}"
           class="inline-block text-sm text-gray-600 hover:text-green-600 transition">
            ← Kembali ke Daftar Campaign
        </a>
    </div>
</div>

@endsection
