<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;


/**
 * Created by PhpStorm.
 * User: alexchen
 * Date: 2017/3/8
 * Time: 上午10:51
 */
class RbacController extends \yii\console\Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // 添加 "createPost" 权限
//        $createPost = $auth->createPermission('createPost');
//        $createPost->description = 'Create a post';
//        $auth->add($createPost);

        // 添加 "updatePost" 权限
//        $updatePost = $auth->createPermission('updatePost');
//        $updatePost->description = 'Update post';
//        $auth->add($updatePost);

        //
    }
}