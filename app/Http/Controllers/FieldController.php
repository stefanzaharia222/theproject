<?php

namespace App\Http\Controllers;

use App\Services\FieldService;
use App\Services\SelectOptionService;

class FieldController extends Controller
{
    private FieldService $fieldService;
    private SelectOptionService $selectOption;

    public function __construct()
    {
        $this->fieldService = new FieldService;
        $this->selectOption = new SelectOptionService;
    }

    public function fieldsList()
    {
        try {
            $fields = $this->fieldService->getFieldData();
            $fieldSelectOption = $this->selectOption->getSOField();

            return view('pages.fields', [
                'fields' => $fields['fields'],
                'fields_deleted' => $fields['fields_deleted'],
                'select_option' => $fieldSelectOption,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }
}
