<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $user app\models\Users */

$this->title = 'Добавить пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'user' => $user,
        'addresses' => $addresses,
    ]) ?>

</div>
