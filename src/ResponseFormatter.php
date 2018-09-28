<?php
/**
 * @link      http://www.activemedia.uz/
 * @copyright Copyright (c) 2018. ActiveMedia Solutions LLC
 * @author    Rustam Mamadaminov <rmamdaminov@gmail.com>
 */

namespace rustamwin\rpc;


use yii\base\Component;
use yii\base\ErrorException;
use yii\helpers\Json;
use yii\web\MethodNotAllowedHttpException;
use yii\web\ResponseFormatterInterface;

/**
 * @property mixed contentType
 */
class ResponseFormatter extends Component implements ResponseFormatterInterface
{
    /**
     * JSON Content Type
     * @since 2.0.14
     */
    const CONTENT_TYPE_JSONP = 'application/javascript; charset=UTF-8';
    /**
     * JSONP Content Type
     * @since 2.0.14
     */
    const CONTENT_TYPE_JSON = 'application/json; charset=UTF-8';
    /**
     * HAL JSON Content Type
     * @since 2.0.14
     */
    const CONTENT_TYPE_HAL_JSON = 'application/hal+json; charset=UTF-8';

    public $contentType;

    /**
     * @param \yii\web\Response $response
     */
    public function format($response)
    {
        if ($this->contentType === null) {
            $this->contentType = self::CONTENT_TYPE_JSON;
        } elseif (strpos($this->contentType, 'charset') === false) {
            $this->contentType .= '; charset=UTF-8';
        }
        $response->getHeaders()->set('Content-Type', $this->contentType);
        if (($e = \Yii::$app->errorHandler->exception) && $e !== null) {
            if ($e instanceof JsonRpcException) {
                $content = $e->renderError();
            } else {
                $e       = new JsonRpcException(\Yii::$app->request->getBodyParam('id'), $e->getMessage(), JsonRpcException::JSON_RPC_ERROR_SERVER, $e);
                $content = $e->renderError();
            }
        } else {
            $content = [
                'jsonrpc' => \Yii::$app->request->getBodyParam('jsonrpc', '2.0'),
                'result'  => Json::encode($response->data, 320),
                'id'      => \Yii::$app->request->getBodyParam('id'),
            ];
        }

        $response->content = Json::encode($content, 320);
    }
}