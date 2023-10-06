<?php

namespace App\Http\Controllers;

use App\Services\AutomationService;

class AutomationsController extends Controller
{
    private AutomationService $service;

    public function __construct()
    {
        $this->service = new AutomationService;
    }
    public function automationsList()
    {
        try {
            $data = $this->service->getData();

            if ($data) {
                return view('pages.automations', [
                    'data' => $data['data'],
                    'data_deleted' => $data['data_deleted'],
                ]);
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
