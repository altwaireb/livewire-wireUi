<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\AuthResource;
use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponses;

    public function __construct()
    {
        $this->middleware('auth')->only(
            'logout',
            'getUser',
            'resetPassword'
        );
        $this->middleware('guest')->only(
            'register',
            'login',
            'sendPasswordResetLinkEmail'
        );
    }

    /**
     * Register.
     *
     * @param  StoreUserRequest  $request
     * @return JsonResponse
     */
    public function register(StoreUserRequest $request): JsonResponse
    {
        // Set 'role_id' of the field in the default role id
        $request->request->set('role_id', Role::getDefaultBy());
        $request->validate(
            ['role_id' => ['required', 'integer', 'exists:App\Models\Role,id']],
            ['role_id.required' => __('auth.role_id_is_null')],
            $request->all()
        );

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        // Create Token by use field device_name
        $token = $user->createToken($request->device_name)->plainTextToken;

        event(new Registered($user));

        $data = [
            'data' => new AuthResource(User::with('role')->findOrFail($user->id)),
            'token' => $token,
        ];

        return $this->createdResponse($data);
    }

    /**
     * Login.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        // device_name Just to Create Token
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required|string|min:6',
            'device_name' => 'required',
        ]);

        // Check email
        $user = User::where('email', $request->email)->with('role')->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.The provided credentials are incorrect')],
            ]);
        }

        // if user has Permission Banned
        if ($user->hasPermission('banned')) {
            return $this->unauthorizedResponse(
                null,
                __('auth.Your account has been suspended')
            );
        }

        // Update Last Activity in table user and add user id to Cache
        $expiresAt = Carbon::now()->addMinutes(4);
        Cache::put('user-is-online'.$user->id, true, $expiresAt);
        $user->updateLastActivity();

        // Create Token by use field device_name
        $token = $user->createToken($request->device_name)->plainTextToken;

        $response = [
            'user' => new AuthResource($user),
            'token' => $token,
        ];

        return $this->createdResponse($response);
    }

    /**
     * logout.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->successResponse([
            'message' => __('auth.user logged out'),
        ]);
    }

    /**
     * Get authenticated user details use AuthResource.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getUser(Request $request): JsonResponse
    {
        return $this->successResponse(new AuthResource(User::with('role')->findOrFail($request->user()->id)));
    }

    /**
     * Send Password Reset Link Email.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function sendPasswordResetLinkEmail(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return $this->successResponse(['message' => __($status)]);
        } else {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }
    }

    /**
     * Reset Password.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return $this->successResponse(['message' => __($status)]);
        } else {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }
    }
}
