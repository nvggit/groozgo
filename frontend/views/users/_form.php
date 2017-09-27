<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $user app\users\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

	<?php $form = ActiveForm::begin([
	'options' => [
            'id' => 'dynamic-form'
        ]
	]); ?>

	<div class="col-sm-3">
		<?= $form->field($user, 'surname')->textInput(['maxlength' => true]) ?>
	</div>

	<div class="col-sm-3">
		<?= $form->field($user, 'name')->textInput(['maxlength' => true]) ?>
	</div>
	
	<div class="col-sm-3">
		<?= $form->field($user, 'birthdate')->widget(\kartik\date\DatePicker::classname(),[
			'pluginOptions' => [
				'format' => 'yyyy-mm-dd',
				'todayHighlight' => true,
				'clientOptions' =>[
					'changeYear'=> true,
					'changeMonth'=> true,
					'autoSize'=>false,
					'yearRange' => 'c-1:c+3',
				]
		]
		]);?>
	</div>    
	
	<div class="col-sm-2">
		<?= $form->field($user, 'male')->dropDownList(['муж','жен'],['prompt' => ' ']); ?>
	</div>
	
	<div class="col-sm-12">
		<?php DynamicFormWidget::begin([
			'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
			'widgetBody' => '.container-items', // required: css class selector
			'widgetItem' => '.item', // required: css class
			'limit' => 10, // the maximum times, an element can be cloned (default 999)
			'min' => 0, // 0 or 1 (default 1)
			'insertButton' => '.add-item', // css class
			'deleteButton' => '.remove-item', // css class
			'model' => $addresses[0],
			'formId' => 'dynamic-form',
			'formFields' => [
				'address',
				'comment',
			],
		]); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-11">
						<b>Адрес</b>
					</div>
					<div class="col-sm-1">
						<button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Добавить</button>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body container-items"><!-- widgetContainer -->
				<?php foreach ($addresses as $i => $address): ?>
					<div class="item row"><!-- widgetBody -->
						<?php if (! $address->isNewRecord) { echo Html::activeHiddenInput($address, "[{$i}]id"); } ?>								
						<div class="col-sm-5">
							<?= $form->field($address, "[{$i}]address")->textInput(["maxlength" => true])?>
						</div>
						<div class="col-sm-5">
							<?= $form->field($address, "[{$i}]comment")->textInput(["maxlength" => true])?>
						</div>
								
						<div class="col-sm-2">
							<div class="pull-right">
								<br><button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
								<button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php DynamicFormWidget::end(); ?>
	</div>

    <div class="col-sm-12">
        <?= Html::submitButton($user->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
