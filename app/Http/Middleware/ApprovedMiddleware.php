<?php

namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
 
class ApprovedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
 
        if ($user && $user->status !== 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
 
            return redirect()->route('login')
                ->with('error', 'Your account is pending approval. We will notify you by email once approved.');
        }
 
        return $next($request);
    }
}