<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Features\Domain\Recruitment\Packages\Providers\RecruiterPackageServiceProvider::class,
    App\Features\Domain\Recruitment\Subscriptions\Providers\RecruiterSubscriptionServiceProvider::class,
    App\Features\Domain\Recruitment\Payments\Providers\RecruiterPaymentServiceProvider::class,
];
