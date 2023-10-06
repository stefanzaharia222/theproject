<?php

namespace App\Http\Controllers;

use App\Services\ProcessService;

class ProcessController extends Controller
{
    private ProcessService $fieldService;

    public function __construct()
    {
        $this->fieldService = new ProcessService;
    }

    public function processList()
    {
        try {
            $process = $this->fieldService->getProcessData();

            return view('pages.process', [
                'process' => $process['process'],
                'process_deleted' => $process['process_deleted'],
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
