<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/14
 * Time: 11:42
 */

namespace BlankPhp\Response;


use BlankPhp\Response\Traits\ResponseType;

class Response
{
    use  ResponseType;

    protected $result = '';


    protected $headerStack = [];


    public function __construct($result)
    {
        $this->result = (string)$result;
        if ($this->isJson($this->result)) {
            $this->setType(self::$header['json']);
        } else {
            $this->setType(self::$header['html']);
        }
        dump($this->headerStack);
    }


    /**
     * @return array
     */
    public function getHeaderStack()
    {
        return $this->headerStack;
    }

    /**
     * @param array $headerStack
     * @param null $key
     */
    public function setHeaderStack($headerStack, $key = null): void
    {
        if (empty($key)) {
            $this->headerStack[] = $headerStack;
        } else {
            $this->headerStack[$key] = $headerStack;
        }
    }


    public function setHeader(): void
    {
        foreach ($this->getHeaderStack() as $item) {
            header($item);
        }
    }

    public function header($item): Response
    {
        if (is_numeric($item)) {
            header(self::$httpStatus[$item]);
        } elseif (in_array($item, self::$header, true)) {
            header($item);
        }
        return $this;
    }

    public function setContent($value): void
    {
        if ($value === null) {
            return;
        }
        if (is_array($value)) {
            $this->result = json_encode($value);
            return;
        }
        $this->result = (string)$value;
    }

    public function send(): void
    {
        $this->setHeader();
        ob_start();
        echo $this->result;
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }else if(1){
            ob_end_flush();
        }
    }

    public function prepare(): Response
    {
        return $this;
    }

    public function isJson($string): bool
    {
        return strpos($string, '{') === 0;
    }


    public function returnSend(): string
    {
        return $this->result;
    }

}