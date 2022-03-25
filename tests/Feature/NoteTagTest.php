<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $user = User::factory()->create();
        $this->note = $user->notes()->create();
        $this->tag = $user->tags()->create();
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
        $response->assertStatus(302)->assertRedirect('/');

        //Trying to store the valid note tag
        $response = $this->post('/note_tag/'.$this->note->id, ['tags' => $this->tag->id]);
        $response->assertStatus(302)->assertRedirect('/');

        $this->assertDatabaseMissing('note_tag', [
            'note_id' => $this->note->id,
            'tag_id' => $this->tag->id,
        ]);
    }

    /**
     * A note tag delete test
     *
     * @return void
     */
    public function test_destroy_note_tag()
    {
        //Trying to delete the note tag that has not in db
        $response = $this->delete('/note_tag/'.$this->note->id.'/99');
        $response->assertStatus(302)->assertRedirect('/');

        //Trying to delete valid user note tag
        $tag = $this->note->tags()->create();
        $response = $this->delete('/note_tag/'.$this->note->id.'/'.$tag->id);
        $response->assertStatus(302)->assertRedirect('/');
        $this->assertDatabaseHas('note_tag', [
            'tag_id' => $tag->id
        ]);
    }
}
