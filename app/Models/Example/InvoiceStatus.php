<?php

namespace App\Models\Example;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    const DRAFT = 'DRAFT';
    const SUBMITTED = 'SUBMITTED';
}
