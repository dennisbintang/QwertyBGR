<?php
namespace App\Http\Middleware; 

use Closure;
use Illuminate\Support\Facades\Hash;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $apiSecret = $request->header('X-Api-Key');

        $validSecret = Hash::check($apiSecret, config('app.secret'));

        if (!$validSecret) {
            return response()->json(['status' => 'Invalid API Key'], 401);
        } 

        return $next($request);
    }
}