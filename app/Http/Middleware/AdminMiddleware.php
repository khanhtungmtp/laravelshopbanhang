<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()){
            if (Auth::user()->role > 0){
                return $next($request);
            } else {
                return redirect()->route('admin.getLogin')->with('error','Truy cập bị từ chối, bạn không có quyền vào trang này');
            }
        }else {
            return redirect()->route('admin.getLogin')->with('error','Truy cập bị từ chối, vui lòng đăng nhập');
        }
    }
}
