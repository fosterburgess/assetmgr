<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'email',
        'phone',
        'mobile',
        'notes',
        'avatar',
    ];

    protected $searchableFields = ['*'];

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
    }

    public function locations()
    {
        return $this->belongsToMany(
            Location::class,
            'company_contact',
            'contact_id',
            'company_id'
        );
    }
}
