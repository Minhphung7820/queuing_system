<?php

namespace App\Http\Middleware;

use App\Models\Services;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class SetDateForServices
{

    public function handle(Request $request, Closure $next)
    {
        foreach (Services::all() as $key => $value) {
            if (in_array('reset', explode(',', $value->number_rule))) {
                if (now()->toDateString() >= $value->timeoutRule) {
                    Services::find($value->id)->update([
                        'timeoutRule' => now()->addDays(1)->toDateString(),
                        'number_current' => 1
                    ]);
                }
            } else {
                Services::find($value->id)->update([
                    'timeoutRule' => null,
                ]);
            }
        }
        return $next($request);
    }
}
