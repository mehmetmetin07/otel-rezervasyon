<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  İzin verilen roller (virgülle ayrılmış)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
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

        // Kullanıcının rolü izin verilen roller listesinde var mı?
        if (!in_array($user->role->name, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bu işlemi yapmaya yetkiniz yok. Gerekli yetkiler: ' . implode(', ', $roles)], 403);
            }
            abort(403, 'Bu işlemi yapmaya yetkiniz yok. Gerekli yetkiler: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}
