<?php

namespace App\Repositories;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository extends GeneralRepository
{
    public function __construct(
        protected User $model
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
                // $qb = $this->search($qb, $query);
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
     * @param Request $model
     *
     * @return \App\Models\User
     */
    public function create(Request $model)
    {
        $entity = new User();
        $entity->name = $model->name;
        $entity->email = $model->email;
        $entity->password = $model->password;
        $entity->save();
        return $entity;
    }

    /**
     * @param int $id
     * @param Request $model
     */
    public function update($id, Request $model)
    {
        $model = $this->model->find($id);
        $model->name = $model['name'];
        $model->email = $model['email'];
        $model->password = bcrypt($model['password']);
        return $model->save();
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
