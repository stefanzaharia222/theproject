<?php

namespace App\Http\Controllers;

use App\Services\GroupService;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    private GroupService $service;

    public function __construct()
    {
        $this->service = new GroupService();
    }
    public function groupsList()
    {
        try {
            $data = $this->service->getData();

            if ($data) {
                return view('pages.groups', [
                    'data' => $data['data'],
                    'data_deleted' => $data['data_deleted'],
                ]);
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
