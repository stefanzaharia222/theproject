<?php

namespace App\Http\Controllers;

use App\Services\ModalService;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    private ModalService $modalService;

    public function __construct()
    {
        $this->modalService = new ModalService;
    }

    public function getModalContent(Request $request)
    {
        $inputs = $request->all();

        return view('pages.partials.tabs.parts.modalContent', [
            'data' => $inputs['data'],
            'type-form' => $inputs['type-form']
        ]);
    }

    public function updateRecord(Request $request)
    {
        try {
            $formController = new FormController();
            parse_str($request['input'], $resultArray);
            $request['input'] = $resultArray;

            return $formController->formProcess($request);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
