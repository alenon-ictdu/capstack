<?php

namespace ICTDUInventory\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use ICTDUInventory\Borrower;
use ICTDUInventory\Course;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (Schema::hasTable('borrowers')) {
            $allCourses = Course::all();
            $penalty = Borrower::whereDate('deadline', '<', date("Y-m-d") );
            $borrowers = Borrower::whereDate('deadline', '<', date("Y-m-d") )->orderBy('deadline', 'desc')->paginate(4);
            $penalty_num = $penalty->count();
            view()->share('penalty_num', $penalty_num);
            view()->share('public_borrowers', $borrowers);
            view()->share('allCourses', $allCourses);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
