<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTagTest extends TestCase
{
    use RefreshDatabase;

    protected $note;
    protected $tag;

    //Prepare data
    protected function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create();
        $this->tag = Tag::factory()->create();
    }

    /**
     * A note tag create test
     *
     * @return void
     */
    public function test_store_note_tag()
    {
        //Creating note tag
        $note_tag = $this->note->tags()->create([
            'tag_id' => $this->tag->id,
        ]);

        //Check if note tag is created
        $this->assertIsObject($note_tag);
        $this->assertModelExists($note_tag);
    }

    /**
     * A delete note tag test
     *
     * @return void
     */
    public function test_delete_note_tag()
    {
        //Creating note tag
        $note_tag = $this->note->tags()->create([
            'tag_id' => $this->tag->id,
        ]);
        //Delete note tag
        $note_tag->delete();

        //Check if note tag is deleted
        $this->assertModelMissing($note_tag);
    }
}
