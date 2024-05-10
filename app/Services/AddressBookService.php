<?php

namespace App\Services;

use App\Repositories\AddressBookRepository;
use App\Results\ErrorCollection;
use App\Results\GeneralResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressBookService
{
    public function __construct(
        private AddressBookRepository $addressBookRepository
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
            $data = $this->addressBookRepository->findAll($perPage, $query);

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
            $data = $this->addressBookRepository->find($id) ?? [];

            $result->setData($data);

            return $result;
        } catch (\Throwable $th) {
            $result->addError(new ErrorCollection($th->getCode(), $th->getMessage(), 'internal_server_error'));

            return $result;
        }
    }

    /**
     * @param array $data
     */
    public function create($data)
    {
        $result = new GeneralResult();

        DB::beginTransaction();
        try {
            $create = $this->addressBookRepository->create($data);

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
     * @param array $request
     */
    public function update($id, $data)
    {
        $result = new GeneralResult();

        DB::beginTransaction();
        try {
            $update = $this->addressBookRepository->update($id, $data);

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
            $update = $this->addressBookRepository->delete($id);

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
     * @param $file
     */
    public function import($file)
    {
        $result = new GeneralResult();

        DB::beginTransaction();
        try {

            // validate csv
            if ($file->getClientOriginalExtension() !== 'csv') {
                throw new \Exception('File must be CSV', 400);
            }

            $csv= file_get_contents($file);
            $importData = array_map("str_getcsv", explode("\n", $csv));
            $importedData = [];

            if (count($importData) > 0) {
                foreach ($importData as $key => $value) {
                    if ($key == 0) continue;

                    // check if code exists
                    $codeExists = $this->addressBookRepository->findOneBy('code', $value[0]);
                    if ($codeExists) continue;

                    $phoneNumberExists = $this->addressBookRepository->findOneBy('phone_number', $value[3]);
                    if ($phoneNumberExists) continue;

                    $model = [];
                    $model['code'] = $value[0];
                    $model['name'] = $value[1];
                    $model['address'] = $value[2];
                    $model['phone_number'] = $value[3];
                    $model['status'] = $value[4];
                    $model['description'] = $value[5];

                    $importedData[] = $this->addressBookRepository->create($model);
                }
            }


            DB::commit();

            $result->setData($importedData);

            return $result;
        } catch (\Throwable $th) {
            DB::rollBack();

            $result->addError(new ErrorCollection($th->getCode(), $th->getMessage(), 'internal_server_error'));

            return $result;
        }
    }
}
