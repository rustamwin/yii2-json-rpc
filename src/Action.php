<?php
/**
 * @link      http://www.activemedia.uz/
 * @copyright Copyright (c) 2018. ActiveMedia Solutions LLC
 * @author    Rustam Mamadaminov <rmamdaminov@gmail.com>
 */

/**
 * Created by PhpStorm.
 * User: rustam
 * Date: 5/28/18
 * Time: 2:15 AM
 */

namespace rustamwin\rpc;


use yii\base\Action as BaseAction;

class Action extends BaseAction
{

    public function init()
    {
        $this->controller->enableCsrfValidation = false;
        parent::init();
    }
}