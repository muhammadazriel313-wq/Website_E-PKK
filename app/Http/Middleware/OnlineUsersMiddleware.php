

use Closure;
use Illuminate\Support\Facades\Cache;

class OnlineUsersMiddleware
{
    public function handle($request, Closure $next)
    {
        Cache::put('user-is-online-' . auth()->user()->id, true, now()->addMinutes(5));

        return $next($request);
    }
}