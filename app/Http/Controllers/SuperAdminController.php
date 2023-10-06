<?php

namespace App\Http\Controllers;

use App\Services\EntityService;

class SuperAdminController extends Controller
{
    private EntityService $entityService;

    public function __construct()
    {
        $this->entityService = new EntityService;
    }

    public function index()
    {
        return view('pages.dashboard');
    }

    public function entitiesList()
    {
        $entities = $this->entityService->getEntityData();

        return view('pages.entities', [
            'entities' => $entities['entities'],
            'entities_deleted' => $entities['entities_deleted'],
        ]);
    }

    /**
     * @return false|string
     */
    public function entitiesJson(): false|string
    {
        return $this->entityService->getEntitiesJson();
    }
}
