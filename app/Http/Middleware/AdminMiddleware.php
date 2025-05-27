<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Symfony\Component\HttpFoundation\Response;

    class AdminMiddleware
    {
        public function handle(Request $request, Closure $next): Response
        {
            if (Auth::check() && Auth::user()->role == 'admin') {
                return $next($request);
            }
            // Jika bukan admin, redirect atau berikan error
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses Admin.');
        }
    }