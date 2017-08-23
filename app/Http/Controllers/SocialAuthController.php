<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SocialAccountService;

use Socialite;

class SocialAuthController extends Controller
{
  public function redirect($provider)
  {
    return Socialite::with($provider)->redirect();
  }

  public function callback(SocialAccountService $service, $provider)
  {
    $user = $service->createOrGetUser(Socialite::driver($provider));

    auth()->login($user);

    return redirect('dashboard');
  }

}
