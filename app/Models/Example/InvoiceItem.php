<?php

namespace App\Models\Example;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table = 'example_invoice_items';

    protected $fillable = [
        'invoice_id',
        'item_name',
        'item_description',
        'quantity',
        'price',
        'amount',
    ];
}
