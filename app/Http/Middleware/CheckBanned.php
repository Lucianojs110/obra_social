<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class CheckBanned 
{
public function handle($request, Closure $next)
{ $user = Auth::user();
if(is_object($user)){
	 if(auth()->user()->banned_until!=null){
	 	auth()->logout();
 		$message = 'Su cuenta ha sido suspendida. Contacte con el administrador';
	 	 return redirect()->route('login')->withMessage($message);

	}
	//return redirect()->route('login')->withMessage($message);
}
      /*  if (auth()->check() && auth()->user()->banned_until && now()->lessThan(auth()->user()->banned_until)) {
            $banned_days = now()->diffInDays(auth()->user()->banned_until);
            auth()->logout();

            if ($banned_days > 14) {
                $message = 'Your account has been suspended. Please contact administrator.';
            } else {
                $message = 'Your account has been suspended for '.$banned_days.' '.str_plural('day', $banned_days).'. Please contact administrator.';
            }

           
        }*/

        return $next($request);
    }
}