<?php

use App\Features\Domain\JobPostings\Providers\JobPostingsServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Features\Domain\Recruitment\Companies\Providers\RecruiterCompanyServiceProvider::class,
    App\Features\Domain\Recruitment\Packages\Providers\RecruiterPackageServiceProvider::class,
    App\Features\Domain\Recruitment\Subscriptions\Providers\RecruiterSubscriptionServiceProvider::class,
    App\Features\Domain\Recruitment\Payments\Providers\RecruiterPaymentServiceProvider::class,
    App\Features\Domain\JobPostings\Providers\JobPostingsServiceProvider::class,
];
