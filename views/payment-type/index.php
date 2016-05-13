<?php

use yii\helpers\Html;
use yii\grid\GridView;
use pistol88\order\models\OrderFieldType;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('order', 'Payment types');
$this->params['breadcrumbs'][] = ['label' => Yii::t('order', 'Orders'), 'url' => ['/order/order/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="field-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= Html::a(Yii::t('order', 'Create payment type'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-lg-6">
            <?= $this->render('/parts/menu.php', ['active' => 'payment-type']); ?>
        </div>
    </div>

    <hr />
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'options' => ['style' => 'width: 55px;']],
			'name',
            'widget',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 145px;']],
        ],
    ]); ?>

</div>
