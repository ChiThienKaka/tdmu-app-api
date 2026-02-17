<?php

use App\Features\Domain\JobApplication\Providers\JobApplicationServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Features\Domain\Recruitment\Companies\Providers\RecruiterCompanyServiceProvider::class,
    App\Features\Domain\Recruitment\Packages\Providers\RecruiterPackageServiceProvider::class,
    App\Features\Domain\Recruitment\Subscriptions\Providers\RecruiterSubscriptionServiceProvider::class,
    App\Features\Domain\Recruitment\Payments\Providers\RecruiterPaymentServiceProvider::class,
    App\Features\Domain\JobPostings\Providers\JobPostingsServiceProvider::class,
    App\Features\Domain\ApplicantProfile\Providers\StudentProfileServiceProvider::class,
    App\Features\Domain\JobApplication\Providers\JobApplicationServiceProvider::class
];
