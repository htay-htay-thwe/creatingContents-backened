
namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginViewResponse as LoginViewResponseContract;
use Illuminate\Http\Request;

class LoginViewResponse implements LoginViewResponseContract
{
    public function toResponse($request)
    {
        // Redirect to dashboard after successful login
        return redirect('/dashboard');
    }
}
