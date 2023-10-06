<?php

namespace App\Services;

use App\Models\Entity;
use App\Repositories\EntityRepository;
use Carbon\Carbon;

class EntityService
{
    /**
     * @var EntityRepository
     */
    private EntityRepository $entityRepository;

    public function __construct()
    {
        $this->entityRepository = new EntityRepository;
    }

    /**
     * Rearrange data for view
     *
     * @return array
     */
    public function getEntityData(): array
    {
        $entitiesData = $this->entityRepository->getEntitySelect();

        $entitiesDeletedData = $this->entityRepository->getEntityDeletedSelect();

        return [
            'entities' => $entitiesData,
            'entities_deleted' => $entitiesDeletedData
        ];
    }

    /**
     * @param  array  $data
     * @return mixed
     */
    public function createEntity(array $data): mixed
    {
        try {
            Entity::create([
                'name' => $data['entity-name'],
                'code' => $data['code'],
                'description' => $data['entity-description'],
                'address' => $data['entity-address'],
                'created_at' => Carbon::now()
            ]);

            return redirect()->back()->with('success' , 'Action was successful');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     * @return mixed
     */
    public function trashEntityById(int $id): mixed
    {
        try {
            $entity = $this->entityRepository->getEntityById($id);
            $entity->users()->update([
                'status' => 0
            ]);
            return $entity->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param  int  $id
     * @return mixed
     */
    public function restoreEntityById(int $id): mixed
    {
        try {
            $entitiesTrashed = $this->entityRepository->getEntityWithTrashedById($id);
            $entitiesTrashed->users()->restore();
            return $entitiesTrashed->restore();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @param $data
     */
    public function process($data)
    {
        try {
            if (isset($data['selected-rows-json'])) {
                $ids = json_decode($data['selected-rows-json']);

                switch ($data['form-action-select']) {
                    case 'bulk_delete':
                        foreach ($ids as $id) {
                            $this->trashEntityById($id);
                        }
                        break;
                    case 'bulk_restore':
                        foreach ($ids as $id) {
                            $this->restoreEntityById($id);
                        }
                        break;
                }
            } else {
                switch ($data['form-action-select']) {
                    case 'add_single_action':
                        if ($data['input']) {
                            return $this->createEntity($data['input']);
                        }
                        break;
                    case 'update_single_action':
                        if ($data['input']) {
                            return $this->updateEntity($data['input']);
                        }
                        break;
                }
            }
        } catch (\Exception $e) {
                dd($e->getMessage());
            }
    }

    public function updateEntity($data)
    {
        try {
            $entity = Entity::find($data['id']);

            $entity->update($data);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * @return false|string
     */
    public function getEntitiesJson(): false|string
    {
        $entities = $this->entityRepository->getEntities();

        return json_encode($entities);
    }
}
