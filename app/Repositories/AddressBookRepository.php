<?php

namespace App\Repositories;

use App\Models\AddressBook;
use Illuminate\Http\Request;

class AddressBookRepository extends GeneralRepository
{
    public function __construct(
        protected AddressBook $model
    )
    {
    }

    /**
     * @param null|int $page
     * @param array $limit
     * @param string $orderBy
     *
     * @return mixed
     */
    public function findAll($perPage = null, $query = [], $orderBy = 'desc')
    {
        $qb = $this->model->orderBy('id', $orderBy);
        if ($query) {
            if (isset($query['search'])) {
                $qb = $this->search($qb, $query['search'], 'address_books');
            }
        }

        if ($perPage) {
            return $qb->paginate($perPage);
        }

        return $qb->get();
    }

    /**
     * @param int $id
     *
     * @return
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param string $column
     * @param string $value
     */
    public function findOneBy($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    /**
     * @param array $model
     *
     * @return \App\Models\AddressBook
     */
    public function create($model)
    {
        $entity = new AddressBook();
        $entity->code = $model['code'];
        $entity->name = $model['name'];
        $entity->address = $model['address'];
        $entity->phone_number = $model['phone_number'];
        $entity->status = $model['status'];
        $entity->description = $model['description'];
        $entity->save();
        return $entity;
    }

    /**
     * @param int $id
     * @param array $model
     */
    public function update($id, $model)
    {
        $entity = $this->model->find($id);
        if (!$entity) {
            return false;
        }

        $entity->code = $model['code'];
        $entity->name = $model['name'];
        $entity->address = $model['address'];
        $entity->phone_number = $model['phone_number'];
        $entity->status = $model['status'];
        $entity->description = $model['description'];
        $entity->save();

        return $entity;
    }

    /**
     * @return bool
     */
    public function delete($id)
    {
        $data = $this->model->find($id);
        if (!$data) {
            return false;
        }

        return $data->delete();
    }
}
