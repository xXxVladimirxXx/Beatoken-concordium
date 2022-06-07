<?php

namespace App\Http\Controllers\Api;

use App\Traits\Eloquent\Uploadable;
use App\Mail\UserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Mail};
use App\Mail\RestorePassword;
use App\Models\{User};
use App\Http\Requests\{UserRequest, AuthRequest, RegisterRequest};
use JWTAuth;
use JWTAuthException;
use Auth;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('role:superadmin')->only('update');
    }

    /** @OA\Get(
     *     path="/users",
     *     summary="Returns list of users",
     *     tags={"indexUsers"},
     *     @OA\Response(response=200, description="Successful get list")
     * ) */
    public function index()
    {
        return User::get();
    }

    /** @OA\Get(
     *     path="/users/{user_id}",
     *     summary="Returns user by id",
     *     tags={"showUsers"},
     *     @OA\Response(response=200, description="Successful get user")
     * ) */
    public function show(User $user)
    {
        return $user->load('nfts');
    }


    /** @OA\Get(
     *     path="/users/certified-users",
     *     summary="Returns list of certifiedUsers",
     *     tags={"getCertifiedUsers"},
     *     @OA\Response(response=200, description="Successful getCertifiedUsers")
     * ) */
    public function getCertifiedUsers()
    {
        return User::where('role_id', 7)->get();
    }

    /** @OA\Put(
     *     path="/users/{user}",
     *     summary="Update user by id. Available only for superadmin",
     *     tags={"updateUsers"},
     *     @OA\Parameter(name="request", in="path", required=true, description="type=`array` |
     *     description=`array ['name', 'twitter_url', 'instagram_url', 'facebook_url', 'role_id', 'first_name', 'last_name', 'country_code', 'city', 'address', 'zip', 'cell_number', 'cell_cc']`"),
     *     @OA\Response(response=200, description="Successful update user")
     * ) */
    public function update(User $user, UserRequest $request)
    {
        $user->update($request->only(
            'name', 'twitter_url', 'instagram_url', 'facebook_url', 'role_id',
            'first_name', 'last_name', 'country_code', 'city', 'address', 'zip', 'cell_number', 'cell_cc'
        ));
        return $user;
    }

    /** @OA\Post(
     *     path="/users/edit-profile",
     *     summary="Edit profile Authorized User",
     *     tags={"editProfile"},
     *     @OA\Parameter(name="request", in="path", required=true, description="type=`array` |
     *     description=`array ['name', 'twitter_url', 'instagram_url', 'facebook_url', 'first_name', 'last_name', 'country_code', 'city', 'address', 'zip', 'cell_number', 'cell_cc']`"),
     *     @OA\Response(response=200, description="Successful update user")
     * ) */
    public function editProfile(UserRequest $request)
    {
        $user = User::find(Auth::id());
        $user->update($request->only(
            'name', 'twitter_url', 'instagram_url', 'facebook_url',
            'first_name', 'last_name', 'country_code', 'city', 'address', 'zip', 'cell_number', 'cell_cc'
        ));
        setcookie('user_name', $user->name, strtotime('+3 days'), '/', 'beatoken.com');
        return $user;
    }

    /** @OA\Get(
     *     path="/users/current-user",
     *     summary="Returns current authorized user",
     *     tags={"current-user"},
     *     @OA\Response(response=200, description="Successful current get user")
     * ) */
    public function currentUser()
    {
        if (Auth::check()) {
            return Auth::user()->load('nfts');
        } else {
            return response()->json([], 401);
        }
    }

    /** @OA\Get(
     *     path="/users/formated-current-user",
     *     summary="Returns formated current authorized user",
     *     tags={"formated-current-user"},
     *     @OA\Response(response=200, description="Successful formated current get user")
     * ) */
    public function formatedCurrentUser()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return [
                  'personal' => [
                      'first_name' => $user->first_name,
                      'last_name' => $user->last_name,
                      'cell_cc' => '+'.$user->cell_cc,
                      'cell_number' => $user->cell_number,
                      'display_image_url' => $user->full_uri_avatar,
                      'display_name' => $user->name,
                      'email' => $user->email
                  ],
                  'socials' => [
                      'twitter_url' => $user->twitter_url,
                      'facebook_url' => $user->facebook_url,
                      'instagram_url' => $user->instagram_url,
                  ],
                  'shipping' => [
                      'country_code' => $user->country_code,
                      'city' => $user->city,
                      'address' => $user->address,
                      'zip' => $user->zip,
                  ]
            ];
        } else {
            return response()->json([], 401);
        }
    }

    /** @OA\Post(
     *     path="/login",
     *     summary="Authorization in the system",
     *     tags={"login"},
     *     @OA\Parameter(name="email", in="path", required=true, description="type=`email` | description=`Email`"),
     *     @OA\Parameter(name="password", in="path", required=true, description="type=`string` | description=`Password`"),
     *     @OA\Response(response=200, description="Successful login")
     * ) */
    public function authenticate(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();
        if($user && $user->password == 'confirm') {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'invalid_email_or_password',
                ], 400);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'failed_to_create_token',
            ], 500);
        }

        $user = User::find(Auth::id());

        setcookie('user_name', $user->name, strtotime('+3 days'), '/', 'beatoken.com');
        setcookie('user_picture', $user->full_uri_avatar, strtotime('+3 days'), '/', 'beatoken.com');

        return response()->json(compact('token', 'user'));
    }

    /** @OA\Post(
     *     path="/register",
     *     summary="Registration in the system",
     *     tags={"register"},
     *     @OA\Parameter(name="email", in="path", required=true, description="type=`email` | description=`Email`"),
     *     @OA\Parameter(name="name", in="path", required=true, description="type=`string` | description=`Name`"),
     *     @OA\Parameter(name="password", in="path", required=true, description="type=`string` | description=`Password`"),
     *     @OA\Response(response=200, description="Successful register")
     * ) */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->only('email', 'name', 'password'));
            $user->password = bcrypt($request->password);
            $user->code = mt_rand(1111, 9999);
            $user->save();

            Mail::to($user->email)
                ->send(new UserRegistered($user));

        } catch (\Exception $e) {
            return response()->json([
                'response' => 'error',
                'messageError' => $e->getMessage()
            ], 400);
        }

        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        return response()->json(compact('token', 'user'), 200);
    }

    /** @OA\Post(
     *     path="/users/email/verify",
     *     summary="Email verify",
     *     tags={"verifyEmail"},
     *     @OA\Parameter(name="code", in="path", required=true, description="type=`string` | description=`Verify`"),
     *     @OA\Response(response=200, description="Successful verify")
     * ) */
    public function verifyEmail(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user->code == $request->code) {
            $user->update(['code' => NULL]);
            return response()->json($user->markEmailAsVerified(), 200);
        } else {
            $user->update(['code' => NULL]);
            return response()->json(['message' => 'invalid code specified'], 500);
        }
    }

    /** @OA\Get(
     *     path="/users/email/resend",
     *     summary="Email resend code",
     *     tags={"resendCode"},
     *     @OA\Response(response=200, description="Successful resend code")
     * ) */
    public function resendCode()
    {
        $user = User::find(Auth::id());
        $user->code = mt_rand(1111, 9999);
        $user->save();

        Mail::to($user->email)
            ->send(new UserRegistered($user));
    }

    /** @OA\Post(
     *     path="/users/change-avatar",
     *     summary="Change avatar",
     *     tags={"changeAvatar"},
     *     @OA\Parameter(name="avatar", in="path", required=true, description="type=`file` | description=`Avatar file`"),
     *     @OA\Response(response=200, description="Successful change avatar")
     * ) */
    public function changeAvatar(Request $request)
    {
        $user = User::find(Auth::id());
        $user->avatar_url = Uploadable::uploadPhoto($request->avatar,
            'avatar.jpg',
            Auth::id() . '_user_avatar'
        );
        $user->save();

        setcookie('user_picture', $user->full_uri_avatar, strtotime('+3 days'), '/', 'beatoken.com');

        return response()->json($user, 200);
    }

    /** @OA\Post(
     *     path="/users/change-password",
     *     summary="Change password",
     *     tags={"changePassword"},
     *     @OA\Parameter(name="oldPassword", in="path", required=true, description="type=`string` | description=`Old password`"),
     *     @OA\Parameter(name="newPassword", in="path", required=true, description="type=`string` | description=`New password`"),
     *     @OA\Response(response=200, description="Successful change password")
     * ) */
    public function changePassword(Request $request)
    {
        $user = User::find(Auth::id());
        $credentials = ['email' => $user->email, 'password' => $request->oldPassword];
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'response' => 'error',
                'message' => 'invalid_password',
            ], 400);
        }
        $user->password = bcrypt($request->newPassword);
        $user->save();

        return response()->json($user, 200);
    }

    /** @OA\Get(
     *     path="/forgot-password/{email}",
     *     summary="Forgot password",
     *     tags={"forgotPassword"},
     *     @OA\Response(response=200, description="Successful sent forgot password letter")
     * ) */
    public function forgotPassword($email)
    {
        try {
            $user = User::where(['email' => $email])->first();

            if (is_null($user)) {
                return response()->json(['message' => 'Failed to send the email to restore. User with this email was not found'], 400);
            }

            $user->code = mt_rand(1111, 9999);
            $user->save();

            Mail::to($user->email)
                ->send(new RestorePassword($user));

            return response()->json(['message' => 'Restore Email has been sent to Your Inbox'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to send the email to restore. ' . $e->getMessage()], 400);
        }
    }

    /** @OA\Post(
     *     path="/reset/process",
     *     summary="setNewPassword",
     *     tags={"setNewPassword"},
     *     @OA\Parameter(name="email", in="path", required=true, description="type=`email` | description=`Email`"),
     *     @OA\Parameter(name="code", in="path", required=true, description="type=`string` | description=`Code`"),
     *     @OA\Parameter(name="password", in="path", required=true, description="type=`string` | description=`Password`"),
     *     @OA\Response(response=200, description="Successful reset password")
     * ) */
    public function setNewPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->code == $request->code) {
            $user->update(['code' => NULL]);
        } else {
            $user->update(['code' => NULL]);
            return response()->json(['message' => 'invalid code specified'], 500);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['New password has been set', 'success' => true], 200);
    }

    /** @OA\Get(
     *     path="/logout",
     *     summary="logout",
     *     tags={"logout"},
     *     @OA\Response(response=200, description="Redirect")
     * ) */
    public function logout()
    {
        setcookie('user_name', '', time() - 3600, '/', 'beatoken.com');
        setcookie('user_picture', '', time() - 3600, '/', 'beatoken.com');
        setcookie('beatoken_session', '', time() - 3600, '/');
        return redirect(env('WP_BEATOKEN', 'https://beatoken.com'));
    }
}
