<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    protected $tag;

    //Prepare data
    protected function setUp(): void
    {
        parent::setUp();

        $this->tag = Tag::factory()->create();
    }

    /**
     * A note create test
     *
     * @return void
     */
    public function test_store_note()
    {
        //Creating note
        $note = Note::factory()->create();

        //Check if note is created
        $this->assertIsObject($note);
        $this->assertModelExists($note);
    }

    /**
     * A note change test
     *
     * @return void
     */
    public function test_update_note()
    {
        //Creating note
        $note = Note::factory()->create();
        //Change note data
        $note->name = 'positive test';
        $note->save();

        //Check if changed note is in database
        $this->assertDatabaseHas('notes', [
            'name' => 'positive test',
        ]);
    }

    /**
     * A delete note test
     *
     * @return void
     */
    public function test_delete_note()
    {
        //Creating note
        $note = Note::factory()->hasTags(1, [
            'tag_id' => $this->tag->id,
        ])->create();
        //Delete note
        $note->delete();

        //Check if note is deleted
        $this->assertModelMissing($note);
        //Check if note tag is deleted
        $this->assertDatabaseMissing('note_tags', [
            'note_id' => $note->id,
            'tag_id' => $this->tag->id,
        ]);
    }
}
