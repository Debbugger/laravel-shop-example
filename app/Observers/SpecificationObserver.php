<?php

namespace App\Observers;

use App\CategorySpecification;
use App\Specification;

class SpecificationObserver
{
    /**
     * Handle the specification "created" event.
     *
     * @param  \App\Specification  $specification
     * @return void
     */
    public function created(Specification $specification)
    {
        //
    }

    /**
     * Handle the specification "updated" event.
     *
     * @param  \App\Specification  $specification
     * @return void
     */
    public function updated(Specification $specification)
    {
        //
    }

    /**
     * Handle the specification "deleted" event.
     *
     * @param  \App\Specification  $specification
     * @return void
     */
    public function deleted(Specification $specification)
    {
        CategorySpecification::where('specification_id',$specification->id)->delete();
    }

    /**
     * Handle the specification "restored" event.
     *
     * @param  \App\Specification  $specification
     * @return void
     */
    public function restored(Specification $specification)
    {
        //
    }

    /**
     * Handle the specification "force deleted" event.
     *
     * @param  \App\Specification  $specification
     * @return void
     */
    public function forceDeleted(Specification $specification)
    {
        //
    }
}
