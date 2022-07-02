<?php

use app\models\Supplier;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $exportForm app\models\ExportSupplierForm */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= \yii\bootstrap4\Button::widget([
        'id' => 'exportBtn',
        'label' => 'Export',
        'options' => [
            'class' => 'btn-primary',
            'style' => 'display:none;',
            'data-target' => '#exportOptionModal',
            'data-toggle' => 'modal',
        ],
    ]) ?>
    <?php echo $this->render('_exportModal', ['searchModel' => $searchModel, 'exportForm' => $exportForm]); ?>

    <?= \yii\bootstrap4\Alert::widget([
        'id' => 'alert-select-all-item',
        'body' => 'All 50 suppliers on this page have been selected. '
            . Html::a('Select all supplier that match this search', '#', [
                'id' => 'selectAllMathBtn',
            ]),
        'options' => [
            'class' => 'alert-secondary',
            'style' => 'display:none;margin-top:8px;',
        ],
        'closeButton' => false,
    ]) ?>
    <?= \yii\bootstrap4\Alert::widget([
        'id' => 'alert-select-all-item-cancel',
        'body' => 'All suppliers in this search have been selected '
            . Html::a('clear selection', '#', [
                'id' => 'cancelSelectAllMathBtn',
            ]),
        'options' => [
            'class' => 'alert-secondary',
            'style' => 'display:none;margin-top:8px;',
        ],
        'closeButton' => false,
    ]) ?>
    <?= GridView::widget([
        'id' => 'supplier',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => \yii\grid\CheckboxColumn::class,
            ],
            'id',
            'name',
            'code',
            [
                'attribute' => 't_status',
                'filter' => ["ok" => "ok", "hold" => "hold"]
            ],
        ],
    ]); ?>


</div>
<?php
$this->registerJs('const totalCount=' . $dataProvider->totalCount, View::POS_END );
$this->registerJsFile('@web/js/supplier.js', ['depends' => [\yii\web\JqueryAsset::class],
    'positon' => View::POS_END,]);
?>
