<?php

namespace App\Features\SystemManagements\Checks;

use App\Traits\ApiResponses;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    use ApiResponses;

    /**
     * Thi alias to register by it
     *
     * @var string
     * @static
     */
    public static $alias = 'role';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type, string ...$types): Response
    {
        $user = Auth::user();

        foreach ([$type, ...$types] as $value) {


            if ($user->isRole($value)) return $next($request);
        }

        $available_roles = implode('|', [$type, ...$types]);

        return $this->unauthorizedResponse([], "Plese login by $available_roles role to access this resource");
    }

}
