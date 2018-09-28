<?php
/**
 * Created by PhpStorm.
 * User: rustam
 * Date: 6/4/18
 * Time: 12:23 AM
 */

namespace rustamwin\rpc;


use yii\base\BaseObject;

class Request extends BaseObject
{

    public $id;
    public $method;
    public $params = [];
}