<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $searchModel app\models\SupplierSearch */
/* @var $exportForm app\models\ExportSupplierForm */

?>


<?php \yii\bootstrap4\Modal::begin([
    'id' => 'exportOptionModal',
    'title' => 'Export Options',
]);
?>

<?php $form = ActiveForm::begin([
    'id' => 'export-form',
    'action' => ['/supplier/export'],
]) ?>
<?= $form->field($exportForm, 'exportFields')->checkboxList(['id' => 'ID', 'name' => 'Name', 'code' => 'Code', 't_status' => 'T Status']); ?>
<?= $form->field($exportForm, 'exportAllMatch')->hiddenInput()->label(false); ?>
<?= $form->field($exportForm, 'ids')->hiddenInput()->label(false); ?>
<?= $form->field($searchModel, 'id')->hiddenInput()->label(false) ?>
<?= $form->field($searchModel, 'name')->hiddenInput()->label(false) ?>
<?= $form->field($searchModel, 'code')->hiddenInput()->label(false) ?>
<?= $form->field($searchModel, 't_status')->hiddenInput()->label(false) ?>
    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Export', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
<?php \yii\bootstrap4\Modal::end() ?>