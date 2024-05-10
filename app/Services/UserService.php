<?php

namespace App\Services;

use App\Http\Requests\UserCreateRequest;
use App\Repositories\UserRepository;
use App\Results\ErrorCollection;
use App\Results\GeneralResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    )
    {

    }

    /**
     * @param null|int $perPage
     * @param array $query
     *
     * @return \App\Results\GeneralResult
     */
    public function findAll($perPage = null, $query = [])
    {
        $result = new GeneralResult();

        try {
            $data = $this->userRepository->findAll($perPage, $query);

            $result->setData($data);

            return $result;
        } catch (\Throwable $th) {
            $result->addError(new ErrorCollection($th->getCode(), $th->getMessage(), 'internal_server_error'));

            return $result;
        }
    }

    /**
     * @param int $id
     *
     * @return \App\Results\GeneralResult
     */
    public function find($id)
    {
        $result = new GeneralResult();

        try {
            $data = $this->userRepository->find($id) ?? [];

            $result->setData($data);

            return $result;
        } catch (\Throwable $th) {
            $result->addError(new ErrorCollection($th->getCode(), $th->getMessage(), 'internal_server_error'));

            return $result;
        }
    }

    public function create(Request $request)
    {
        $result = new GeneralResult();

        DB::beginTransaction();
        try {
            $request['password'] = bcrypt($request['password']);
            $create = $this->userRepository->create($request);

            DB::commit();

            $result->setData($create);

            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();

            $result->addError(new ErrorCollection($th->getCode(), $th->getMessage(), 'internal_server_error'));

            return $result;
        }
    }

    /**
     * @param int $id
     * @param Request $request
     */
    public function update($id, Request $request)
    {
        $result = new GeneralResult();

        DB::beginTransaction();
        try {

            if (isset($request['password']) && $request['password']) {
                $request['password'] = bcrypt($request['password']);
            }

            $update = $this->userRepository->update($id, $request);

            DB::commit();

            $result->setData($update);

            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();

            $result->addError(new ErrorCollection($th->getCode(), $th->getMessage(), 'internal_server_error'));

            return $result;
        }
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $result = new GeneralResult();

        DB::beginTransaction();
        try {
            $update = $this->userRepository->delete($id);

            DB::commit();

            $result->setData($update);

            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();

            $result->addError(new ErrorCollection($th->getCode(), $th->getMessage(), 'internal_server_error'));

            return $result;
        }
    }
}
