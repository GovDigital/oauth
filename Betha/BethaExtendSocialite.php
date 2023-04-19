<?php

namespace GovDigital\OAuth\Betha;

use SocialiteProviders\Manager\SocialiteWasCalled;

class BethaExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('betha', Provider::class);
    }
}
