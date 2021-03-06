<?php

namespace Wulove52\HelloWord;

use \Psr\Http\Message\ResponseInterface;
use Wulove52\HelloWord\Request\AbstractRequest;

class Response
{

    /**
     * 原响应实例
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var AbstractRequest
     */
    protected $request;

    /**
     * 响应内容
     * @var array
     */
    protected $content;

    /**
     * 原始影响内容
     * @var string
     */
    protected $original;

    /**
     * 响应的数据
     * @var array|string|bool|mixed
     */
    protected $data;

    /**
     * 是否成功
     * @var bool
     */
    protected $success = false;

    /**
     * 错误消息
     * @var string|null
     */
    protected $error;

    /**
     * 错误消息
     * @var string|null
     */
    protected $errors;

    /**
     * 错误代码
     * @var string|null
     */
    protected $errorCode;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     * @param AbstractRequest $request
     */
    public function __construct(ResponseInterface $response, AbstractRequest $request)
    {
        $this->response = $response;

        $this->request = $request;

        $this->original = $response->getBody()->getContents();

        $this->content = json_decode($this->original, true);

        if (array_key_exists('Code', $this->content) && $this->content['Code'] == 'OK')  {
            $this->success = true;
            $this->data = json_encode($this->content,true);

        }elseif (array_key_exists('Code', $this->content)) {
            $this->errorCode = $this->content['Code'];
            $this->error = $this->content['Message'];
            $this->errors = $this->content;
        }

    }

    /**
     * 返回原响应实例
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * 是否成功
     * @return bool
     */
    public function success()
    {
        return $this->success;
    }

    /**
     * 是否失败
     * @return bool
     */
    public function fail()
    {
        return !$this->success();
    }

    /**
     * 返回响应内容
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 返回原始响应内容
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * 返回响应数据
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 返回错误消息
     * @return null|string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 返回错误消息
     * @return null|string
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * 返回错误代码
     * @return null|string
     */
    public function getErrorCode()
    {

        return $this->errorCode;
    }

    /**
     * 返回请求实例
     * @return AbstractRequest
     */
    public function getRequest()
    {
        return $this->request;
    }
}
