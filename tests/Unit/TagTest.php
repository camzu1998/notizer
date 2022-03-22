<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    //Prepare data
    protected function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create();
    }

    /**
     * A tag create test
     *
     * @return void
     */
    public function test_store_tag()
    {
        //Creating tag
        $tag = Tag::factory()->create();

        //Check if tag is created
        $this->assertIsObject($tag);
        $this->assertModelExists($tag);
    }

    /**
     * A tag change test
     *
     * @return void
     */
    public function test_update_tag()
    {
        //Creating tag
        $tag = Tag::factory()->create();
        //Change tag data
        $tag->name = 'positive test';
        $tag->save();

        //Check if changed tag is in database
        $this->assertDatabaseHas('tags', [
            'name' => 'positive test',
        ]);
    }

    /**
     * A delete tag test
     *
     * @return void
     */
    public function test_delete_tag()
    {
        //Creating tag
        $tag = Tag::factory()->hasNotes(1, [
            'note_id' => $this->note->id
        ])->create();
        //Delete tag
        $tag->delete();

        //Check if tag is deleted
        $this->assertModelMissing($tag);
        //Check if note tag is deleted
        $this->assertDatabaseMissing('note_tags', [
            'tag_id' => $tag->id,
            'note_id' => $this->note->id
        ]);
    }
}
