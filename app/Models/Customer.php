<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'kana', 'tel', 'email',
        'postcode', 'address', 'birthday', 'gender', 'memo'
    ];

    public function scopeSearchCustomers($query, $input)
    {
        // if (!empty($input)) {
        //     if (Customer::where('kana', 'like', '%' . $input . '%')
        //         ->orWhere('tel', 'like', '%' . $input . '%')->exists()) {
        //             return $query->where('kana', 'like', '%' . $input . '%')
        //                 ->orWhere('tel', 'like', '%' . $input . '%');
        //         }
        // }

        if (!empty($input)) {
            return $query->where('kana', 'like', '%' . $input . '%')
                ->orWhere('tel', 'like', '%' . $input . '%');
        }
    }
}
