<?php
namespace App\Features\Infrastructure\Middlewares;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, int $roleId): Response
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        if ($user->role_id !== $roleId) {
            return response()->json([
                'message' => 'You do not have permission to access this resource'
            ], 403);
        }

        return $next($request);
    }
}
