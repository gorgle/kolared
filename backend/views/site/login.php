<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="card">
        <div class="card-header" data-background-color="purple">
            <h3><?= Html::encode($this->title) ?></h3>
            <p>Please fill out the following fields to login:</p>
        </div>
        <div class="card-content">
            <div class="row">
                <div class="col-lg-4 pull-left">

                </div>
                <div class="col-lg-8 center-block pull-right">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
//                        'options' => ['class' => 'form-inline']
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group pull-right">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary pull-right', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>


</div>
