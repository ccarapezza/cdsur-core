<?php

use yii\helpers\Html;

$productCount = 0;
?>
<div class="template-pedido" align="center">
    <table width="970" border="1" style="border-collapse: collapse; border: 2px solid black;">
           <tr>
            <td width="300" rowspan="4"><img src="CDS-logo.png" width="300" style="padding: 15px;"></td>
              <td rowspan="4"></td>
              <td width="139" style="text-align: right; padding-right: 10px">
                 <strong>Fecha&nbsp;&nbsp;</strong>
              </td>
              <td width="96" style="text-align: center;">
                 <div align="center"> <?=Yii::$app->formatter->asDate($model->created_date, 'dd/MM/yyyy');?> </div>
              </td>
           </tr>
           <tr>
              <td width="139" style="text-align: right; padding-right: 10px">
                 <strong>Hora&nbsp;&nbsp;</strong>
              </td>
              <td width="96" style="text-align: center;">
                 <div align="center"> <?=Yii::$app->formatter->asDate($model->created_date, 'HH:mm');?> </div>
              </td>
           </tr>
           <tr>
              <td style="text-align: right; padding-right: 10px">
                 <strong>Nro. Pedido&nbsp;&nbsp;</strong>
              </td>
              <td style="text-align: center;">
                 <strong><?=$model->id?></strong>
              </td>
           </tr>
           <tr>
              <td colspan="2"></td>
           </tr>
    </table>
    </div>
    <div align="center">
    <h3>Datos del Cliente</h3>
    <table width="970" border="1" style="border-collapse: collapse; border: 2px solid black;">
        <tbody>
           <tr>
              <td width="82" style="text-align: right; padding-right: 10px">
                <strong>Apellido</strong>
              </td>
              <td width="249">
              </td>
              <td width="137" style="text-align: right; padding-right: 10px">
                 <strong>Nombre</strong>
              </td>
              <td width="467">
              </td>
           </tr>
           <tr>
              <td style="text-align: right; padding-right: 10px">
                 <strong>Usuario</strong>
              </td>
              <td style="padding-left: 10px;">
                 <?=$model->user->username?>
              </td>
              <td style="text-align: right; padding-right: 10px">
                 <strong>Email</strong>
              </td>
              <td style="padding-left: 10px;">
                 <?=$model->user->email?>
              </td>
           </tr>
           <tr>
              <td>
                 <div align="left"></div>
              </td>
              <td>
                 <div align="left"></div>
              </td>
              <td>&nbsp;</td>
              <td>
                 <div align="left"></div>
              </td>
           </tr>
        </tbody>
    </table>
    <h3>Productos</h3>
    <table width="970" border="1" style="border-collapse: collapse; border: 2px solid black;">
        <tbody>
           <tr style="border: 2px solid black;">
              <th width="81" scope="col">
                 <div align="center">CÓDIGO</div>
              </th>
              <th width="612" scope="col">
                 <div align="center">DESCRIPCIÓN</div>
              </th>
              <th width="121" scope="col">
                 <div align="center">CANTIDAD</div>
              </th>
           </tr>
            <?php foreach ($model->cartProducts as $cartProduct){ ?>
                <tr>
                    <td height="23" style="text-align: center;">
                        <?=$cartProduct->product->code?>
                    </td>
                    <td style="padding-left: 10px;">
                        <?=$cartProduct->product->description?>
                    </td>
                    <td style="text-align: center">
                        <?=$cartProduct->quantity?>
                    </td>
                </tr>
            <?php $productCount+=$cartProduct->quantity; } ?>
            <?php for ($i = 1; $i <= 10-count($model->cartProducts); $i++) { ?>
                <tr>
                    <td height="23">
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            <?php } ?>
            <tr style="border-top: 2px solid black;">
                <td colspan="2" height="32">
                    <strong>Cantidad productos&nbsp;&nbsp;</strong>
                </td>
                <td style="text-align: center">
                    <strong><?=count($model->cartProducts)?></strong>
                </td>
            </tr>
            <tr>
                <td colspan="2" height="32">
                    <div align="right"><strong>Cantidad total&nbsp;&nbsp;</strong></div>
                </td>
                <td style="text-align: center">
                    <strong><?=$productCount?></strong></div>
                </td>
            </tr>
        </tbody>
    </table>
</div>