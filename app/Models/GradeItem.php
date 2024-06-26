<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'max_degree'];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
