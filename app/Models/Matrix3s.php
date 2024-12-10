<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matrix3s extends Model
{
    use HasFactory;
    protected $fillable = [
        'current_id','user_id','username','position','user_posid','sponser_id','option','status',
    ];

    public function leftChild()
    {
        return $this->hasOne(matrix3s::class, 'sponser_id', 'user_id')
                    ->where('position', 'L')
                    ->where('current_id', $this->getAttribute('current_id'));
    }

    public function rightChild()
    {
        return $this->hasOne(matrix3s::class, 'sponser_id', 'user_id')
                    ->where('position', 'R')
                    ->where('current_id', $this->getAttribute('current_id'));
    }
    public function children()
{
    return $this->hasMany(matrix3s::class, 'sponser_id', 'user_id');
}

    public function parent()
    {
        return $this->belongsTo(matrix3s::class, 'sponser_id', 'id');
    }
}
