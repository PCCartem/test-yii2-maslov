<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dish-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
    if (!empty($data)) {
        echo Select2::widget([
            'name' => 'ingredients',
            'data' => $data,
            'value' => $ingredients,
            'options' => [
                'placeholder' => 'Выбирите ингредиенты для вашего блюда ...',
                'multiple' => true
            ],
        ]);
    } else {
        echo 'Не найдено ингредиентов! Добавьте их из панели администратора для продолжения работы!';
    }
    ?>
</div><br/>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php  ActiveForm::end(); ?>
</div>
