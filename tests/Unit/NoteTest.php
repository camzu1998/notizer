<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A note create test
     *
     * @return void
     */
    public function test_store_note()
    {
        //Creating note
        $note = Note::factory()->hasTags(1)->create();

        //Check if note is created
        $this->assertIsObject($note);
        $this->assertModelExists($note);
        //Check if note tag is created
        $this->assertDatabaseHas('note_tag', [
            'note_id' => $note->id
        ]);
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
        $note = Note::factory()->hasTags(1)->create();
        //Delete note
        $note->delete();

        //Check if note is deleted
        $this->assertModelMissing($note);
        //Check if note tag is deleted
        $this->assertDatabaseMissing('note_tag', [
            'note_id' => $note->id
        ]);
    }
}
