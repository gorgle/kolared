<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use yii\widgets\ActiveForm;

$isNewRecord = isset($isNewRecord) && $isNewRecord;
$this->title = $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update') . ' ' .
    Yii::t('app', Yii::$app->params['rbacType'][$model->type]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rbac'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="card">
        <div class="card-header" data-background-color="purple">
            <h3><?= $this->title ?></h3>
        </div>
        <div class="card-content">
            <div class="row">
                <?php $form = ActiveForm::begin([]); ?>
                <?= $form->field($model, 'oldname', ['template' => '{input}'])->input('hidden'); ?>
                <?= $form->field($model, 'type', ['template' => '{input}'])->input('hidden'); ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>
                <?= (!empty($rules)) ? $form->field($model, 'ruleName')->dropDownList($rules, ['prompt' => 'Choose rule']) : '' ?>
                <?= $form->field($model, 'children')->widget('backend\widgets\MultiSelect', [
                    'items' => $items,
                    'selectedItems' => $children,
                    'ajax' => false,
                ]) ?>
                <div id="danger" class="alert-danger alert" style="display: none;">
                    <span id="text"></span>
                </div>
                <div class="form-group no-margin">
                    <?=
                    Html::a(
                        '<i class="material-icons">undo</i>'. Yii::t('app', 'Back'),
                        Yii::$app->request->get('returnUrl', ['index']),
                        ['class' => 'btn btn-danger']
                    )
                    ?>
                    <?php if ($model->isNewRecord): ?>
                        <?= Html::submitButton(
                            '<i class="material-icons">save</i>' . Yii::t('app', 'Save & Go next'),
                            [
                                'class' => 'btn btn-success',
                                'name' => 'action',
                                'value' => 'next',
                            ]
                        ) ?>
                    <?php endif; ?>
                    <?= Html::submitButton(
                        '<i class="material-icons">save</i>' . Yii::t('app', 'Save & Go back'),
                        [
                            'class' => 'btn btn-warning',
                            'name' => 'action',
                            'value' => 'back',
                        ]
                    ); ?>
                    <?=
                    Html::submitButton(
                        '<i class="material-icons">save</i>' . Yii::t('app', 'Save'),
                        [
                            'class' => 'btn btn-primary',
                            'name' => 'action',
                            'value' => 'save',
                        ]
                    )
                    ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
