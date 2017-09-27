<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\Users */

$this->title = 'Редактирование пользователя: ' . $user->name;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->name, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'user' => $user,
        'addresses' => $addresses,
    ]) ?>

</div>
