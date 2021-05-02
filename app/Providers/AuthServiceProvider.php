<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      'App\Models\Card' => 'App\Policies\CardPolicy',
      'App\Models\Client' => 'App\Policies\ClientPolicy',
      'App\Models\Coupon' => 'App\Policies\CouponPolicy',
      'App\Models\CreditCard' => 'App\Policies\CreditCardPolicy',
      'App\Models\Image' => 'App\Policies\ImagePolicy',
      'App\Models\Item' => 'App\Policies\ItemPolicy',
      'App\Models\Product' => 'App\Policies\ProductPolicy',
      'App\Models\Purchase' => 'App\Policies\PurchasePolicy',
      'App\Models\Review' => 'App\Policies\ReviewPolicy',
      'App\Models\ShipDetail' => 'App\Policies\ShipDetailPolicy',
      'App\Models\Shopper' => 'App\Policies\ShopperPolicy',
      'App\Models\Supplier' => 'App\Policies\SupplierPolicy',
      'App\Models\Tag' => 'App\Policies\TagPolicy'
      
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
