<?php

namespace Tests\Feature\Authenticated;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

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

        //Trying to store note tag using another user tag
        $another_user_tag = Tag::factory()->create([
            'user_id' => 99
        ]);
        $response = $this->post('/note_tag/'.$this->note->id, ['tags' => $another_user_tag->id]);
        $response->assertStatus(302)->assertSessionHas('status');
        $this->assertDatabaseMissing('note_tag', [
            'tag_id' => $another_user_tag->id
        ]);

        //Trying to store the valid note tag
        $response = $this->post('/note_tag/'.$this->note->id, ['tags' => $this->tag->id]);
        $response->assertStatus(302)->assertSessionHas('status');

        //Trying to store the valid note tags array
        $another_tag = $this->user->tags()->create();
        $response = $this->post('/note_tag/'.$this->note->id, [
            'tags' => [
                $this->tag->id,
                $another_tag->id,
            ]
        ]);
        $response->assertStatus(302)->assertSessionHas('status');

        $this->assertDatabaseHas('note_tag', [
            'note_id' => $this->note->id,
            'tag_id' => $this->tag->id,
        ]);
        $this->assertDatabaseHas('note_tag', [
            'note_id' => $this->note->id,
            'tag_id' => $another_tag->id,
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
        $response->assertStatus(404);

        //Trying to delete another user note tag
        $another_user_tag = Tag::factory()->hasNotes(1, ['user_id' => 99])->create(['user_id' => 99]);
        $another_user_note = $another_user_tag->notes()->first();
        $response = $this->delete('/note_tag/'.$another_user_note->id.'/'.$another_user_tag->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('note_tag', [
            'tag_id' => $another_user_tag->id
        ]);

        //Trying to delete valid user note tag
        $tag = $this->note->tags()->create();
        $response = $this->delete('/note_tag/'.$this->note->id.'/'.$tag->id);
        $response->assertStatus(302);
        $this->assertDatabaseMissing('note_tag', [
            'tag_id' => $tag->id
        ]);
    }
}
