<?php


namespace App\Http\Controllers;


use App\Events\UserLoginEvent;
use App\Events\UserLogoutEvent;
use App\Events\UserRegisterEvent;
use App\Exceptions\AuthException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repository\UserRepository;
use App\Service\JwtToken;
use App\Service\Transformer\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends ApiController
{
    private $repository;
    private $transformer;

    /**
     * AuthController constructor.
     * @param UserRepository $repository
     * @param UserTransformer $transformer
     */
    public function __construct(UserRepository $repository, UserTransformer $transformer)
    {
        $this->repository = $repository;
        $this->transformer = $transformer;
    }

    /**
     * @param RegisterRequest $request
     * @return Response
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->repository->store([
                'name' => $request->name,
                'email' => $request->email,
                'password' => app('hash')->make($request->password)
            ]);
            event(new UserRegisterEvent($user));
            return $this->sendResponse([], 'Registered successfully', 201);
        } catch (\Exception $exception) {
            throw $exception;
        }

    }

    /**
     * @param LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request)
    {
        if ($user = $this->repository->findBy('email', $request->username)) {
            if (app('hash')->check($request->password, $user->password)) {
                $expiration = config('jwt.ttl');
                $token = (new JwtToken(
                    [config('jwt.algo')],
                    config('jwt.secret'),
                    config('jwt.issuer'),
                    $expiration)
                )->createToken($user['id']);
                app('redisCache')->set(sprintf('user:%d:token', $user->id), $token, $expiration);
                app('redisCache')->set($token, serialize($user), $expiration);
                event(new UserLoginEvent($user));
                return $this->sendResponse([
                    "token_type" => "Bearer",
                    "expires_in" => $expiration,
                    'access_token' => $token,
                    'user' => $this->transformer->transform($user)
                ], 'Login successfully');
            }
        }

        throw new AuthException("These credentials do not match our records.");
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        app('redisCache')->delete($request->bearerToken());
        app('redisCache')->delete(sprintf('user:%d:token', $request->user()->id));
        event(new UserLogoutEvent($request->user()));
        return $this->sendResponse([], 'Logout successfully');
    }
}
