<?php
namespace App\Features\Infrastructure\Middlewares;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

         // ép kiểu về int để tránh mismatch string/int
        $roles = array_map('intval', $roles);

        if (!in_array($user->role_id, $roles)) {
            return response()->json([
                'message' => 'You do not have permission to access this resource'
            ], 403);
        }
        
        return $next($request);
    }
}
