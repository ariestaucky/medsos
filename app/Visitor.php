<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'visitor', 'user_page',
    ];

    protected $table = 'visitor';
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\User', 'visitor');
    }

    public function scopeVisitor($query) {
        return $query->where('user_page', auth()->user()->id)
        ->where('created_at', '>', Carbon::now()->subDay(7))
        ->select('visitor', 'created_at', DB::raw('count(visitor) as total'))
        ->groupBy('visitor')
        ->orderBy('created_at', 'desc')
        ->take(8);
    }
}
