<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                ->assertJsonCount(3);
    }

    public function test_can_create_task(): void
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task description',
            'completed' => false
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
                ->assertJson($taskData);

        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_can_get_single_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'completed' => $task->completed,
                ]);
    }

    public function test_can_update_task(): void
    {
        $task = Task::factory()->create();
        
        $updateData = [
            'title' => 'Updated Task',
            'description' => 'Updated description',
            'completed' => true
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson($updateData);

        $this->assertDatabaseHas('tasks', array_merge(['id' => $task->id], $updateData));
    }

    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_returns_404_for_nonexistent_task(): void
    {
        $response = $this->getJson('/api/tasks/999');
        $response->assertStatus(404);
    }

    public function test_validates_required_fields_on_create(): void
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title']);
    }

    public function test_validates_required_fields_on_update(): void
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks/{$task->id}", []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title']);
    }
}
