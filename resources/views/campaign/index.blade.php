@extends('layouts.app')

@section('title', 'Daftar Campaign')

@section('content')

<div class="w-full">

    {{-- Hero --}}
    <div class="bg-green-500 text-white py-10 text-center">
        <h1 class="text-3xl font-extrabold">Daftar Campaign</h1>
        <p class="text-green-100 mt-1 text-sm">Kelola campaign donasi kamu</p>
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
            <h2 class="text-xl font-bold text-gray-800">Semua Campaign</h2>
            <a href="{{ route('campaign.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow transition">
                + Tambah Campaign
            </a>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-green-50 text-gray-700 font-semibold border-b border-green-200">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Target</th>
                        <th class="px-4 py-3">Terkumpul</th>
                        <th class="px-4 py-3">Deadline</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($campaigns as $index => $campaign)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $campaign->title }}</td>
                            <td class="px-4 py-3">
                                {{-- Tampilkan badge setiap kategori (Many to Many) --}}
                                @forelse($campaign->categories as $cat)
                                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full mr-1">
                                        {{ $cat->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 text-xs">—</span>
                                @endforelse
                            </td>
                            <td class="px-4 py-3 text-gray-600">Rp {{ number_format($campaign->target_donation, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-gray-600">Rp {{ number_format($campaign->collected_donation, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($campaign->deadline)->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-1 flex-wrap">
                                    <a href="{{ route('campaign.show', $campaign->id) }}"
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1.5 rounded-lg text-xs font-semibold transition">
                                        👁️ Detail
                                    </a>
                                    <a href="{{ route('donation.create', ['campaign_id' => $campaign->id]) }}"
                                       class="bg-green-400 hover:bg-green-500 text-white px-2 py-1.5 rounded-lg text-xs font-semibold transition">
                                        💚 Donasi
                                    </a>
                                    <a href="{{ route('campaign.edit', $campaign->id) }}"
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1.5 rounded-lg text-xs font-semibold transition">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('campaign.destroy', $campaign->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus campaign ini?')">
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
                                Belum ada campaign.
                                <a href="{{ route('campaign.create') }}" class="text-green-500 hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
