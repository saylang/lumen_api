<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\User;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;
    protected $auth;

    public function __construct(JWTAuth $jwt, Auth $auth)
    {
        $this->jwt = $jwt;
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {
            $credentials = $request->only('email', 'password');
            $user = User::where('email', '=', $credentials['email'])->first();
            if(!$user){
                return response()->json(['data'=>['msg'=>'User not found','error'=>1]], 405);
            }
            if (!app('hash')->check($credentials['password'], $user->password)) {
                return response()->json(['data'=>['msg'=>'User not found','error'=>1]], 404);
            }
            $scope = [];
            if(!empty($user->role)){
                foreach ($user->role as $key => $role) {
                    $permission = $role->permissions->toArray();
                    $scope[$key] = array_column($permission,'name');
                }
                $scope = array_unique(array_flatten($scope));
            }            
            $token = $this->jwt->claims(['scope' => $scope])->fromUser($user);
            if (!$token) {
                return response()->json(['data'=>['msg'=>'User not found','error'=>1]], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], $e->getStatusCode());
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $payload = $this->auth->payload();
        $data = $payload->toArray();
        $data['user'] = $this->auth->user();
        return response()->json($data);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->auth->logout();
        return response()->json([
            'message' => 'User logged off successfully!'
        ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->auth->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60
        ]);
    }
}