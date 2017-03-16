<?php
/* @var $this yii\web\View */

use yii\bootstrap\Tabs;

$this->title = Yii::t('app', 'Rbac');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="card">
        <!--        <div class="card-header" data-background-color="purple"></div>-->
        <div class="card-content">
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'Permissions'),
                        'content' => $this->render('_rbacGrid', [
                            'data' => $permissions,
                            'isRules' => $isRules,
                            'id' => 'options'
                        ]),
                        'active' => true,
                    ],
                    [
                        'label' => Yii::t('app', 'Roles'),
                        'content' => $this->render('_rbacGrid', [
                            'data' => $roles,
                            'isRules' => $isRules,
                            'id' => 'roles'
                        ]),
                    ]
                ],
            ]) ?>
            <div class="row">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        <?= \yii\helpers\Html::a(
                            Yii::t('app', 'Create Role'),
                            ['create', 'returnUrl' => \backend\components\Helper::getReturnUrl(), 'type' => \yii\rbac\Item::TYPE_ROLE],
                            ['class' => 'btn btn-success']
                        ) ?>

                        <?= \yii\helpers\Html::a(
                            Yii::t('app', 'Create Permission'),
                            ['create', 'returnUrl' => \backend\components\Helper::getReturnUrl(), 'type' => \yii\rbac\Item::TYPE_PERMISSION],
                            ['class' => 'btn btn-success']
                        ) ?>


                        <?= \yii\helpers\Html::button(Yii::t('app', 'Delete selected'), ['class' => 'btn btn-danger', 'id' => 'deleteItems']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<<JS
    "use strict";
    jQuery("#deleteItems").on('click',function(){
        jQuery.ajax({
            'url' : '/user/rbac/remove-items',
            'type':'post',
            'data' : {
                'items' : jQuery('.grid-view').yiiGridView('getSelectedRows')
            },
            success:function(data) {
                location.reload();
            }
        });    
    });
JS;
$this->registerJs($js);
?>
