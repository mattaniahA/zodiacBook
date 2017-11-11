<hr />
<table width="100%" style="border: 0">
<tr>
<td style="text-align: right">&copy; 2017 by Mattaniah Aytenfsu.</td>
</tr>
<tr><td>
<a href="http://validator.w3.org/check/referer">
<img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0!" height="31" width="88" /></a>
</td>
<td style="text-align: center; vertical-align:top">All Rights Reserved.</td></tr>
</table>
<?php
	$prov_array = file("proverbs.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$proverbcount = count($prov_array);
	$index = rand(0, $proverbcount-1);
	?><p>Total visitors to this site: <?php echo $visitors; ?></p><?php
	echo "A randomly displayed Chinese proverb read from a text file : <br />";
	echo $prov_array[$index]."<br />";
	echo "<img src=".getimage().">";
	
	function getimage() {
	  $files = glob( "images/Dragon*.png");
	  shuffle($files);
	  return $files['0'];
	}
?>