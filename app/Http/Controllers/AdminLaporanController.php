<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->query('sort', 'newest');
        $sorts = [
            'newest' => ['created_at', 'desc'],
            'oldest' => ['created_at', 'asc'],
            'incident_oldest' => ['tanggal', 'asc'],
            'incident_newest' => ['tanggal', 'desc'],
        ];
        [$sortColumn, $sortDirection] = $sorts[$sort] ?? $sorts['newest'];

        $laporans = Laporan::with('pelapor')
            ->when($request->string('q')->isNotEmpty(), fn ($query) => $query->where(function ($query) use ($request): void {
                $search = '%'.$request->string('q')->toString().'%';
                $query->where('judul', 'like', $search)->orWhereHas('pelapor', fn ($userQuery) => $userQuery->where('name', 'like', $search));
            }))
            ->when(in_array($request->query('status'), Laporan::STATUSES, true), fn ($query) => $query->where('status', $request->query('status')))
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(15)
            ->withQueryString();

        return view('admin.laporans.index', compact('laporans'));
    }

    public function show(Laporan $laporan): View
    {
        return view('admin.laporans.show', compact('laporan'));
    }

    public function updateStatus(Request $request, Laporan $laporan): RedirectResponse
    {
        $this->authorize('updateStatus', Laporan::class);
        $validated = $request->validate(['status' => ['required', 'in:proses,selesai']]);
        $allowedNextStatuses = [
            'pending' => ['proses'],
            'proses' => ['selesai'],
            'selesai' => [],
        ];
        abort_unless(in_array($validated['status'], $allowedNextStatuses[$laporan->status] ?? [], true), 422, 'Perubahan status tidak diizinkan.');
        $updated = Laporan::query()
            ->whereKey($laporan->getKey())
            ->where('status', $laporan->status)
            ->update(['status' => $validated['status'], 'updated_at' => now()]);
        abort_unless($updated === 1, 422, 'Status laporan sudah berubah. Muat ulang sebelum mencoba kembali.');

        return to_route('admin.laporans.show', $laporan)->with('status', 'Status laporan diperbarui.');
    }

    public function dashboard(): View
    {
        $counts = Laporan::query()->selectRaw('status, count(*) as aggregate')->groupBy('status')->pluck('aggregate', 'status');
        $totalUsers = User::query()->where('role', 'warga')->count();
        $recent = Laporan::with('pelapor')->latest()->take(6)->get();

        return view('admin.dashboard', compact('counts', 'totalUsers', 'recent'));
    }
}
