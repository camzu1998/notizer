<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'color',
        'default'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'user_id' => false,
        'name' => false,
        'color' => null,
        'default' => false
    ];

    /**
     * Get the user that owns the note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The notes that belong to the tag.
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
