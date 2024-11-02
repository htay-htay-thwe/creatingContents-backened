namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GuestRedirect
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
