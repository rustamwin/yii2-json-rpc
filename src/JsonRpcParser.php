<?php
/**
 * @link      http://www.activemedia.uz/
 * @copyright Copyright (c) 2018. ActiveMedia Solutions LLC
 * @author    Rustam Mamadaminov <rmamdaminov@gmail.com>
 */

namespace rustamwin\rpc;


use yii\base\ErrorException;
use yii\base\InvalidArgumentException;
use yii\base\InvalidParamException;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\RequestParserInterface;

class JsonRpcParser implements RequestParserInterface
{

    public $asArray = true;


    /**
     * Parses a HTTP request body.
     * @param string $rawBody     the raw HTTP request body.
     * @param string $contentType the content type specified for the request body.
     * @return array parameters parsed from the request body
     * @throws JsonRpcException
     */
    public function parse($rawBody, $contentType)
    {
        try {
            $parameters = Json::decode($rawBody, $this->asArray);

            return $parameters === null ? [] : $parameters;
        } catch (InvalidArgumentException $e) {
            throw new JsonRpcException(null, "", JsonRpcException::JSON_RPC_ERROR_PARSE, $e);
        }
    }
}