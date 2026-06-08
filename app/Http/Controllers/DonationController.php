<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Campaign;

class DonationController extends Controller
{
    /**
     * Tampilkan semua donasi (dengan relasi campaign).
     */
    public function index()
    {
        $donations = Donation::with('campaign')
                             ->orderBy('id', 'desc')
                             ->get();

        return view('donation.index', compact('donations'));
    }

    /**
     * Tampilkan form tambah donasi untuk campaign tertentu.
     */
    public function create(Request $request)
    {
        // Ambil campaign_id dari query string (?campaign_id=1)
        $campaign = null;
        if ($request->has('campaign_id')) {
            $campaign = Campaign::findOrFail($request->campaign_id);
        }

        $campaigns = Campaign::orderBy('title')->get();

        return view('donation.create', compact('campaigns', 'campaign'));
    }

    /**
     * Simpan donasi baru ke database menggunakan Eloquent.
     */
    public function store(Request $request)
    {
        $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'donor_name'  => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'amount'      => 'required|numeric|min:1000',
            'message'     => 'nullable|string|max:500',
        ]);

        // Eloquent CREATE
        $donation = Donation::create([
            'campaign_id' => $request->campaign_id,
            'donor_name'  => $request->donor_name,
            'donor_email' => $request->donor_email,
            'amount'      => $request->amount,
            'message'     => $request->message,
        ]);

        // Update total collected_donation pada campaign
        $campaign = Campaign::findOrFail($request->campaign_id);
        $campaign->collected_donation += $request->amount;
        $campaign->save();

        return redirect()->route('donation.index')
                         ->with('success', 'Terima kasih, ' . $donation->donor_name . '! Donasi sebesar Rp ' . number_format($donation->amount, 0, ',', '.') . ' berhasil dicatat.');
    }

    /**
     * Tampilkan detail donasi.
     */
    public function show(string $id)
    {
        $donation = Donation::with('campaign')->findOrFail($id);

        return view('donation.show', compact('donation'));
    }

    /**
     * Hapus donasi.
     */
    public function destroy(string $id)
    {
        $donation = Donation::findOrFail($id);

        // Kurangi collected_donation pada campaign
        $campaign = $donation->campaign;
        if ($campaign) {
            $campaign->collected_donation = max(0, $campaign->collected_donation - $donation->amount);
            $campaign->save();
        }

        $donation->delete();

        return redirect()->route('donation.index')
                         ->with('success', 'Donasi berhasil dihapus.');
    }
}
