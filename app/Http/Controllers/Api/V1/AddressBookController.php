<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\LogApi;
use App\Services\ValidatorService;
use App\Services\AddressBookService;
use Illuminate\Http\Request;

class AddressBookController extends BaseController
{
    public function __construct(
        private AddressBookService $addressBookService,
        private string $title = "Address Book"
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $logApi = new LogApi();
        $logApi->api_name = LogApi::API_ADDRESS_BOOK_LIST;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $query = $request->query->all();
        $perPage = $request->get('per_page') ?? 10;
        $result = $this->addressBookService->findAll($perPage, $query);
        if (count($result->getErrors()) > 0) {
            $errors = $result->getErrors();
            $message = 'Terjadi kesalahan!';

            $logApi->response_body = json_encode($errors);
            $logApi->response_datetime = new \DateTime();
            $logApi->save();

            return $this->responseFailed($errors, 400, $message);
        }

        $logApi->response_body = json_encode($result->getData());
        $logApi->response_datetime = new \DateTime();
        $logApi->save();

        return $this->responseSuccess($result->getData());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $logApi = new LogApi();
        $logApi->api_name = LogApi::API_ADDRESS_BOOK_CREATE;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $validateResult = ValidatorService::validate($request, [
            'code' => 'required|'.sprintf('required|unique:address_books,code,%d', $request->code),
            'name' => 'required|min:3',
            'address' => 'required|min:10',
            'phone_number' => 'required|min:11|max:15|'.sprintf('required|unique:address_books,phone_number,%d', $request->phone_number),
            'status' => 'required|boolean',
            'description' => '',
        ]);
        if (count($validateResult->getErrors()) > 0) {
            return $this->responseFailed($validateResult->getErrorsArray());
        }

        $result = $this->addressBookService->create($validateResult->getData());
        if (count($result->getErrors()) > 0) {
            $errors = $result->getErrors();
            $message = 'Terjadi kesalahan!';

            $logApi->response_body = json_encode($errors);
            $logApi->response_datetime = new \DateTime();
            $logApi->save();

            return $this->responseFailed($errors, 400, $message);
        }

        $logApi->response_body = json_encode($result->getData());
        $logApi->response_datetime = new \DateTime();
        $logApi->save();

        return $this->responseSuccess($result->getData());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $logApi = new LogApi();
        $logApi->api_name = LogApi::API_ADDRESS_BOOK_SHOW;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $result = $this->addressBookService->find($id);
        if (count($result->getErrors()) > 0) {
            $errors = $result->getErrors();
            $message = 'Terjadi kesalahan!';

            $logApi->response_body = json_encode($errors);
            $logApi->response_datetime = new \DateTime();
            $logApi->save();

            return $this->responseFailed($errors, 400, $message);
        }

        $logApi->response_body = json_encode($result->getData());
        $logApi->response_datetime = new \DateTime();
        $logApi->save();

        return $this->responseSuccess($result->getData());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $logApi = new LogApi();
        $logApi->api_name = LogApi::API_ADDRESS_BOOK_UPDATE;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $validateResult = ValidatorService::validate($request, [
            'code' => 'required|'.sprintf('required|unique:address_books,code,%d', $id),
            'name' => 'required|min:3',
            'address' => 'required|min:10',
            'phone_number' => 'required|min:11|max:15|'.sprintf('required|unique:address_books,phone_number,%d', $id),
            'status' => 'required|boolean',
            'description' => '',
        ]);
        if (count($validateResult->getErrors()) > 0) {
            return $this->responseFailed($validateResult->getErrorsArray());
        }

        $result = $this->addressBookService->update($id, $validateResult->getData());
        if (count($result->getErrors()) > 0) {
            $errors = $result->getErrors();
            $message = 'Terjadi kesalahan!';

            $logApi->response_body = json_encode($errors);
            $logApi->response_datetime = new \DateTime();
            $logApi->save();

            return $this->responseFailed($errors, 400, $message);
        }

        $logApi->response_body = json_encode($result->getData());
        $logApi->response_datetime = new \DateTime();
        $logApi->save();

        return $this->responseSuccess($result->getData());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $logApi = new LogApi();
        $logApi->api_name = LogApi::API_ADDRESS_BOOK_DELETE;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $result = $this->addressBookService->delete($id);
        if (count($result->getErrors()) > 0) {
            $errors = $result->getErrors();
            $message = 'Terjadi kesalahan!';

            $logApi->response_body = json_encode($errors);
            $logApi->response_datetime = new \DateTime();
            $logApi->save();

            return $this->responseFailed($errors, 400, $message);
        }

        $logApi->response_body = json_encode($result->getData());
        $logApi->response_datetime = new \DateTime();
        $logApi->save();

        return $this->responseSuccess($result->getData());
    }

    /**
     * @param Request $request
     */
    public function import(Request $request)
    {
        $logApi = new LogApi();
        $logApi->api_name = LogApi::API_ADDRESS_BOOK_IMPORT;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $validateResult = ValidatorService::validate($request, [
            'file' => 'required|max:2048'
        ]);
        if (count($validateResult->getErrors()) > 0) {
            return $this->responseFailed($validateResult->getErrorsArray());
        }

        $file = $request->files->get('file');
        $result = $this->addressBookService->import($file);
        if (count($result->getErrors()) > 0) {
            $errors = $result->getErrors();
            $message = 'Terjadi kesalahan!';

            $logApi->response_body = json_encode($errors);
            $logApi->response_datetime = new \DateTime();
            $logApi->save();

            return $this->responseFailed($errors, 400, $message);
        }

        $logApi->response_body = json_encode($result->getData());
        $logApi->response_datetime = new \DateTime();
        $logApi->save();

        return $this->responseSuccess($result->getData());
    }
}
