<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class PermissionMiddleware
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->all();
        if(empty($params['scope'])){
            return response('Scope is required.', 401);
        }
        $param_scope = explode(',', $params['scope']);
        $payload = $this->auth->payload()->toArray();
        $scope = $payload['scope'];
        $intersect = array_intersect($param_scope, $scope);
        if(count($param_scope) != count($intersect)){
            return response('Unauthorized', 401);
        }
        return $next($request);
    }
}
