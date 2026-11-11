<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Laporan::class);

        $laporans = $request->user()->laporans()
            ->when($request->string('q')->isNotEmpty(), fn ($query) => $query->where('judul', 'like', '%'.$request->string('q')->toString().'%'))
            ->when(in_array($request->query('status'), Laporan::STATUSES, true), fn ($query) => $query->where('status', $request->query('status')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('laporans.index', compact('laporans'));
    }

    public function create(): View
    {
        $this->authorize('create', Laporan::class);

        return view('laporans.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Laporan::class);
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'detail' => ['required', 'string', 'max:10000'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        $validated['foto'] = $request->file('foto')?->store('laporans', 'local');
        $request->user()->laporans()->create($validated);

        return to_route('laporans.index')->with('status', 'Laporan berhasil dikirim.');
    }

    public function show(Laporan $laporan): View
    {
        $this->authorize('view', $laporan);

        return view('laporans.show', compact('laporan'));
    }

    public function photo(Laporan $laporan): StreamedResponse
    {
        $this->authorize('view', $laporan);
        abort_unless($laporan->foto && Storage::disk('local')->exists($laporan->foto), 404);

        return Storage::disk('local')->response($laporan->foto);
    }

    public function edit(Laporan $laporan): View
    {
        $this->authorize('update', $laporan);

        return view('laporans.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan): RedirectResponse
    {
        $this->authorize('update', $laporan);
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'detail' => ['required', 'string', 'max:10000'],
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
        if ($request->hasFile('foto')) {
            if ($laporan->foto) {
                Storage::disk('local')->delete($laporan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('laporans', 'local');
        }
        $laporan->update($validated);

        return to_route('laporans.show', $laporan)->with('status', 'Perubahan laporan disimpan.');
    }

    public function destroy(Laporan $laporan): RedirectResponse
    {
        $this->authorize('delete', $laporan);
        if ($laporan->foto) {
            Storage::disk('local')->delete($laporan->foto);
        }
        $laporan->delete();

        return to_route('laporans.index')->with('status', 'Laporan dihapus.');
    }
}
