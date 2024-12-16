<?php

namespace App\Providers;

use App\Models\Models\Administrator\WebsiteSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register() {}

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if (Schema::hasTable('website_settings')) {
            $settings = WebsiteSetting::first();
            if ($settings) {
                foreach ($settings->toArray() as $key => $value) {
                    Config::set("website-setting.{$key}", $value);
                }
            }
        }
    }
}
