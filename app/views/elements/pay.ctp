
	<!--
$34.95 / month


<form method=post action=https://api-3t.sandbox.paypal.com/nvp> 
		<input type=hidden name=USER value=roger_1296242712_biz_api1.yahoo.com> 
		<input type=hidden name=PWD value=1296242721> 
		<input type=hidden name=SIGNATURE value=AkuIznWSupXStXKcqGLMa-okf01.A9KWkzrBxk.iX-E.jfdbuFDTSfCH > 
		<input type=hidden name=VERSION value=63.0> 
		<input type=hidden name=PAYMENTREQUEST_0_PAYMENTACTION 
			value=Authorization> 
		<input name=PAYMENTREQUEST_0_AMT value=34.95> 
		<input name=PAYMENTREQUEST_0_CURRENCYCODE value='USD'>

		<input type=hidden name=RETURNURL 
			value=http://www.bantana.com> 
		<input type=hidden name=CANCELURL 
			value=http://www.bantana.com> 
		<input type=submit name=METHOD value=SetExpressCheckout> 
	</form>	
-->

<? echo $html->link("click here to pay", array('controller'=>'users','action'=>'expressCheckout')); ?>
