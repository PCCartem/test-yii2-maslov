<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$url = \yii\helpers\Url::to(['ingredient/ingredient-list']);
$error = null;

if ($dishes === false) {
    $error = "Ничего не найдено";
}

if (!empty($ingredients) && count($ingredients) < 2) {
    $error = "Выберите больше ингредиентов";
}


$form = ActiveForm::begin();
echo Select2::widget([
    'name' => 'ingredients',
    'data' => $data,
    'value' => $ingredients,
    'options' => [
        'placeholder' => 'Выбирите 2 ингредиента для поиска блюда ...',
        'multiple' => true,
        'data-maximum-selection-length' => 5
    ]
]);
echo "</br>" . Html::submitButton('Искать', ['class' => 'btn btn-success']);
ActiveForm::end();

if ($dishes !== NULL) {
    echo "<h2>Найденные блюда</h2>";
    foreach ($dishes as $dish) {
        echo "<p>" . $dish['name'] . "</p>";
    }
}

if (!is_null($error)) {
    echo "<p class='error-summary'>$error</p>";
}

?>




