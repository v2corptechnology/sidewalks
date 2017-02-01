<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Sidewalks',
        'product' => 'Sidewalks subscription',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'romain.sauvaire@gmail.com';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'romain.sauvaire@gmail.com',
        'abergel.arthur@gmail.com',
        'selma.ndrsn@gmail.com',
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = false;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        // https://spark.laravel.com/docs/3.0/billing#collecting-billing-addresses
        Spark::collectBillingAddress();

        Spark::useStripe()->noCardUpFront()->trialDays(30);

        Spark::freePlan()
            ->features([
                'First', 'Second', 'Third'
            ]);

        Spark::plan('Basic', 'yearly')
            ->price(10)
            ->yearly()
            ->features([
                'First', 'Second', 'Third'
            ]);
    }
}
