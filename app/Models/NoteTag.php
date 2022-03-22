<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteTag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'note_id',
        'tag_id',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'note_id' => false,
        'tag_id' => false,
    ];

    /**
     * Get the tag that is associated with the note.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * Get the note that is associated with the tag.
     */
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
