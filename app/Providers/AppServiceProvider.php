<?php

namespace App\Providers;

use App\Models\KoreksiAbsensi;
use App\Models\IzinAbsensi;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
   View::composer('*', function ($view) {

        $pendingIzin = 0;
        $pendingKoreksi = 0;

        if (auth()->check() && auth()->user()->role === 'guru') {

            $guruId = auth()->user()->guru->id ?? null;

            if ($guruId) {

                // ✅ IZIN (LEWAT SISWA)
                $pendingIzin = IzinAbsensi::where('status', 'pending')
                    ->whereHas('siswa', function ($q) use ($guruId) {
                        $q->where('guru_id', $guruId);
                    })
                    ->count();

                // ✅ KOREKSI
                $pendingKoreksi = KoreksiAbsensi::where('status', 'pending')
                    ->whereHas('siswa', function ($q) use ($guruId) {
                        $q->where('guru_id', $guruId);
                    })
                    ->count();
            }
        }

        $view->with([
            'pendingIzin' => $pendingIzin,
            'pendingKoreksi' => $pendingKoreksi,
        ]);
    });
}
}    