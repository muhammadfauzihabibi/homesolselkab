<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Visitor;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class TrackVisitor
{
    public function handle($request, Closure $next)
    {
        // 1. Ambil atau Buat Unique Token Pengunjung (Cookie 1 Tahun + Session)
        $vToken = $request->cookie('v_token') ?? $request->session()->get('v_token');
        if (!$vToken) {
            $vToken = 'vt_' . Str::random(32);
            $request->session()->put('v_token', $vToken);
            Cookie::queue('v_token', $vToken, 525600); // Cookie bertahan 1 tahun
        }

        $agent = new Agent();

        // 2. Deteksi IP Asli Pengunjung (Reverse Proxy / Ngrok Compatible)
        $ip = $request->header('x-forwarded-for')
            ? trim(explode(',', $request->header('x-forwarded-for'))[0])
            : $request->ip();

        // 3. Deteksi Browser & Platform dengan Fallback Bersih (Bila User-Agent kosong/'0')
        $browser = $agent->browser();
        if (!$browser || $browser === '0') {
            $browser = 'Chrome';
        }

        $platform = $agent->platform();
        if (!$platform || $platform === '0') {
            $platform = $agent->isMobile() ? 'AndroidOS' : 'Linux';
        }

        $deviceType = $agent->isMobile()
            ? 'mobile'
            : ($agent->isTablet() ? 'tablet' : 'desktop');

        // 4. Cek apakah Perangkat Spesifik Ini Sudah Tercatat Hari Ini
        // Menggunakan pencocokan Token Cookie ATAU Kombinasi (Jenis Perangkat + Platform + Browser)
        $existingRecord = Visitor::whereDate('visited_at', today())
            ->where(function ($query) use ($vToken, $deviceType, $platform, $browser) {
                $query->where('session_id', $vToken)
                      ->orWhere(function ($q) use ($deviceType, $platform, $browser) {
                          $q->where('device_type', $deviceType)
                            ->where('platform', $platform)
                            ->where('browser', $browser);
                      });
            })
            ->first();

        if ($existingRecord) {
            // Jika SUDAH ADA hari ini, perbarui waktu kunjungan (agar status online tetap aktif) & IP terbaru
            // tanpa menambah baris baru di database
            $existingRecord->update([
                'session_id' => $vToken,
                'ip_address' => $ip,
                'browser'    => $browser,
                'platform'   => $platform,
                'visited_at' => now(),
                'url'        => $request->path(),
            ]);
        } else {
            // Jika BELUM ADA hari ini, buat TEPAT SATU data pengunjung baru
            Visitor::create([
                'session_id'  => $vToken,
                'ip_address'  => $ip,
                'browser'     => $browser,
                'platform'    => $platform,
                'device_type' => $deviceType,
                'url'         => $request->path(),
                'visited_at'  => now(),
            ]);
        }

        $response = $next($request);

        if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
            $response->headers->setCookie(cookie('v_token', $vToken, 525600));
        }

        return $response;
    }
}