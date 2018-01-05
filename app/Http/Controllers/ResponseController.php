<?php namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;

class ResponseController extends Controller
{
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Record not found response
     *
     * @param string $message
     * @return mixed
     */
    public function responseNotFound($message = 'RECORD_NOT_FOUND')
    {
        return $this->responseWithError($message);
    }

    /**
     * Invalid Token Response
     *
     * @param string $message
     * @return mixed
     */
    public function responseInvalidToken($message = 'INVALID_TOKEN')
    {
        return $this->responseWithError($message);
    }

    /**
     * General code error response
     * @param string $message
     * @return mixed
     */
    public function responseCodeError($message = 'CODE_ERROR')
    {
        return $this->responseWithError($message);
    }

    /**
     * General error response
     *
     * @param $message
     * @return mixed
     */
    public function responseWithError($message)
    {
        return $this->response([
            'status' => 'KO',
            'result' => $message,
        ]);
    }


    /**
     * General success response
     *
     * @param $message
     * @return mixed
     */
    public function responseWithSuccess($message)
    {
        return $this->response([
            'status' => 'OK',
            'message' => $message,
        ]);
    }
    /**
     * General respond
     *
     * @param       $data
     * @param array $headers
     * @return mixed
     */
    public function response($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }
}