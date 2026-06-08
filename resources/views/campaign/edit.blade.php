@extends('layouts.app')

@section('title', 'Edit Campaign')

@section('content')

<div class="w-full">

    <div class="bg-green-500 text-white py-10 text-center">
        <h1 class="text-3xl font-extrabold">Edit Campaign</h1>
        <p class="text-green-100 mt-1 text-sm">Perbarui informasi campaign donasi kamu</p>
    </div>

    <div class="container mx-auto px-4 py-8 max-w-2xl">

        <nav class="text-sm text-gray-500 flex items-center gap-1 mb-6">
            <a href="{{ route('campaign.index') }}" class="hover:text-green-600 transition">Campaign</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">Edit</span>
        </nav>

        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 rounded-lg px-4 py-3 text-sm mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">

            <div class="bg-green-50 border-b border-green-200 px-6 py-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white text-lg">✏️</div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Edit Campaign</h2>
                    <p class="text-xs text-gray-500">ID: {{ $campaign->id }}</p>
                </div>
            </div>

            <form action="{{ route('campaign.update', $campaign->id) }}" method="POST" class="px-6 py-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">
                        Judul Campaign <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', $campaign->title) }}"
                        class="w-full border rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition
                               {{ $errors->has('title') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" />
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full border rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition resize-none
                               {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    >{{ old('description', $campaign->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori (Many to Many) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    @if($categories->count())
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($categories as $category)
                                <label class="flex items-center gap-2 cursor-pointer bg-gray-50 hover:bg-green-50 border border-gray-200 hover:border-green-300 rounded-lg px-3 py-2 transition">
                                    <input type="checkbox"
                                           name="categories[]"
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}
                                           class="accent-green-500">
                                    <span class="text-sm text-gray-700">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm">Belum ada kategori tersedia.</p>
                    @endif
                </div>

                {{-- Target Donasi --}}
                <div>
                    <label for="target_donation" class="block text-sm font-semibold text-gray-700 mb-1">
                        Target Donasi (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Rp</span>
                        <input type="number" id="target_donation" name="target_donation"
                            value="{{ old('target_donation', $campaign->target_donation) }}"
                            min="1"
                            class="w-full border rounded-lg pl-10 pr-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition
                                   {{ $errors->has('target_donation') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" />
                    </div>
                    @error('target_donation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deadline --}}
                <div>
                    <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-1">
                        Deadline <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="deadline" name="deadline"
                        value="{{ old('deadline', \Carbon\Carbon::parse($campaign->deadline)->format('Y-m-d')) }}"
                        class="w-full border rounded-lg px-4 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition
                               {{ $errors->has('deadline') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}" />
                    @error('deadline')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-gray-100" />

                <div class="flex items-center gap-3 pt-1">
                    <a href="{{ route('campaign.index') }}"
                       class="flex-1 text-center border border-gray-300 text-gray-600 rounded-lg py-2.5 text-sm font-semibold hover:bg-gray-50 transition">
                        ← Batal
                    </a>
                    <button type="submit"
                            class="flex-1 bg-green-500 text-white rounded-lg py-2.5 text-sm font-bold hover:bg-green-600 active:scale-95 transition">
                        💾 Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
