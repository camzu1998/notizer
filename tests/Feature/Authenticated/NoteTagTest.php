<?php

namespace Tests\Feature\Authenticated;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteTagTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    protected $note;
    protected $tag;

    //Prepare data
    protected function setUp(): void
    {
        parent::setUp();

        $this->note = $this->user->notes()->create();
        $this->tag = $this->user->tags()->create();
    }

    /**
     * A note tag store test
     *
     * @return void
     */
    public function test_store_note_tag()
    {
        //Trying to store the note tag that has not specified required tags
        $response = $this->post('/note_tag/'.$this->note->id, []);
        $response->assertStatus(302)->assertInvalid(['tags']);

        //Trying to store the valid note tag
        $response = $this->post('/note_tag/'.$this->note->id, ['tags' => $this->tag->id]);
        $response->assertStatus(302)->assertInvalid(['tags']);

        //Trying to store the valid note tags array
        $another_tag = $this->user->tags()-create();
        $response = $this->post('/note_tag/'.$this->note->id, [
            'tags' => [
                $this->tag->id,
                $another_tag->id,
            ]
        ]);
        $response->assertStatus(302)->assertInvalid(['tags']);

        $this->assertDatabaseHas('note_tags', [
            'note_id' => $this->note->id,
            'tag_id' => $this->tag->id,
        ]);
        $this->assertDatabaseHas('note_tags', [
            'note_id' => $this->note->id,
            'tag_id' => $another_tag->id,
        ]);
    }
}
