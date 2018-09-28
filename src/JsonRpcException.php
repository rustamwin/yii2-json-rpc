<?php
/**
 * @link      http://www.activemedia.uz/
 * @copyright Copyright (c) 2018. ActiveMedia Solutions LLC
 * @author    Rustam Mamadaminov <rmamdaminov@gmail.com>
 */

namespace rustamwin\rpc;

use yii\base\Exception;
use yii\base\UserException;

class JsonRpcException extends Exception
{
    const JSON_RPC_ERROR_PARSE                 = -32700;
    const JSON_RPC_ERROR_REQUEST_INVALID       = -32600;
    const JSON_RPC_ERROR_METHOD_NOT_FOUND      = -32601;
    const JSON_RPC_ERROR_METHOD_PARAMS_INVALID = -32602;
    const JSON_RPC_ERROR_INTERNAL              = -32603;
    const JSON_RPC_ERROR_SERVER                = -32000;

    public $id;

    protected static $errors = [
        self::JSON_RPC_ERROR_PARSE                 => 'Parse error',
        self::JSON_RPC_ERROR_REQUEST_INVALID       => 'Invalid Request',
        self::JSON_RPC_ERROR_METHOD_NOT_FOUND      => 'Method not found',
        self::JSON_RPC_ERROR_METHOD_PARAMS_INVALID => 'Invalid params',
        self::JSON_RPC_ERROR_INTERNAL              => 'Internal error',
        self::JSON_RPC_ERROR_SERVER                => 'Server error',
    ];

    public function __construct($id, $message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->id = $id;
    }

    public function getName()
    {
        if (isset(self::$errors[$this->code])) {
            return self::$errors[$this->code];
        }
        return parent::getName();
    }

    public function renderError()
    {
        $errorArray = [
            'code'    => $this->getCode(),
            'message' => $this->getName(),
        ];
        if (YII_DEBUG) {
            $errorArray['data'] = [
                'type' => get_class($this),
            ];
            if ($this->getPrevious() !== null && !$this->getPrevious() instanceof UserException) {
                $errorArray['data'] += [
                    'message'     => $this->getPrevious()->getMessage(),
                    'file'        => $this->getPrevious()->getFile(),
                    'line'        => $this->getPrevious()->getLine(),
                    'stack-trace' => explode("\n", $this->getPrevious()->getTraceAsString()),
                ];

                if ($this->getPrevious() instanceof \yii\db\Exception) {
                    $errorArray['data']['error-info'] = $this->getPrevious()->errorInfo;
                }
            }
        }
        return $errorArray;
    }
}