<?php

namespace Database\Seeders;

use App\Models\Entity;
use App\Models\Field;
use App\Models\Process;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(FieldsSeeder::class);
        $this->call(TicketsSeeder::class);
        $this->call(TasksSeeder::class);
        $this->call(SelectOptionSeeder::class);

        Model::withoutEvents(function () {
            $this->call(RoleAndPermissionSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(EntitySeeder::class);
            $this->call(TicketsSeeder::class);
            $this->call(StatusSeeder::class);
            $this->call(ProcessSeeder::class);

            if (env('APP_ENV') != 'production') {
                Process::factory()->afterCreating(function ($process) {
                    Status::factory()->afterCreating(function ($status) use ($process) {
                        Task::factory()->afterCreating(function ($task) use ($status, $process) {
                            Field::factory()->afterCreating(function ($field) use ($task, $status, $process) {
                                Entity::factory()->afterCreating(function ($entity) use ($field, $task, $status, $process) {
                                    User::factory()->afterCreating(function ($user) use (
                                        $entity,
                                        $field,
                                        $task,
                                        $status,
                                        $process
                                    ) {
                                        $user->assignRole(array_rand(array_flip(['admin', 'user'])));
                                        if ($user->hasRole('admin')) {
                                            $user->type = 'Admin';
                                        } else {
                                            $user->type = array_rand(array_flip(['Coordinator', 'Sales', 'Support']));
                                        }
                                        $user->save();

                                        $user->entity()->attach([$entity->id]);
                                        $user->fields()->attach([$field->id]);
                                        $user->tasks()->attach([$task->id]);
                                        $user->status()->attach([$status->id]);
                                        $user->process()->attach([$process->id]);

                                    })->count(2)->create();
                                })->count(2)->create();
                            })->count(2)->create();
                        })->count(2)->create();
                    })->count(2)->create();
                })->count(2)->create();
            }
        });
    }
}
