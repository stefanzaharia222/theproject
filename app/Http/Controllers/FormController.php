<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;

class FormController extends Controller
{
    /**
     * That method execute the right class for each situation of writing data
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function formProcess(Request $request): RedirectResponse
    {
        try {
            $data = $request->all();

            // The make method accepts the name of the class or interface you wish to resolve: $api = $this->app->make('HelpSpot\API');
            $service = app()->make($this->getServiceClass($data['type-form']));

            // Process is executing that class
            $test = $service->process($data);

            if (isset($data['ajax-request'])) {
                return $test;
            }
        } catch (\Exception $e) {
            Log::info('Error in formProcessing ', [
                'Error massage' => $e->getMessage()
            ]);
            return back()->withInput(['status' => 'failed']);
        }

        return back()->withInput(['status' => 'success']);
    }

    /**
     * That class return a string with the name of the class should be used based on $formType
     *
     * @param  string  $formType
     * @return string
     */
    private function getServiceClass(string $formType): string
    {
        $serviceNamespace = 'App\Services\\';
        $serviceSuffix = 'Service';

        // Map form types to corresponding service classes
        $services = [
            'fields' => 'Field',
            'users' => 'User',
            'entities' => 'Entity',
            'tickets' => 'Ticket',
            'tasks' => 'Task',
            'status' => 'Status',
            'process' => 'Process',
            'automations' => 'Automation',
            'groups' => 'Group',
            'roles' => 'Assignment',
            'profiles' => 'Profile',
        ];

        // Check if a corresponding service class exists for the form type
        if (isset($services[$formType])) {
            $serviceClass = $services[$formType];

            return $serviceNamespace.$serviceClass.$serviceSuffix;
        }

        // Return a default service class or handle unsupported form types
        return $serviceNamespace.'Default'.$serviceSuffix;
    }
}
