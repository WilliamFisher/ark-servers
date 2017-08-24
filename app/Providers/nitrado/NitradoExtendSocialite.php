<?php

namespace App\Providers\Nitrado;

use SocialiteProviders\Manager\SocialiteWasCalled;

class NitradoExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'nitrado', __NAMESPACE__.'\Provider'
        );
    }
}
