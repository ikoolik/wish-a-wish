<?php

namespace Wish\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Wish\Http\Controllers\Controller;
use Wish\SocialAccount;
use Wish\User;

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

        $externalUser = \Socialite::driver($provider)->user();
        $socialAccount = SocialAccount::firstOrCreate(['provider' => $provider, 'external_id' => $externalUser->id]);
        $user = $socialAccount->user;
        if(!$user) {
            $user = $this->getUserByExternalData($externalUser);
            $user->socialAccounts()->save($socialAccount);
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
                'slug' => $externalUser->nickname
            ]);
        }
        return $user;
    }
}
