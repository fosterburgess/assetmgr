<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manufacturer extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'url1',
        'url2',
        'email',
        'phone',
    ];

    protected $searchableFields = ['*'];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
