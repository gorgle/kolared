<?php
/**
 * Created by PhpStorm.
 * User: alexchen
 * Date: 2017/3/15
 * Time: 下午2:56
 */

use backend\components\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var $id string
 * @var $data \yii\data\ArrayDataProvider
 * @var $isRules boolean
 */
?>
<?php Pjax::begin() ?>
<?= GridView::widget([
    'id' => $id,
    'dataProvider' => $data,
    'layout' => "{items}\n{summary}\n{pager}",
    'columns' => [
        [
            'class' => \yii\grid\CheckboxColumn::className(),
            'options' => ['width' => '10px'],
        ],
        [
            'attribute' => 'name',
            'label' => Yii::t('app','Name'),
            'options' => ['width' => '30%'],
        ],
        [
            'attribute' => 'description',
            'label' => Yii::t('app','Description'),
        ],
        [
            'attribute' => 'ruleName',
            'visible' => $isRules,
        ],
        [
            'attribute' => 'createdAt',
            'label' => Yii::t('app','Created At'),
            'value' => function($model){
                return date('Y-m-d H:i:s',$model->createdAt);
            },
            'options' => ['width' => '200px'],
        ],
        [
            'attribute' => 'updatedAt',
            'label' => Yii::t('app','Updated At'),
            'value' => function($model){
                return date('Y-m-d H:i:s',$model->updatedAt);
            },
            'options' => ['width' => '200px'],
        ],
        [
            'class' => ActionColumn::className(),
            'options' => ['width' => '95px'],
            'buttons' => [
                [
                    'url' => 'update',
                    'icon' => 'create',
                    'class' => 'btn-primary',
                    'label' => Yii::t('app','Edit'),
                ],
                [
                    'url' => 'delete',
                    'icon' => 'delete',
                    'class' => 'btn-danger',
                    'label' => Yii::t('app','Delete'),
                ],
            ],
            'urlCreator' => function($action,$model,$key,$index){
                $params = is_array($key) ? $key : ['id' => (string)$key];
                if($action != 'delete'){
                    $params['type'] = $model->type;
                }
                $params[0] = $this->context->id ? $this->context->id .'/'.$action:$action;
                return \yii\helpers\Url::toRoute($params);
            },
        ],
    ],
    'tableOptions' => ['class' => 'table'],
]) ?>
<?php Pjax::end() ?>
