<?

	$search ="http://api.twitter.com/1/statuses/user_timeline/rogerwu99.xml"; 
	$x = new DOMDocument();
  	$x->load($search);
	$titles = $x->getElementsByTagName("text");
	echo $titles->item(0)->nodeValue; 
?>
