<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Gerekli rol adı
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Kullanıcı giriş yapmamışsa
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Giriş yapmanız gerekiyor'], 401);
            }
            return redirect('/login');
        }

        $user = Auth::user();

        // Kullanıcının rolü yoksa
        if (!$user->role) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bu işlemi yapmaya yetkiniz yok'], 403);
            }
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }

        // Gerekli role sahip değilse
        if ($user->role->name !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bu işlemi yapmaya yetkiniz yok. Gerekli yetki: ' . $role], 403);
            }
            abort(403, 'Bu işlemi yapmaya yetkiniz yok. Gerekli yetki: ' . $role);
        }

        return $next($request);
    }
}
