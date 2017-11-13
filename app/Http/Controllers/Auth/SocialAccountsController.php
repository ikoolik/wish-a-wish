<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\SocialAccount;
use App\User;

class SocialAccountsController extends Controller
{
    /**
     * Redirect a user to the external site
     *
     * @param $provider
     *
     * @return mixed
     */
    public function redirect($provider)
    {
        if(!in_array($provider, ['vkontakte'])) {
            return redirect('/login')->withErrors(['Неизвестный метод авторизации']);
        }
        return \Socialite::with($provider)->redirect();
    }

    /**
     * @param $provider
     * @param Request $request
     *
     * @return mixed
     */
    public function callback($provider, Request $request)
    {
        if($request->get('error')) {
            return redirect('/login')->withErrors(["При авторизации во внешней системе произошла ошибка"]);
        }

        $externalUser = \Socialite::driver($provider)->fields(['uid', 'first_name', 'last_name', 'screen_name', 'photo_200'])->user();
        $socialAccount = SocialAccount::where('provider', $provider)->where('external_id', $externalUser->id)->first();
        if(!$socialAccount || !$socialAccount->user) {
            $user = $this->getUserByExternalData($externalUser);
            $user->socialAccounts()->save(new SocialAccount(['provider' => $provider, 'external_id' => $externalUser->id]));
        } else {
            $user = $socialAccount->user;
        }

        auth()->login($user);
        return redirect('/');
    }

    /**
     * @param $externalUser
     * @return User
     */
    protected function getUserByExternalData($externalUser)
    {
        if(auth()->user()) {
            return auth()->user();
        }

        $user = null;
        if($externalUser->email) {
            $user = User::where('email', $externalUser->email)->first();
        }
        if(!$user) {
            $user = User::create([
                'email' => $externalUser->email,
                'name' => $externalUser->name,
                'slug' => $externalUser->nickname,
                'avatar' => $externalUser->user['photo_200']
            ]);
        }
        return $user;
    }
}
