<?php
use yii\helpers\Url;

use pistol88\order\assets\Asset;
Asset::register($this);

$currency = yii::$app->getModule('order')->currency;

$firstOrderDate = $model::find()->min('date');
$firstOrderYear = date('Y', strtotime($firstOrderDate));

if((date('Y')-$firstOrderYear) > 10) {
    $firstOrderYear = (date('Y')-10);
}

$years = array_reverse(range($firstOrderYear, date('Y')));

$this->title = yii::t('order', 'Order statistics');

$this->params['breadcrumbs'][] = ['label' => Yii::t('order', 'Orders'), 'url' => ['/order/order/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="order-stat">
    <?= $this->render('/parts/menu.php', ['active' => 'statistics']); ?>
    
    <h1><?=$this->title;?></h1>
    <div class="row">
        <div class="col-lg-2">
            
        </div>
        <div class="col-lg-10">
            
        </div>
    </div>
    
    <div class="container">
        <?php foreach($years as $year) { ?>
            <h2><?=$year;?></h2>
            <table class="table table-hover table-responsive">
                <tr>
                    <th><?=yii::t('order', 'Month');?></th>
                    <th><?=yii::t('order', 'Turnover');?></th>
                    <th><?=yii::t('order', 'Orders count');?></th>
                    <th><?=yii::t('order', 'Average check');?></th>
                </tr>
                <?php $prevStat = false; ?>
                <?php for($m = 1; $m <= 12; $m++) { ?>
                    <?php if($m <= 9) $m = "0$m"; ?>
                    <tr>
                        <td class="month">
                            <a href="<?=Url::toRoute(['/order/stat/month', 'y' => $year, 'm' => $m]);?>"><?=yii::t('order', "month_$m");?></a>
                        </td>
                        <?php
                        $stat = $model::getStatInMoth("$year-$m");
                        if($stat['count_order']) {
                        ?>
                            <td>
                                <?=$stat['total'];?>
                                
                                <?php
                                if($prevStat && date('Ym') > "$year$m") {
                                    $cssClass = '';
                                    $sum = '';
                                    if($prevStat['total'] < $stat['total']) {
                                        $cssClass = 'good-result';
                                        $sum = '+'.($stat['total']-$prevStat['total']);
                                    } elseif($prevStat['total'] > $stat['total']) {
                                        $cssClass = 'bad-result';
                                        $sum = '-'.($prevStat['total']-$stat['total']);
                                    }
                                    if($sum) {
                                    ?>
                                        <span class="result <?=$cssClass;?>"><?=$sum;?></span>
                                    <?php
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $cssClass = '';
                                if($prevStat && date('Ym') > "$year$m") {
                                    if($prevStat['count_order'] > $stat['count_order']) {
                                        $cssClass = 'bad-result';
                                    } elseif($prevStat['count_order'] < $stat['count_order']) {
                                        $cssClass = 'good-result';
                                    }
                                }
                                ?>
                                <span class="<?=$cssClass;?>"><?=$stat['count_order'];?></span>
                            </td>
                            <td><?=round($stat['total']/$stat['count_order'], 2);?></td>
                        <?php
                        } else {
                            echo '<td colspan="4" align="center">-</td>';
                        }
                        $prevStat = $stat;
                        ?>
                    </tr>
                <?php } ?>
            </table>
        <?php } ?>
    </div>
</div>

<style>
.order-stat {

}

.order-stat .bad-result {
    padding: 2px;
    font-size: 70%;
    background-color: #BB3D3D;
    color: white;
}

.order-stat .good-result {
    padding: 2px;
    font-size: 70%;
    background-color: #96B796;
    color: white;
}
</style>