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

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    public function manufacturers()
    {
        return $this->belongsToMany(Manufacturer::class);
    }
}
