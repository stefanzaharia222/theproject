<?php

namespace App\Services;

use App\Repositories\SelectOptionRepository;

class SelectOptionService
{
    /**
     * @var SelectOptionRepository
     */
    protected SelectOptionRepository $selectOptionRepository;

    public function __construct()
    {
        $this->selectOptionRepository = new SelectOptionRepository;
    }

    /**
     * List all Select Options of Field Kinds
     */
    public function getSOField()
    {
        return $this->selectOptionRepository->listSOField();
    }

    public function getSOStatus()
    {
        return $this->selectOptionRepository->listSOStatus();
    }
}