<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;

class ProfilesController extends Controller
{
    private ProfileService $service;

    public function __construct()
    {
        $this->service = new ProfileService();
    }
    public function list()
    {
        try {
            $data = $this->service->getData();

            if ($data) {
                return view('pages.profiles', [
                    'data' => $data['data'],
                    'data_deleted' => $data['data_deleted'],
                ]);
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }}
