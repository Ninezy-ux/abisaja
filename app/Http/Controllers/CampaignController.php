<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Category;

class CampaignController extends Controller
{
    /**
     * Tampilkan semua campaign.
     * Sebelumnya: DB::table('campaigns')->get()  ← Query Builder
     * Sekarang  : Campaign::all()                ← Eloquent
     */
    public function index()
    {
        // Eloquent: ambil semua campaign, urutkan terbaru,
        // sertakan relasi categories (eager loading)
        $campaigns = Campaign::with('categories')
                             ->orderBy('id', 'desc')
                             ->get();

        return view('campaign.index', compact('campaigns'));
    }

    /**
     * Tampilkan form tambah campaign.
     */
    public function create()
    {
        // Kirim semua kategori ke view agar bisa dipilih
        $categories = Category::orderBy('name')->get();

        return view('campaign.create', compact('categories'));
    }

    /**
     * Simpan campaign baru ke database.
     * Sebelumnya: DB::table('campaigns')->insert([...])  ← Query Builder
     * Sekarang  : Campaign::create([...])                ← Eloquent
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'target_donation' => 'required|numeric|min:1',
            'deadline'        => 'required|date',
            'categories'      => 'nullable|array',
            'categories.*'    => 'exists:categories,id',
        ]);

        // Eloquent create — tidak perlu set created_at/updated_at manual
        $campaign = Campaign::create([
            'title'              => $request->title,
            'description'        => $request->description,
            'target_donation'    => $request->target_donation,
            'collected_donation' => 0,
            'deadline'           => $request->deadline,
        ]);

        // Simpan relasi Many to Many (kategori)
        if ($request->has('categories')) {
            $campaign->categories()->sync($request->categories);
        }

        return redirect()->route('campaign.index')
                         ->with('success', 'Campaign berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail campaign beserta donasi yang masuk.
     */
    public function show(string $id)
    {
        // Eloquent: eager load relasi account, categories, donations
        $campaign = Campaign::with(['account', 'categories', 'donations'])
                            ->findOrFail($id);

        return view('campaign.show', compact('campaign'));
    }

    /**
     * Tampilkan form edit campaign.
     */
    public function edit(string $id)
    {
        // Eloquent: findOrFail otomatis abort 404 jika tidak ketemu
        $campaign   = Campaign::with('categories')->findOrFail($id);
        $categories = Category::orderBy('name')->get();

        // ID kategori yang sudah dipilih (untuk pre-check checkbox)
        $selectedCategories = $campaign->categories->pluck('id')->toArray();

        return view('campaign.edit', compact('campaign', 'categories', 'selectedCategories'));
    }

    /**
     * Perbarui data campaign.
     * Sebelumnya: DB::table('campaigns')->where('id',...)->update([...])
     * Sekarang  : $campaign->update([...])  ← Eloquent
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'target_donation' => 'required|numeric|min:1',
            'deadline'        => 'required|date',
            'categories'      => 'nullable|array',
            'categories.*'    => 'exists:categories,id',
        ]);

        $campaign = Campaign::findOrFail($id);

        // Eloquent update
        $campaign->update([
            'title'           => $request->title,
            'description'     => $request->description,
            'target_donation' => $request->target_donation,
            'deadline'        => $request->deadline,
        ]);

        // Sinkronisasi relasi Many to Many
        $campaign->categories()->sync($request->categories ?? []);

        return redirect()->route('campaign.index')
                         ->with('success', 'Campaign berhasil diperbarui!');
    }

    /**
     * Hapus campaign.
     * Sebelumnya: DB::table('campaigns')->where('id',...)->delete()
     * Sekarang  : $campaign->delete()  ← Eloquent
     */
    public function destroy(string $id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return redirect()->route('campaign.index')
                         ->with('success', 'Campaign berhasil dihapus!');
    }
}
