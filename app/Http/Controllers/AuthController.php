<?php


namespace App\Http\Controllers;


use App\Exceptions\AuthException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repository\UserRepository;
use App\Service\JwtToken;
use Illuminate\Http\Response;

class AuthController extends ApiController
{
    private $repository;

    /**
     * AuthController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param RegisterRequest $request
     * @return Response
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        try {
            $this->repository->store([
                'name' => $request->name,
                'email' => $request->email,
                'password' => app('hash')->make($request->password)
            ]);
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
                $expiration = 24 * 60 * 60;
                $token = (new JwtToken([config('jwt.algo')], config('jwt.secret'), 'chope', $expiration))->createToken($user, app('redisCache'));
                return $this->sendResponse([
                    "token_type" => "Bearer",
                    "expires_in" => $expiration,
                    'access_token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ]
                ], 'Login successfully');
            }
        }

        throw new AuthException("These credentials do not match our records.");

    }
}
