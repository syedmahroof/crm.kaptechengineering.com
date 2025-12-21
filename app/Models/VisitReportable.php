<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VisitReportable extends Pivot
{
    protected $table = 'visit_reportables';
    
    protected $fillable = [
        'visit_report_id',
        'visit_reportable_id',
        'visit_reportable_type',
    ];
}
