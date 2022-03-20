<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A tag access test
     *
     * @return void
     */
    public function test_get_tag()
    {
        //Trying to access the tag that is not exist
        $response = $this->get('/tag/99');
        $response->assertStatus(302)->assertRedirect('/');

        //Trying to access the tag
        $tag = Tag::factory()->create();
        $response = $this->get('/tag/'.$tag->id);
        $response->assertStatus(302)->assertRedirect('/');
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
        $response->assertStatus(302)->assertRedirect('/');

        //Trying to store the valid tag
        $response = $this->post('/tag', ['name' => 'Valid tag']);
        $response->assertStatus(302)->assertRedirect('/');
        $this->assertDatabaseMissing('tags', [
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
        //Trying to update the note that has invalid data
        $tag = Tag::factory()->create();
        $response = $this->put('/tag/'.$tag->id, ['color' => '#002244']);
        $response->assertStatus(302)->assertRedirect('/');

        //Trying to update the valid note
        $response = $this->put('/tag/'.$tag->id, ['name' => 'Valid tag']);
        $response->assertStatus(302)->assertRedirect('/');
        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
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
        //Trying to delete the tag that is not exist
        $response = $this->delete('/tag/999');
        $response->assertStatus(302)->assertRedirect('/');

        //Trying to delete the valid tag
        $note = Tag::factory()->create();
        $response = $this->delete('/tag/'.$note->id);
        $response->assertStatus(302)->assertRedirect('/');
        $this->assertDatabaseHas('tags', [
            'id' => $note->id
        ]);
    }
}
