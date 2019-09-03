<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
use File;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'redirectToProvider', 'handleProviderCallback');
    }
    
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect('/login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => __('auth.failed'),
            ]);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
                        ->redirect();
    }
    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        if($provider == 'facebook') {
            $driver = Socialite::driver($provider)
                                ->fields(['first_name', 'last_name', 'email', 'name']);
            $user = $driver->user();
            
            $authUser = $this->findOrCreateUser($user, $provider);
            
            if(!empty($authUser->password)) {
                Auth::login($authUser, true);
                return redirect('/home');
            } else {
                Auth::loginUsingId($authUser->id, true);
                return redirect()->route('password');
            }
            
        } else {
            $driver = Socialite::driver($provider);
            $user = $driver->user();
            
            $authUser = $this->findOrCreateUser($user, $provider);
            
            if(!empty($authUser->password)) {
                Auth::login($authUser, true);
                return redirect('/home');
            } else {
                Auth::loginUsingId($authUser->id, true);
                return redirect()->route('password');
            }
            
        }

    }
    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        if(auth()->user()) {
            if(empty(auth()-user()->provider_id)) {
                if(auth()->user()->email == $user->email) {
                    auth()->user()->provider = $provider;
                    auth()->user()->provider_id = $User->id;
                    auth()->user()->save();

                    return auth()->user();
                } else {
                    if($provider == 'facebook') {
                        auth()->user()->fb = $user->email;
                        auth()->user()->save();

                        return auth()->user();
                    } else {
                        auth()->user()->tw = $user->email;
                        auth()->user()->token = $user->token;
                        auth()->user()->secret = $user->tokenSecret;
                        auth()->user()->save();

                        return auth()->user();
                    }
                }
            } else {
                if($provider == 'facebook') {
                    auth()->user()->fb = $provider;
                    auth()->user()->save();

                    return auth()->user();
                } else {
                    auth()->user()->tw = $provider;
                    auth()->user()->token = $user->token;
                    auth()->user()->secret = $user->tokenSecret;
                    auth()->user()->save();

                    return auth()->user();
                }
            }
        } else {
            $authUser = User::where('email', $user->email)
                            ->first();
        }

        if ($authUser) {
            if(empty($authUser->provider_id)) {
                $authUser->provider = $provider;
                $authUser->provider_id = $User->id;
                $authUser->save();
            }
            return $authUser;
        }
        else{
            $NameArray = explode(' ',$user->name);
            $first_name = $NameArray[0];
            
            $newuser = new User;
            $newuser->name = $user->name;
            $newuser->fname = !empty($user->user['first_name'])? $user->user['first_name'] : '' ;
            $newuser->lname = !empty($user->user['last_name'])? $user->user['last_name'] : '' ;
            $newuser->email = !empty($user->email)? $user->email : '' ;
            $newuser->provider = $provider;
            $newuser->provider_id = $user->id;
            $newuser->username = "user_".trim(strtolower($first_name)).trim(substr($user->id, 0,4));
            if(!empty($user->avatar)) {
                $fileContent = file_get_contents($user->avatar);
                $fileNameToStore = "avatar_".trim(strtolower($first_name)).trim(substr($user->id, 0,4)).time(). ".jpg";
                File::put(public_path() . '/public/cover_image/' . $fileNameToStore, $fileContent);
                
                $newuser->profile_image = $fileNameToStore;
            } else {
                $newuser->profile_image = 'default.jpg';
            }

            if($provider == 'twitter') {
                $newuser->token = $user->token;
                $newuser->secret = $user->tokenSecret;
            }

            $newuser->save();

            return $newuser;
        }
        
    }

}
