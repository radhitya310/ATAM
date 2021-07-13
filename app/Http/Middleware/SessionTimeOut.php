<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;

class SessionTimeOut
{
    // /**
    //  * Instance of Session Store
    // * @var session
    // */
    // protected $session;
    // /**
    //  * Time for user to remain active, set to 300 secs( 5 minutes )
    //  * @var timeout
    //  */
    // protected $timeout = 60;  // satuan detik
    // public function __construct(Store $session){
    //     $this->session        = $session;
    //     $this->redirectUrl    = 'auth/login';
    //     $this->sessionLabel   = 'warning';
    // }

    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \Closure  $next
    //  * @return mixed
    //  */
    // public function handle($request, Closure $next)
    // {
    //     if(! $this->session->has('lastActivityTime'))
    //     {
    //         $this->session->put('lastActivityTime', time());
    //     }
    //     else if( time() - $this->session->get('lastActivityTime') > $this->getTimeOut())
    //     {
    //         $this->session->forget('lastActivityTime');
    //         Auth::logout();
    //         return redirect($this->getRedirectUrl())->with([ $this->getSessionLabel() => 'You have been inactive for '. $this->timeout .' minutes ago.']);
    //     }
    //     $this->session->put('lastActivityTime',time());
    //     return $next($request);
    // }

    // /**
    //  * Get timeout from laravel default's session lifetime, if it's not set/empty, set timeout to 15 minutes
    //  * @return int
    //  */
    // private function getTimeOut()
    // {
    //     return ($this->lifetime) ?: $this->timeout;
    // }

    // /**
    //  * Get redirect url from env file
    //  * @return string
    //  */
    // private function getRedirectUrl()
    // {
    //     return (env('SESSION_TIMEOUT_REDIRECTURL')) ?: $this->redirectUrl;
    // }

    // /**
    //  * Get Session label from env file
    //  * @return string
    //  */
    // private function getSessionLabel()
    // {
    //     return  (env('SESSION_LABEL')) ?: $this->sessionLabel;
    // }


    // protected $session;
    // protected $timeout = 3600; // 3600 detik = 60 menit = 1 jam

    // public function __construct(Store $session){
    //     $this->session = $session;
    //     $this->redirectUrl = '/login';
    // }

    // public function handle(Request $request, Closure $next){
    //     // jika bukan guest
    //     if (!Auth::guest()) {
    //         $isLoggedIn = $request->path();
    //         if(!session('lastActivityTime')){
    //             $this->session->put('lastActivityTime', time());
    //         }
    //         elseif(time() - $this->session->get('lastActivityTime') > $this->timeout){
    //             $this->session->forget('lastActivityTime');
    //             Auth::logout();
    //             $minutes = $this->timeout/60;
    //             return redirect($this->redirectUrl)->with('message', 'You have been inactive for '.$minutes.' minutes ago');
    //         }

    //         $isLoggedIn ? $this->session->put('lastActivityTime', time()) : $this->session->forget('lastActivityTime');
    //     }

    //     return $next($request);
    // }
}
