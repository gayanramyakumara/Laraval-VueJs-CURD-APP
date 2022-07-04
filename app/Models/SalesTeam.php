<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SalesTeam extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'telephone', 'current_route', 'joined_date', 'comments'];

    public function getJoinedDateAttribute($value)
    {
        return Carbon::parse($value)->toDateString();
    }

    public function setJoinedDateAttribute($value)
    {
        $this->attributes['joined_date'] = Carbon::parse($value)->toDateTimeString();
    }
}
