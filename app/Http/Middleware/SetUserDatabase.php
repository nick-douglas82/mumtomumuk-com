<?php namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
class SetUserDatabase {
    /**
     * Sets the connection's database to the current user database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        dd('here');
        // Close any connection made before to avoid conflicts
        DB::disconnect('milton_keynes');
        // Set the connection's database to the user's own database
        Config::set('database.connections.milton_keynes.database');

        return $next($request);
    }
}
