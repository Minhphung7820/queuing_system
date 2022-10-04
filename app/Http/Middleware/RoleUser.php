<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$idFunc)
    {
        $arr = [];
        foreach (Auth::guard('web')->user()->roles->func as $key => $value) {
            $arr[] = $value->id;
        }
        if(!in_array($idFunc,$arr)){
            if($request->ajax()){
                    return response()->json(['status'=>500,'msg'=>'Your role is not authorized !']);
            }else{
                return redirect('/error');
            }
        }
        return $next($request);
    }
}
