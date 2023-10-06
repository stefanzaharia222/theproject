<?php

namespace App\Http\Controllers;

use App\Services\FieldService;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private TaskService $taskSerrvice;
    private FieldService $fieldService;

    public function __construct()
    {
        $this->taskSerrvice = new TaskService;
        $this->fieldService = new FieldService();
    }

    public function tasksList()
    {
        $fields = [];

        $taskData = $this->taskSerrvice->getTaskData();

        if (Auth::user()->hasRole('admin')) {
            // @TODO - allow to see only owned data of the entity!
            $fields = $this->fieldService->getFieldData();
        }
        if (Auth::user()->hasRole('super-admin')) {
            $fields = $this->fieldService->getFieldData();
        }

        return view('pages.tasks', [
            'tasks' => $taskData['tasks'],
            'tasks_deleted' => $taskData['tasks_deleted'],
            'fields' => $fields
        ]);
    }
}
