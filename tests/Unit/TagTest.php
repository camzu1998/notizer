<?php

namespace Tests\Unit;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A tag create test
     *
     * @return void
     */
    public function test_store_tag()
    {
        //Creating tag
        $tag = Tag::factory()->hasNotes(1)->create();

        //Check if tag is created
        $this->assertIsObject($tag);
        $this->assertModelExists($tag);
        //Check if note tag is created
        $this->assertDatabaseHas('note_tag', [
            'tag_id' => $tag->id
        ]);
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
        $tag = Tag::factory()->hasNotes(1)->create();
        //Delete tag
        $tag->delete();

        //Check if tag is deleted
        $this->assertModelMissing($tag);
        //Check if note tag is deleted
        $this->assertDatabaseMissing('note_tag', [
            'tag_id' => $tag->id
        ]);
    }
}
