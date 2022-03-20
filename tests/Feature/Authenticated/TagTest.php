<?php

namespace Tests\Feature\Authenticated;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class TagTest extends AuthenticatedTestCase
{
//    use RefreshDatabase;

    /**
     * A tag access test
     *
     * @return void
     */
    public function test_get_tag()
    {
        //Trying to access the tag that is not exist
        $response = $this->get('/tag/99');
        $response->assertStatus(404);

        //Trying to access the tag that has another user
        $another_user_tag = Tag::factory()->create([
            'user_id' => 99
        ]);
        $response = $this->get('/tag/'.$another_user_tag->id);
        $response->assertStatus(403);

        //Trying to access the tag
        $tag = Tag::factory()->create([
            'user_id' => $this->user->id
        ]);
        $response = $this->get('/tag/'.$tag->id);
        $this->assertAuthenticated();
        $response->assertStatus(200)->assertSeeText($tag->name);
    }
    /**
     * A tag store test
     *
     * @return void
     */
    public function test_store_tag()
    {
        //Trying to store the tag that has not specified required name
        $response = $this->post('/tag', ['color' => '#442200']);
        $response->assertStatus(302)->assertInvalid(['name']);

        //Trying to store the valid tag
        $response = $this->post('/tag', ['name' => 'Valid tag']);
        $response->assertStatus(302)->assertSessionHas('status');
        $this->assertDatabaseHas('tags', [
            'user_id' => $this->user->id,
            'name' => 'Valid tag',
        ]);
    }
    /**
     * A tag update test
     *
     * @return void
     */
    public function test_update_tag()
    {
        //Trying to update the tag that has another user
        $another_user_tag = Tag::factory()->create([
            'user_id' => 99
        ]);
        $response = $this->put('/tag/'.$another_user_tag->id, ['name' => 'blah blah blah']);
        $response->assertStatus(403);

        //Trying to update the note that has invalid data
        $tag = Tag::factory()->create([
            'user_id' => $this->user->id
        ]);
        $response = $this->put('/tag/'.$tag->id, ['color' => '#002244']);
        $response->assertStatus(302)->assertInvalid(['name']);

        //Trying to update the valid note
        $response = $this->put('/tag/'.$tag->id, ['name' => 'Valid tag']);
        $response->assertStatus(302)->assertSessionHas('status');
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'user_id' => $this->user->id,
            'name' => 'Valid tag',
        ]);
    }
    /**
     * A tag delete test
     *
     * @return void
     */
    public function test_destroy_tag()
    {
        //Trying to delete the tag that belongs to another user
        $another_user_tag = Tag::factory()->create([
            'user_id' => 99
        ]);
        $response = $this->delete('/tag/'.$another_user_tag->id);
        $response->assertStatus(403);

        //Trying to delete the tag that is not exist
        $response = $this->delete('/tag/999');
        $response->assertStatus(404);

        //Trying to delete the valid tag
        $note = Tag::factory()->create([
            'user_id' => $this->user->id
        ]);
        $response = $this->delete('/tag/'.$note->id);
        $response->assertStatus(302)->assertSessionHas('status');
        $this->assertDatabaseMissing('tags', [
            'id' => $note->id,
            'user_id' => $this->user->id
        ]);
    }
}
