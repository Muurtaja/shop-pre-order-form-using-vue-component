<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class Preorder extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'email',
        'phone',
        'deleted_by_id',
    ];


    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by_id',  'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($preorder) {
            if (Auth::check()) {
                $preorder->deleted_by_id = Auth::id();
                $preorder->save();
            }
        });
        static::restored(function ($preorder) {
            $preorder->deleted_by_id = null;
            $preorder->save();
        });
    }
}
