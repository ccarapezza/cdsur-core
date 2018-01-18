<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

	<title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!--[if !mso]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--<![endif]-->
    
    <style type="text/css">
    
    .ReadMsgBody { width: 100%; background-color: #FFFFFF; }
    .ExternalClass { width: 100%; background-color: #FFFFFF; }
    body { width: 100%; background-color: #FFFFFF; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; font-family: Arial, Times, serif }
    table { border-collapse: collapse !important; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        
    @-ms-viewport{ width: device-width; }
    @media only screen and (max-width: 639px){
    .wrapper{ width:100%;  padding: 0 !important; }
    }    
    @media only screen and (max-width: 480px){  
    .centerClass{ margin:0 auto !important; }
    .imgClass{ width:100% !important; height:auto; }    
    .wrapper{ width:320px; padding: 0 !important; }   
    .container{ width:300px;  padding: 0 !important; }
    .mobile{ width:300px; display:block; padding: 0 !important; text-align:center !important;}
    *[class="mobileOff"] { width: 0px !important; display: none !important; }
    *[class*="mobileOn"] { display: block !important; max-height:none !important; }
    }
    
    </style>
    
	<!--[if gte mso 15]>
	<style type="text/css">
		table { font-size:1px; line-height:0; mso-margin-top-alt:1px;mso-line-height-rule: exactly; }
		* { mso-line-height-rule: exactly; }
	</style>
	<![endif]-->    

</head>
<body marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" style="background-color:#FFFFFF;  font-family:Arial,serif; margin:0; padding:0; min-width: 100%; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;">
	<?php $this->beginBody() ?>

	<!--[if !mso]><!-- -->
	<img style="min-width:640px; display:block; margin:0; padding:0" class="mobileOff" width="640" height="1" src="http://s14.postimg.org/7139vfhzx/spacer.gif">
	<!--<![endif]-->

    <!-- Start Background -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF">
        <tr>
            <td width="100%" valign="top" align="center">
                
      
                <!-- START HEADER  -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" style="border-bottom:1px solid #f3f3f3;">
                    <tr>
                        <td height="30" style="font-size:10px; line-height:10px;"> </td>
                    </tr>
                    <tr>
                        <td align="center">

                            <!-- Start Container  -->
                            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                                <tr>
                                    <td width="600" class="mobile" align="center" mc:label="the_logo" mc:edit="the_logo">
                                        
                                        <img src="http://www.cdsurargentina.com.ar/images/cds-logo.png" style="margin:0; padding:0; border:none; display:block;" border="0" class="centerClass" alt="" mc:edit="the_image" /> 
                                        
                                    </td>
                                </tr>
                            </table>
                            <!-- Start Container  -->                   

                        </td>
                    </tr>
                    <tr>
                        <td height="35" style="font-size:10px; line-height:10px;"> </td>
                    </tr>                        
                </table> 
                <!-- END HEADER  -->
                
                <!-- START MESSAGE  -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF">
                    <tr>
                        <td height="20" style="font-size:10px; line-height:10px;"> </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <?= $content ?>              
                        </td>
                    </tr>
                    <tr>
                        <td height="45" style="font-size:10px; line-height:10px;"> </td>
                    </tr>                        
                </table> 
                <!-- END MESSAGE  -->
                
                
                <!-- START FOOTER  -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#323641">
                    <tr>
                        <td height="40" style="font-size:10px; line-height:10px;"> </td>
                    </tr>
                    <tr>
                        <td align="center">


                            <!-- Start Container  -->
                            <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">       
                                <tr>
                                    <td width="600" class="mobile" align="center" mc:label="the_logo" mc:edit="the_logo">
                                        
                                        <img src="http://www.cdsurargentina.com.ar/images/bottom-logo.png" style="margin:0; padding:0; border:none; display:block;" border="0" class="centerClass" alt="" mc:edit="the_image" /> 
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20" style="font-size:10px; line-height:10px;"></td>
                                </tr>
                                <tr>
                                    <td width="600" class="mobile" style="font-family:arial; font-size:12px; line-height:18px; color:#aeaeae;" align="center" mc:label="the_copyright" mc:edit="the_copyright">
                                        &copy; 2018 Centro de Distribución Sur. Todos Los Derechos Reservados
                                    </td>
                                </tr>                                
                            </table>
                            <!-- Start Container  -->                   

                        </td>
                    </tr>
                    <tr>
                        <td height="40" style="font-size:10px; line-height:10px;"> </td>
                    </tr>                        
                </table> 
                <!-- END FOOTER  -->                 
                
      
            </td>
        </tr>
    </table>
    <!-- End Background -->
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>