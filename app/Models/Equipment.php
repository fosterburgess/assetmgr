<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'serial_number',
        'purchase_date',
        'metadata',
        'notes',
        'location_id',
        'manufacturer_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'purchase_date' => 'date',
        'metadata' => 'array',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
      public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
