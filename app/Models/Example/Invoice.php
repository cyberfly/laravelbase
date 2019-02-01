<?php

namespace App\Models\Example;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'example_invoices';

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'po_number',
        'invoice_date',
        'payment_due',
        'publish_status',
        'published_at',
    ];

    protected $dates = [
        'invoice_date',
        'payment_due',
        'published_at',
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }
}
