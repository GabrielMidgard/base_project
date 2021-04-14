<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
/* use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException; */

class JwtController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:jwt', ['except' => ['login','register','validator']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function login(Request $request){
        $credentials = $request->only('username', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
            
            /*$respondToken = $this->respondWithToken($token);
            $original = $respondToken->original;
            $data = json_decode($original["data"]);
            
            //$accessToken = $original->access_token;

            return response()->json(['user' => $data], 200);
            //return $this->respondWithToken($token);
            */
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    //Metodo de autentificacion
    public function login2(Request $Request){
        return "Hwllou2";
        //Obtiene credenciales mandadas en la peticion.
        $credentials = $Request->all();       
        //Intenta el loggeo con las credenciales
        if(empty($credentials))
        {
            $auth_head=$Request->header('Authorization');
            $arr=explode(" ",$auth_head);
            $value=explode(':',base64_decode($arr[1]));
            $credentials=[
                'email' => $value[0],
                'password' => $value[1]
            ];
        }
    	try {
    		if(!$token=JWTAuth::attempt($credentials)){
                //Respuesta en caso de credenciales incorrectas
    			return response()->json(["error"=>"Credenciales invalidas"],401);
    		}
    	} catch (JWTException $e) {
            //Respuesta en cualquier error del servidor
    		return response()->json(["error"=>"Ocurrio un error en el servidor."],500);
    	}
        //Esto solo se ejecutara en caso de que las credenciales sean correctas.
    	$user=Auth::user();
       
    	return $response;
    }

    public function authenticate2(Request $Request){
        return response()->json(["error"=>"Ocurrio un error en el servidor."],200);
    }
    //Metodo de autentificacion
    public function authenticate(Request $Request)
    {
        //Obtiene credenciales mandadas en la peticion.
        $credentials = $Request->all();       
        //Intenta el loggeo con las credenciales
    	try {
    		if(!$token=JWTAuth::attempt($credentials)){
                //Respuesta en caso de credenciales incorrectas
    			return response()->json(["error"=>"Credenciales XYZ invalidas"],401);
    		}
    	} catch (JWTException $e) {
            //Respuesta en cualquier error del servidor
    		return response()->json(["error"=>"Ocurrio un error en el servidor."],500);
    	}
        //Esto solo se ejecutara en caso de que las credenciales sean correctas.
    	$user=Auth::user();
       
    	$response = array(
    		'token' => "Bearer ".$token, 
    		'user'=>$user,
    	);
    	
    	return $response;
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60,
            'data' => $this->me()->getContent(),
            'success' => true
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    public function register(Request $request){
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $user = $this->guard()->login($user);

        return response()->json(['message' => 'Register Successfully']);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return auth()->guard('jwt');
    }
}
