<?php

namespace App\Repositories;

use App\Models\AuditTrail;

class AuditTrailRepository extends GeneralRepository
{
    public function __construct(
        private AuditTrail $model
    )
    {
    }

    /**
     * @param null|int $perPage
     * @param array $query
     *
     * @return object
     */
    public function getAll($perPage = null, $query = [], $order = 'desc')
    {
        $qb = $this->model->orderBy('id', $order);
        if ($query) {
            if (isset($query['search'])) {
                // $qb = $this->search($qb, $query);
            }
        }

        $qb = $qb->orderBy('id', 'desc');

        if ($perPage) {
            return $qb->paginate($perPage);
        }

        return $qb->get();
    }

    /**
     * @param int $id
     *
     * @return object
     */
    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $data
     *
     * @return object
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return array
     */
    public function update(int $id, array $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function delete(int $id): bool
    {
        return $this->model->findOrFail($id)->delete($id);
    }
}
