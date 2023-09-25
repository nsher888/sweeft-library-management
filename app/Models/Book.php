<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $fillable = ['name', 'publication_year', 'available'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }
}
