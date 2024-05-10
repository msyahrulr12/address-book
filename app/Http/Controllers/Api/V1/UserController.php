<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\LogApi;
use App\Services\ValidatorService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function __construct(
        private UserService $userService,
        private string $title = "User"
    )
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $logApi = new LogApi();
        $logApi->api_name = LogApi::API_USER_LIST;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $query = $request->query->all();
        $perPage = $request->get('per_page') ?? 10;
        $result = $this->userService->findAll($perPage, $query);
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
        $logApi->api_name = LogApi::API_USER_CREATE;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $validateResult = ValidatorService::validate($request, [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|'.sprintf('required|unique:users,email,%d', $request->email),
            'password' => 'required|min:8',
        ]);
        if (count($validateResult->getErrors()) > 0) {
            return $this->responseFailed($validateResult->getErrorsArray());
        }

        $result = $this->userService->create($request);
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
        $logApi->api_name = LogApi::API_USER_SHOW;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $result = $this->userService->find($id);
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
        $logApi->api_name = LogApi::API_USER_UPDATE;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $validateResult = ValidatorService::validate($request, [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|'.sprintf('required|unique:users,email,%d', $id),
            'password' => 'min:8',
        ]);
        if (count($validateResult->getErrors()) > 0) {
            return $this->responseFailed($validateResult->getErrorsArray());
        }

        $result = $this->userService->update($id, $request);
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
        $logApi->api_name = LogApi::API_USER_DELETE;
        $logApi->url = url()->current();
        $logApi->queries = json_encode($request->query->all());
        $logApi->headers = json_encode($request->headers->all());
        $logApi->request_body = json_encode($request->request->all());
        $logApi->request_datetime = new \DateTime();

        $result = $this->userService->delete($id);
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
