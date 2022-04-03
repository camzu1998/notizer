<?php

namespace Tests\Feature\Authenticated;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteTest extends AuthenticatedTestCase
{
    use RefreshDatabase;

    /**
     * A note access test
     *
     * @return void
     */
    public function test_get_note()
    {
        //Trying to access the note that is not exist
        $response = $this->get('/note/99');
        $response->assertStatus(404);

        //Trying to access the note that has another user
        $another_user_note = Note::factory()->create([
            'user_id' => 99
        ]);
        $response = $this->get('/note/'.$another_user_note->id);
        $response->assertStatus(403);

        //Trying to access the note
        $note = Note::factory()->create([
            'user_id' => $this->user->id,
            'dashboard_id' => $this->dashboard->id
        ]);
        $response = $this->get('/note/'.$note->id);
        $this->assertAuthenticated();
        $response->assertStatus(200)->assertSeeText($note->name);
    }
    /**
     * A note store test
     *
     * @return void
     */
    public function test_store_note()
    {
        //Trying to store the note that has not specified required name
        $response = $this->post('/note', ['content' => 'blah blah blah']);
        $response->assertStatus(302)->assertInvalid(['name']);

        //Trying to store the valid note
        $response = $this->post('/note', ['name' => 'Valid Note', 'dashboard_id' => $this->dashboard->id]);
        $response->assertStatus(302)->assertSessionHas('status');
        $this->assertDatabaseHas('notes', [
            'user_id' => $this->user->id,
            'dashboard_id' => $this->dashboard->id,
            'name' => 'Valid Note',
        ]);
    }
    /**
     * A note update test
     *
     * @return void
     */
    public function test_update_note()
    {
        //Trying to update the note that has another user
        $another_user_note = Note::factory()->create([
            'user_id' => 99
        ]);
        $response = $this->put('/note/'.$another_user_note->id, ['name' => 'blah blah blah']);
        $response->assertStatus(403);

        //Trying to update the note that has invalid data
        $note = Note::factory()->create([
            'user_id' => $this->user->id
        ]);
        $response = $this->put('/note/'.$note->id, ['content' => 'blah blah blah']);
        $response->assertStatus(302)->assertInvalid(['name']);

        //Trying to update the valid note
        $response = $this->put('/note/'.$note->id, ['name' => 'Valid Note', 'dashboard_id' => $this->dashboard->id]);
        $response->assertStatus(302)->assertSessionHas('status');
        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'user_id' => $this->user->id,
            'dashboard_id' => $this->dashboard->id,
            'name' => 'Valid Note',
        ]);
    }
    /**
     * A note delete test
     *
     * @return void
     */
    public function test_destroy_note()
    {
        //Trying to delete the note that belongs to another user
        $another_user_note = Note::factory()->create([
            'user_id' => 99
        ]);
        $response = $this->delete('/note/'.$another_user_note->id);
        $response->assertStatus(403);

        //Trying to delete the note that is not exist
        $response = $this->delete('/note/999');
        $response->assertStatus(404);

        //Trying to delete the valid note
        $note = Note::factory()->create([
            'user_id' => $this->user->id,
            'dashboard_id' => $this->dashboard->id
        ]);
        $response = $this->delete('/note/'.$note->id);
        $response->assertStatus(302)->assertSessionHas('status');
        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
            'user_id' => $this->user->id,
            'dashboard_id' => $this->dashboard->id
        ]);
    }
}
