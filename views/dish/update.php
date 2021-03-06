<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $ingredients array */

$this->title = 'Update Dish: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dish-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(!empty($error)) { ?>
        <p class="error-summary"><?= Html::encode($error) ?></p>
    <?php } ?>


    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
        'ingredients' => $ingredients
    ]) ?>

</div>
