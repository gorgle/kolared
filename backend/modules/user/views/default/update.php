<?php
/**
 * Created by PhpStorm.
 * User: alexchen
 * Date: 2017/3/14
 * Time: 下午5:44
 */
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update');
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('app', 'Users'), 'url' => ['index']],
    $this->title
];

?>
<div class="row">
    <div class="card">
        <div class="card-header" data-background-color="purple">
            <h4><?= $this->title ?></h4>
        </div>
        <div class="card-content">
            <?php $form = ActiveForm::begin([
                'id' => 'user-form',
                'options' => [
                    'class' => 'form-inline',
                ],
                'fieldConfig' => [
                    'options' => ['class' => 'col-sm-6'],
                ]
            ]) ?>

            <?= $form->field($model, 'username')->textInput(['autocomplete' => 'off']) ?>
            <?= $form->field($model, 'password') ?>
            <?= $form->field($model, 'status')->dropDownList($model->getStatuses()) ?>
            <?= $form->field($model,'email')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model,'first_name')->textInput(['maxlength' => 100]) ?>
            <?= $form->field($model,'last_name')->textInput(['maxlength' => 100]) ?>
            <?=
            backend\widgets\MultiSelect::widget([
                'items' => \yii\helpers\ArrayHelper::map(
                    \Yii::$app->getAuthManager()->getRoles(),
                    'name',
                    function ($item) {
                        return $item->name . (strlen($item->description) > 0
                                ? ' [' . $item->description . ']'
                                : '');
                    }
                ),
                'selectedItems' => $model->isNewRecord ? [] : $assignments,
                'ajax' => false,
                'name' => 'AuthAssignment[]',
                'label' => Yii::t('app', 'Assignments'),
            ]);
            ?>
            <?=
            \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Update',[
                    'class' => 'btn btn-primary pull-right'
            ]);
            ?>

            <?php ActiveForm::end() ?>
        </div>

    </div>
</div>
