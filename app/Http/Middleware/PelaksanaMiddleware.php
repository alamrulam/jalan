<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PelaksanaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role == 'pelaksana') {
            return $next($request);
        }
        // Jika bukan pelaksana, redirect atau berikan error
        if (Auth::check() && Auth::user()->role == 'admin') {
            return redirect()->route('admin.projects.index')->with('error', 'Anda adalah Admin, bukan Pelaksana.');
        }
        return redirect('/login')->with('error', 'Anda harus login sebagai Pelaksana.');
    }
}
