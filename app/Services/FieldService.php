<?php

namespace App\Services;

use App\Models\Field;
use App\Repositories\FieldRepository;
use Illuminate\Support\Facades\Auth;

class FieldService
{
    protected FieldRepository $fieldRepository;

    public function __construct()
    {
        $this->fieldRepository = new FieldRepository;
    }

    /**
     * Rearrange data for view
     *
     * @return array
     */
    public function getFieldData(): array
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $fieldsData = $this->fieldRepository->getOwnedFieldSelect();

            $fieldsDeletedData = $this->fieldRepository->getOwnedFieldDeletedSelect();
        } else {
            if ($user->hasRole('super-admin')) {
                $fieldsData = $this->fieldRepository->getFieldSelect();

                $fieldsDeletedData = $this->fieldRepository->getFieldDeletedSelect();
            }
        }

        return [
            'fields' => $fieldsData,
            'fields_deleted' => $fieldsDeletedData
        ];
    }

    public function getFieldEntityData()
    {
        $fields = $this->fieldRepository->getFieldEntity();
        $fieldsData = array_map('array_values', $fields->toArray());

        return $fieldsData;
    }

    /**
     * @param  array  $data
     */
    public function createField(array $data)
    {
        try {
            $user = Auth::user();
            $entityName = '';

            if (!$user->hasRole('super-admin')) {
                // get the name of the entity the user logged in is
                if (isset($user->entity()->first()->name)) {
                    $entityName = str_replace(' ', '_', $user->entity()->first()->name)  . '_';
                }
            }

            // Check the role
            if ($user->hasRole('super-admin')) {
                $className = 'standard';
            } else {
                $className = 'custom';
            }

            $languages = [];

            foreach ($data['language'] as $lang => $values) {
                foreach ($values as $name => $value) {
                    $value = array_filter($value, function ($value) {
                        return $value !== null;
                    });

                    $languages[$lang][$name] = reset($value);
                }
            }

            $orderLang = [];

            foreach ($languages as $key => $value) {
                if ($key == 'us' || $key == 'gb') $key = 'en';
                foreach ($value as $subKey => $subValue) {
                    if (!isset($orderLang[$subKey])) {
                        $orderLang[$subKey] = [];
                    }
                    $orderLang[$subKey][$key] = $subValue;
                }
            }

            $translations = [];

            foreach ($orderLang as $key => $value) {
                if (is_array($value)) {
                    // If the value is an array, extract the keys and merge them into $keyNames
                    $translations = array_merge($translations, array_keys($value));
                }
            }
            // Remove duplicate key names
            $translations = array_unique($translations);

            // Convert the array of key names into a single string
            $translationsString = implode(", ", $translations);

            $user->fields()->create([
                'type' => $className,
                'class' => $data['class-field'],
                'code' => $data['code'],
                'name' => json_encode($orderLang['name']),
                'description' => json_encode($orderLang['description']),
                'placeholder' => json_encode($orderLang['placeholder']),
                'tooltip' => json_encode($orderLang['tooltip']),
                'language' => $translationsString,
                'tag' => $className . '_' . $entityName . $data['code'],
            ]);

            return redirect()->back()->with('success', 'Action was successful');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('failed', 'Action was failed.');
        }
    }

    /**
     * @param  int  $id
     */
    public function trashFieldById(int $id)
    {
        if (Auth::user()->hasRole('super-admin')) {
            return $this->fieldRepository->getFieldById($id)->delete();
        } else {
            // Should delete only owned fields
            if (!empty($this->fieldRepository->getFieldsByEntityId($id))) {
                return $this->fieldRepository->getFieldsByEntityId($id)->delete();
            } else {
                return redirect()->back()->with('failed', "You can't delete others fields!");
            }
        }
    }

    /**
     * @param  int  $id
     */
    public function restoreFieldById(int $id)
    {
        if (Auth::user()->hasRole('super-admin')) {
            return $this->fieldRepository->getFieldById($id)->restore();
        } else {
            // Should delete only owned fields
            if (!empty($this->fieldRepository->getDeletedFieldsByEntityId($id))) {
                return $this->fieldRepository->getDeletedFieldsByEntityId($id)->restore();
            } else {
                return redirect()->back()->with('failed', "You can't delete others fields!");
            }
        }
    }

    /**
     * Add single or multiple rows
     *
     */
    public function process($data)
    {
        try {
            if (isset($data['selected-rows-json'])) {
                $ids = json_decode($data['selected-rows-json']);

                switch ($data['form-action-select']) {
                    case 'bulk_delete':
                        foreach ($ids as $id) {
                            $this->trashFieldById($id);
                        }
                        break;
                    case 'bulk_restore':
                        foreach ($ids as $id) {
                            $this->restoreFieldById($id);
                        }
                        break;
                }
            } else {
                switch ($data['form-action-select']) {
                    case 'add_single_action':
                        if ($data) {
                            return $this->createField($data['input']);
                        }
                        break;
                    case 'update_single_action':
                        if ($data['input']) {
                            return $this->updateField($data['input']);
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function updateField($data)
    {
        try {
            $entity = Field::find($data['id']);

            $entity->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}