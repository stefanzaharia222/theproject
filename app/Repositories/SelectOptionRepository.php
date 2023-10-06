<?php

namespace App\Repositories;

use App\Models\SelectOption;

class SelectOptionRepository
{
    /**
     * Retrieve all Select Option of Field Kind
     * @return mixed
     */
    public function listSOField()
    {
        return SelectOption::where('option_kind', 'field')
            ->select([
                'id',
                'option_name',
                'option_kind',
                'tooltip',
                'placeholder',
                'description',
                'tag'
            ])->get();
    }

    public function listSOStatus()
    {
        return SelectOption::where('option_kind', 'status')
            ->select([
                'id',
                'option_name',
                'option_kind',
                'tooltip',
                'placeholder',
                'description',
                'tag'
            ])->get();
    }

    public function listSOTicket()
    {
        return SelectOption::where('option_kind', 'ticket');
    }

    public function listSOTask()
    {
        return SelectOption::where('option_kind', 'task');
    }
}