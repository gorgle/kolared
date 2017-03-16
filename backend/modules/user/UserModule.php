<?php

namespace backend\modules\user;

/**
 * user module definition class
 */
class UserModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\user\controllers';

    public $loginSessionDuration = 86400;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
