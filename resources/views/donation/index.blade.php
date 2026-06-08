@extends('layouts.app')

@section('title', 'Daftar Donasi')

@section('content')

<div class="w-full">

    {{-- Hero --}}
    <div class="bg-emerald-600 text-white py-10 text-center">
        <h1 class="text-3xl font-extrabold">💚 Daftar Donasi</h1>
        <p class="text-emerald-100 mt-1 text-sm">Semua donasi yang telah masuk</p>
    </div>

    <div class="container mx-auto px-4 py-8">

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-lg px-4 py-3 text-sm mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Header + Tombol --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Riwayat Donasi</h2>
                <p class="text-sm text-gray-500 mt-0.5">Total: <strong>{{ $donations->count() }}</strong> donasi</p>
            </div>
            <a href="{{ route('donation.create') }}"
               class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition">
                + Tambah Donasi
            </a>
        </div>

        {{-- Tabel Donasi --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-emerald-50 text-gray-700 font-semibold border-b border-emerald-200">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Donatur</th>
                        <th class="px-4 py-3">Campaign</th>
                        <th class="px-4 py-3">Jumlah</th>
                        <th class="px-4 py-3">Pesan</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($donations as $index => $donation)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">
                                <p class="font-medium text-gray-800">{{ $donation->donor_name }}</p>
                                @if($donation->donor_email)
                                    <p class="text-gray-400 text-xs">{{ $donation->donor_email }}</p>
                                @endif
                            </td>
                            {{-- Relasi One to Many (inverse): donation->campaign --}}
                            <td class="px-4 py-3">
                                @if($donation->campaign)
                                    <a href="{{ route('campaign.show', $donation->campaign->id) }}"
                                       class="text-emerald-600 hover:underline font-medium">
                                        {{ $donation->campaign->title }}
                                    </a>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-bold text-emerald-600">
                                Rp {{ number_format($donation->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-gray-500 italic text-xs max-w-xs truncate">
                                {{ $donation->message ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-gray-500 text-xs">
                                {{ $donation->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('donation.show', $donation->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1.5 rounded-lg text-xs font-semibold transition">
                                        👁️ Detail
                                    </a>
                                    <form action="{{ route('donation.destroy', $donation->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus donasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-2 py-1.5 rounded-lg text-xs font-semibold transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                                Belum ada donasi.
                                <a href="{{ route('donation.create') }}" class="text-emerald-600 hover:underline">Tambah donasi pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
