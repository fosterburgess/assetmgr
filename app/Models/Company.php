<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'owner_id',
        'team_id',
        'name',
        'logo',
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
        'country',
        'notes',
        'url1',
        'url2',
        'url3',
        'email',
        'phone',
    ];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
