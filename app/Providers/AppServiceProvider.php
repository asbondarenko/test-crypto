<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use BeyondCode\Mailbox\Facades\Mailbox;
use App\Mailboxes\CryptoMailbox;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Relation::morphMap([
            \App\Models\User::ENTITY_TYPE => 'App\Models\User',
            \App\Models\Cryptocurrency::ENTITY_TYPE => 'App\Models\Cryptocurrency',
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Mailbox::to('apitester@test.com', CryptoMailbox::class);
    }
}
