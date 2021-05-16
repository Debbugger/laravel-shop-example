<?php

namespace App\Observers;

use App\Partner;
use Illuminate\Support\Facades\Storage;

class PartnerObserver
{
    /**
     * Handle the partner "created" event.
     *
     * @param  \App\Partner  $partner
     * @return void
     */
    public function created(Partner $partner)
    {
        //
    }

    /**
     * Handle the partner "updated" event.
     *
     * @param  \App\Partner  $partner
     * @return void
     */
    public function updated(Partner $partner)
    {
        //
    }

    /**
     * Handle the partner "deleted" event.
     *
     * @param  \App\Partner  $partner
     * @return void
     */
    public function deleted(Partner $partner)
    {
        Storage::disk('public')->delete($partner->image);
    }

    /**
     * Handle the partner "restored" event.
     *
     * @param  \App\Partner  $partner
     * @return void
     */
    public function restored(Partner $partner)
    {
        //
    }

    /**
     * Handle the partner "force deleted" event.
     *
     * @param  \App\Partner  $partner
     * @return void
     */
    public function forceDeleted(Partner $partner)
    {
        //
    }
}
