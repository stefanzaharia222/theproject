<?php

namespace App\Http\Controllers;

use App\Services\AssignmentService;

class AssignmentsController extends Controller
{
    private AssignmentService $service;

    public function __construct()
    {
        $this->service = new AssignmentService;
    }
    public function rolesList()
    {
        try {
            $data = $this->service->getData();

            if ($data) {
                return view('pages.assignments', [
                    'data' => $data['data'],
                    'data_deleted' => $data['data_deleted'],
                ]);
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
