<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'type',
        'comment',
        'count',
    ];
    public function scopeCountProductLeft($query, $value)
    {
        return ($this->countProductIn($value) - $this->countProductOut($value));
    }

    public function scopeCountProductIn($query, $value)
    {
        return $query->where(['product_id' => $value, 'type' => 1])->sum('count');
    }

    public function scopeCountProductOut($query, $value)
    {
        return $query->where(['product_id' => $value, 'type' => 2])->sum('count');
    }

    public function scopeGraphMounth($query, $value)
    {
        if ($value == date('m')) {
            $colDays = date('d');
        } else {
            $colDays = cal_days_in_month(CAL_GREGORIAN, $value, date('Y'));
        }

        $days = array_fill(1, $colDays, 0);
        foreach ($query->with('product')->whereMonth('created_at', $value)->where('type',2)->orderBy('created_at','desc')->get() as $stock) {
            $days[intval($stock->created_at->format('d'))] += intval($stock->product->currentCost * $stock->count);
        }
        return $days;
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
