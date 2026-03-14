<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property $id
 * @property $sku
 * @property $name
 * @property $description
 * @property $stock
 * @property $price
 * @property $active
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Product extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['sku', 'name', 'description', 'stock', 'price', 'active'];

    protected static function booted()
    {
        static::creating(function ($product) {
            $product->sku = self::generateSku();
        });
    }

    //Generación del SKU en formato ART-0001-AB
    private static function generateSku(): string
    {
        do {
            $lastId = self::max('id') + 1;
            $number = str_pad($lastId, 4, '0', STR_PAD_LEFT);
            $letters = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2));
            $sku = "ART-{$number}-{$letters}";
        } while (self::where('sku', $sku)->exists());

        return $sku;
    }

}
