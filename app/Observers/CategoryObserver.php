<?php

namespace App\Observers;

use App\Category;
use App\CategorySpecification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryObserver
{
    /**
     * Handle the category "created" event.
     *
     * @param \App\Category $category
     * @return void
     */
    public function created(Category $category)
    {
        if (!empty($category->specifications_add)) {
            DB::transaction(function () use ($category) {
                foreach ($category->specifications_add as $val) {
                    CategorySpecification::create(['category_id' => $category->id, 'specification_id' => $val]);
                }
            }, 1);
        }
    }

    /**
     * Handle the category "updated" event.
     *
     * @param \App\Category $category
     * @return void
     */
    public function updating(Category $category)
    {


    }

    /**
     * Handle the category "deleted" event.
     *
     * @param \App\Category $category
     * @return void
     */
    public function deleted(Category $category)
    {

        if ($category->image != $category->defaultCategoryImage) {
            Storage::disk('public')->delete($category->image);
        }
    }

    /**
     * Handle the category "restored" event.
     *
     * @param \App\Category $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param \App\Category $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
