<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogsQueries
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        DB::listen(function (QueryExecuted $event) {
            if (round($event->time / 500, 0, PHP_ROUND_HALF_UP) > 1) {
                Log::info(
                    'SQL Query',
                    [
                        $event->sql,
                        $event->bindings,
                        $event->time . ' MS',
                        round($event->time / 1000, 0, PHP_ROUND_HALF_UP) . ' S',
                    ]
                );
            }
        });
        return $next($request);
    }
}
