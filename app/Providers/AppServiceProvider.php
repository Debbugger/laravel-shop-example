<?php

namespace App\Providers;

use App\Category;
use App\Image;
use App\Observers\CategoryObserver;
use App\Observers\ImageObserver;
use App\Observers\OrderObserver;
use App\Observers\OrderProductObserver;
use App\Observers\PartnerObserver;
use App\Observers\ProductObserver;
use App\Observers\SmsCodeObserver;
use App\Observers\SpecificationObserver;
use App\Observers\StockObserver;
use App\Order;
use App\OrderProduct;
use App\Partner;
use App\Product;
use App\Seo;
use App\SmsCode;
use App\Specification;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if (env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }
    
        Category::observe(CategoryObserver::class);

        Product::observe(ProductObserver::class);

        Image::observe(ImageObserver::class);

        Specification::observe(SpecificationObserver::class);

        OrderProduct::observe(OrderProductObserver::class);

        Order::observe(OrderObserver::class);

        Partner::observe(PartnerObserver::class);

        Stock::observe(StockObserver::class);

        SmsCode::observe(SmsCodeObserver::class);

        Schema::defaultStringLength(191);


        View::composer('layouts.header', function ($view) use ($request) {
            $view->with('countProducts', Product::with('category')->whereHas('category',function ($q){
               $q->where('status',1);
            })->sum('count'));
            $view->with('categories',Category::where('status',1)->whereNull('parent_id')->get());
        });
        View::composer('modules.user.profile-footer', function ($view) use ($request) {
            $view->with('categories',Category::where('status',1)->whereNull('parent_id')->get());
        });
        View::composer('layouts.footer', function ($view) use ($request) {
            $view->with('partners', Partner::where('status',1)->get());
        });
        View::composer('*', function ($view) use ($request) {
            $view->with('currentUser', Auth::user());

            if (!$request->is('*admin*')) {
                $path = parse_url(\LaravelLocalization::getNonLocalizedURL($request->path()))['path'];
                $key = str_replace('/', '-', $path);
                $meta = Cache::remember($key, 300, function () use ($path) {
                    $data = SEO::whereAddress($path)->first();

                    return empty($data) ? '' : $data;
                });
                $view->with('metaTags', empty($meta) ? (object)['title' => '', 'keywords' => '', 'description' => ''] : $meta);
            }
        });

    }
}
