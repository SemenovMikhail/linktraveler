<?php
if( isset( $_POST['buf_submit'] ) )
{

error_reporting(E_ALL ^ E_NOTICE);	
	$array = $_POST['buf_link'];

	date_default_timezone_set('Europe/Moscow');
	$date = date("Y-m-d_H-i-s");
	$newLinks_file = "/var/www/html/linktraveler/database/new/newLinks_".$date.".txt";
		$fp = fopen($newLinks_file, "w");
		fclose($fp);
	if(empty($array))
	{
		echo("Nothing is choosed");
	}
	else
	{
		foreach($array as $chosen_link)
		{
				file_put_contents($newLinks_file, PHP_EOL.$chosen_link, FILE_APPEND);
		}
		echo "<br>File is ready";
	}
	return 0;
}
?>
<form method="post">
<input type="submit" name="buf_submit" value="Form new links file" />

<table width="100%" cellspacing="0" cellpadding="4" border="1">
	<tbody><tr>
	<td width="5%">ID</td>
	<td width="10%">Valid</td>
	<td width="35%">Host</td>
	<td width="20%">IP</td>
	<td width="10%">In Seosed</td>
	<td width="10%">Country</td>
	<td width="10%">Add</td>
	</tr><tr><td>1</td><td style="background-color: Green">true</td><td><a href="http://scgt.com.sapo.pt">http://scgt.com.sapo.pt</a></td><td>213.13.145.4</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://scgt.com.sapo.pt"></td></tr><tr></tr><tr><td>3</td><td style="background-color: Green">true</td><td><a href="http://www.sportscar.com.sapo.pt">http://www.sportscar.com.sapo.pt</a></td><td>213.13.145.4</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.sportscar.com.sapo.pt"></td></tr><tr><td>4</td><td style="background-color: Green">true</td><td><a href="http://www.classicsportscar.com.sapo.pt">http://www.classicsportscar.com.sapo.pt</a></td><td>213.13.145.4</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.classicsportscar.com.sapo.pt"></td></tr><tr><td>5</td><td style="background-color: Green">true</td><td><a href="http://k45-286.blogspot.com">http://k45-286.blogspot.com</a></td><td>64.233.162.197</td><td style="background-color: Green">valid</td><td>64.233.162.197</td><td><input name="buf_link[]" type="checkbox" value="http://k45-286.blogspot.com"></td></tr><tr></tr><tr></tr><tr><td>8</td><td style="background-color: Green">true</td><td><a href="http://www.blogger.com">http://www.blogger.com</a></td><td>74.125.143.191</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.blogger.com"></td></tr><tr></tr><tr></tr><tr><td>11</td><td style="background-color: Green">true</td><td><a href="http://porsche356.blogspot.com">http://porsche356.blogspot.com</a></td><td>64.233.162.197</td><td style="background-color: Green">valid</td><td>64.233.162.197</td><td><input name="buf_link[]" type="checkbox" value="http://porsche356.blogspot.com"></td></tr><tr><td>12</td><td style="background-color: Green">true</td><td><a href="http://www.concept1.ca">http://www.concept1.ca</a></td><td>216.146.38.125</td><td style="background-color: Green">valid</td><td>216.146.38.125</td><td><input name="buf_link[]" type="checkbox" value="http://www.concept1.ca"></td></tr><tr><td>13</td><td style="background-color: Green">true</td><td><a href="http://www.madle.org">http://www.madle.org</a></td><td>213.239.216.154</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.madle.org"></td></tr><tr><td>14</td><td style="background-color: Green">true</td><td><a href="http://www.imcdb.org">http://www.imcdb.org</a></td><td>5.135.160.202</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.imcdb.org"></td></tr><tr><td>15</td><td style="background-color: Green">true</td><td><a href="http://www.carculture.com">http://www.carculture.com</a></td><td>23.227.38.68</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.carculture.com"></td></tr><tr></tr><tr><td>17</td><td style="background-color: Green">true</td><td><a href="http://www.historischeautonummernschilder.de">http://www.historischeautonummernschilder.de</a></td><td>141.8.224.25</td><td style="background-color: Green">valid</td><td>CH</td><td><input name="buf_link[]" type="checkbox" value="http://www.historischeautonummernschilder.de"></td></tr><tr></tr><tr></tr><tr><td>20</td><td style="background-color: Green">true</td><td><a href="http://kronenstrasse24.blogspot.com">http://kronenstrasse24.blogspot.com</a></td><td>64.233.164.197</td><td style="background-color: Green">valid</td><td>64.233.164.197</td><td><input name="buf_link[]" type="checkbox" value="http://kronenstrasse24.blogspot.com"></td></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>25</td><td style="background-color: Green">true</td><td><a href="http://fonts.googleapis.com">http://fonts.googleapis.com</a></td><td>173.194.71.95</td><td style="background-color: Green">valid</td><td>173.194.71.95</td><td><input name="buf_link[]" type="checkbox" value="http://fonts.googleapis.com"></td></tr><tr></tr><tr></tr><tr><td>28</td><td style="background-color: Green">true</td><td><a href="https://www.facebook.com">https://www.facebook.com</a></td><td>173.252.120.6</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="https://www.facebook.com"></td></tr><tr><td>29</td><td style="background-color: Green">true</td><td><a href="http://www.weebly.com">http://www.weebly.com</a></td><td>74.115.50.110</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.weebly.com"></td></tr><tr></tr><tr></tr><tr><td>32</td><td style="background-color: Green">true</td><td><a href="http://www.gazshocks.com">http://www.gazshocks.com</a></td><td>89.145.92.113</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.gazshocks.com"></td></tr><tr><td>33</td><td style="background-color: Green">true</td><td><a href="http://www.superflex.co.uk">http://www.superflex.co.uk</a></td><td>217.160.164.163</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.superflex.co.uk"></td></tr><tr><td>34</td><td style="background-color: Green">true</td><td><a href="http://www.minilite.co.uk">http://www.minilite.co.uk</a></td><td>91.109.3.34</td><td style="background-color: Green">valid</td><td>GB</td><td><input name="buf_link[]" type="checkbox" value="http://www.minilite.co.uk"></td></tr><tr><td>35</td><td style="background-color: Green">true</td><td><a href="http://www.skandix.de">http://www.skandix.de</a></td><td>87.106.132.15</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.skandix.de"></td></tr><tr><td>36</td><td style="background-color: Green">true</td><td><a href="https://maps.google.com">https://maps.google.com</a></td><td>173.194.122.206</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="https://maps.google.com"></td></tr><tr></tr><tr></tr><tr></tr><tr><td>40</td><td style="background-color: Green">true</td><td><a href="http://l.facebook.com">http://l.facebook.com</a></td><td>173.252.120.6</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://l.facebook.com"></td></tr><tr><td>41</td><td style="background-color: Green">true</td><td><a href="http://www.phpbb.com">http://www.phpbb.com</a></td><td>140.211.15.243</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.phpbb.com"></td></tr><tr><td>42</td><td style="background-color: Green">true</td><td><a href="http://www.stylerbb.net">http://www.stylerbb.net</a></td><td>188.116.19.194</td><td style="background-color: Green">valid</td><td>PL</td><td><input name="buf_link[]" type="checkbox" value="http://www.stylerbb.net"></td></tr><tr></tr><tr></tr><tr><td>45</td><td style="background-color: Green">true</td><td><a href="http://www.caravan.ru">http://www.caravan.ru</a></td><td>185.10.60.252</td><td style="background-color: Green">valid</td><td>RU</td><td><input name="buf_link[]" type="checkbox" value="http://www.caravan.ru"></td></tr><tr></tr><tr><td>47</td><td style="background-color: Green">true</td><td><a href="http://www.altadensidade.com">http://www.altadensidade.com</a></td><td>130.185.84.204</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.altadensidade.com"></td></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>54</td><td style="background-color: Green">true</td><td><a href="http://automobilia.hacets.pt">http://automobilia.hacets.pt</a></td><td>188.93.229.92</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://automobilia.hacets.pt"></td></tr><tr><td>55</td><td style="background-color: Green">true</td><td><a href="http://www.facebook.com">http://www.facebook.com</a></td><td>173.252.120.6</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.facebook.com"></td></tr><tr><td>56</td><td style="background-color: Green">true</td><td><a href="https://plus.google.com">https://plus.google.com</a></td><td>64.233.162.196</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="https://plus.google.com"></td></tr><tr><td>57</td><td style="background-color: Green">true</td><td><a href="http://twitter.com">http://twitter.com</a></td><td>199.16.156.230</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://twitter.com"></td></tr><tr><td>58</td><td style="background-color: Green">true</td><td><a href="http://www.youtube.com">http://www.youtube.com</a></td><td>74.125.205.198</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.youtube.com"></td></tr><tr><td>59</td><td style="background-color: Green">true</td><td><a href="http://www.cm-moita.pt">http://www.cm-moita.pt</a></td><td>194.79.77.215</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.cm-moita.pt"></td></tr><tr><td>60</td><td style="background-color: Green">true</td><td><a href="http://www.jfbb.pt">http://www.jfbb.pt</a></td><td>188.93.225.8</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.jfbb.pt"></td></tr><tr><td>61</td><td style="background-color: Green">true</td><td><a href="http://www.josemata.pt">http://www.josemata.pt</a></td><td>217.23.159.104</td><td style="background-color: Green">valid</td><td>RU</td><td><input name="buf_link[]" type="checkbox" value="http://www.josemata.pt"></td></tr><tr><td>62</td><td style="background-color: Green">true</td><td><a href="http://www.festasdamoita.pt">http://www.festasdamoita.pt</a></td><td>80.172.225.131</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.festasdamoita.pt"></td></tr><tr></tr><tr><td>64</td><td style="background-color: Green">true</td><td><a href="http://salao.hacets.pt">http://salao.hacets.pt</a></td><td>188.93.229.92</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://salao.hacets.pt"></td></tr><tr><td>65</td><td style="background-color: Green">true</td><td><a href="http://www.statcounter.com">http://www.statcounter.com</a></td><td>91.194.204.138</td><td style="background-color: Green">valid</td><td>KR</td><td><input name="buf_link[]" type="checkbox" value="http://www.statcounter.com"></td></tr><tr><td>66</td><td style="background-color: Green">true</td><td><a href="http://my.statcounter.com">http://my.statcounter.com</a></td><td>104.20.2.47</td><td style="background-color: Green">valid</td><td>104.20.2.47</td><td><input name="buf_link[]" type="checkbox" value="http://my.statcounter.com"></td></tr><tr><td>67</td><td style="background-color: Green">true</td><td><a href="http://bbs.keyhole.com">http://bbs.keyhole.com</a></td><td>64.233.165.141</td><td style="background-color: Green">valid</td><td>64.233.165.141</td><td><input name="buf_link[]" type="checkbox" value="http://bbs.keyhole.com"></td></tr><tr><td>68</td><td style="background-color: Green">true</td><td><a href="http://earth.google.com">http://earth.google.com</a></td><td>173.194.122.231</td><td style="background-color: Green">valid</td><td>173.194.122.231</td><td><input name="buf_link[]" type="checkbox" value="http://earth.google.com"></td></tr><tr><td>69</td><td style="background-color: Green">true</td><td><a href="http://postimg.org">http://postimg.org</a></td><td>46.229.168.33</td><td style="background-color: Green">valid</td><td>US</td><td><input name="buf_link[]" type="checkbox" value="http://postimg.org"></td></tr><tr><td>70</td><td style="background-color: Green">true</td><td><a href="http://www.competiauto.com">http://www.competiauto.com</a></td><td>46.105.96.172</td><td style="background-color: Green">valid</td><td>FR</td><td><input name="buf_link[]" type="checkbox" value="http://www.competiauto.com"></td></tr><tr><td>71</td><td style="background-color: Green">true</td><td><a href="http://get.adobe.com">http://get.adobe.com</a></td><td>193.104.215.66</td><td style="background-color: Green">valid</td><td>IE</td><td><input name="buf_link[]" type="checkbox" value="http://get.adobe.com"></td></tr><tr><td>72</td><td style="background-color: Green">true</td><td><a href="http://www.opticacandido.com">http://www.opticacandido.com</a></td><td>109.71.43.161</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.opticacandido.com"></td></tr><tr></tr><tr><td>74</td><td style="background-color: Green">true</td><td><a href="http://www.newbright-carwash.com">http://www.newbright-carwash.com</a></td><td>82.208.18.141</td><td style="background-color: Green">valid</td><td>CZ</td><td><input name="buf_link[]" type="checkbox" value="http://www.newbright-carwash.com"></td></tr><tr></tr><tr><td>76</td><td style="background-color: Green">true</td><td><a href="http://www.solardagiesteira.pt">http://www.solardagiesteira.pt</a></td><td>80.172.225.135</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.solardagiesteira.pt"></td></tr><tr><td>77</td><td style="background-color: Green">true</td><td><a href="http://postimage.org">http://postimage.org</a></td><td>46.229.168.33</td><td style="background-color: Green">valid</td><td>US</td><td><input name="buf_link[]" type="checkbox" value="http://postimage.org"></td></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>112</td><td style="background-color: Green">true</td><td><a href="http://www.diariodosul.com.pt">http://www.diariodosul.com.pt</a></td><td>195.8.58.49</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.diariodosul.com.pt"></td></tr><tr><td>113</td><td style="background-color: Green">true</td><td><a href="http://www.dailymotion.com">http://www.dailymotion.com</a></td><td>195.8.215.138</td><td style="background-color: Green">valid</td><td>FR</td><td><input name="buf_link[]" type="checkbox" value="http://www.dailymotion.com"></td></tr><tr><td>114</td><td style="background-color: Green">true</td><td><a href="http://hondac110.blogspot.com">http://hondac110.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Green">valid</td><td>173.194.71.197</td><td><input name="buf_link[]" type="checkbox" value="http://hondac110.blogspot.com"></td></tr><tr><td>115</td><td style="background-color: Green">true</td><td><a href="http://agulhadourada.blogspot.com">http://agulhadourada.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Green">valid</td><td>173.194.71.197</td><td><input name="buf_link[]" type="checkbox" value="http://agulhadourada.blogspot.com"></td></tr><tr><td>116</td><td style="background-color: Green">true</td><td><a href="http://www.home.golden.net">http://www.home.golden.net</a></td><td>199.166.6.15</td><td style="background-color: Green">valid</td><td>199.166.6.15</td><td><input name="buf_link[]" type="checkbox" value="http://www.home.golden.net"></td></tr><tr><td>117</td><td style="background-color: Green">true</td><td><a href="http://www.ascari.pt">http://www.ascari.pt</a></td><td>195.22.14.118</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.ascari.pt"></td></tr><tr><td>118</td><td style="background-color: Green">true</td><td><a href="http://www.ascari.blogspot.com">http://www.ascari.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Green">valid</td><td>173.194.71.197</td><td><input name="buf_link[]" type="checkbox" value="http://www.ascari.blogspot.com"></td></tr><tr><td>119</td><td style="background-color: Green">true</td><td><a href="http://tiago1275gt.blogspot.com">http://tiago1275gt.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Green">valid</td><td>173.194.71.197</td><td><input name="buf_link[]" type="checkbox" value="http://tiago1275gt.blogspot.com"></td></tr><tr></tr><tr><td>121</td><td style="background-color: Green">true</td><td><a href="http://www.bmw02club.nl">http://www.bmw02club.nl</a></td><td>95.128.3.182</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.bmw02club.nl"></td></tr><tr><td>122</td><td style="background-color: Green">true</td><td><a href="http://bmw2002.terraweb.com.pt">http://bmw2002.terraweb.com.pt</a></td><td>188.93.229.92</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://bmw2002.terraweb.com.pt"></td></tr><tr><td>123</td><td style="background-color: Green">true</td><td><a href="http://carenjoyclube.blogspot.com">http://carenjoyclube.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Green">valid</td><td>173.194.71.197</td><td><input name="buf_link[]" type="checkbox" value="http://carenjoyclube.blogspot.com"></td></tr><tr><td>124</td><td style="background-color: Green">true</td><td><a href="http://www.osmeusclassicos.blogspot.com">http://www.osmeusclassicos.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Green">valid</td><td>173.194.71.197</td><td><input name="buf_link[]" type="checkbox" value="http://www.osmeusclassicos.blogspot.com"></td></tr><tr><td>125</td><td style="background-color: Green">true</td><td><a href="http://www.celicasclub.com">http://www.celicasclub.com</a></td><td>185.11.164.31</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.celicasclub.com"></td></tr><tr><td>126</td><td style="background-color: Green">true</td><td><a href="http://classiccargarage.blogspot.com">http://classiccargarage.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Green">valid</td><td>173.194.71.197</td><td><input name="buf_link[]" type="checkbox" value="http://classiccargarage.blogspot.com"></td></tr><tr><td>127</td><td style="background-color: Green">true</td><td><a href="http://classicos_jreis.blogs.sapo.pt">http://classicos_jreis.blogs.sapo.pt</a></td><td>213.13.145.64</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://classicos_jreis.blogs.sapo.pt"></td></tr><tr><td>128</td><td style="background-color: Green">true</td><td><a href="http://www.classicosmania.com">http://www.classicosmania.com</a></td><td>89.26.240.208</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.classicosmania.com"></td></tr><tr><td>129</td><td style="background-color: Green">true</td><td><a href="http://clubeminileiria.blogspot.com">http://clubeminileiria.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://clubeminileiria.blogspot.com"></td></tr><tr><td>130</td><td style="background-color: Green">true</td><td><a href="http://clubeminiporgaia.com.sapo.pt">http://clubeminiporgaia.com.sapo.pt</a></td><td>213.13.145.4</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://clubeminiporgaia.com.sapo.pt"></td></tr><tr></tr><tr><td>132</td><td style="background-color: Green">true</td><td><a href="http://www.fiatistas.com">http://www.fiatistas.com</a></td><td>104.28.1.87</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.fiatistas.com"></td></tr><tr><td>133</td><td style="background-color: Green">true</td><td><a href="http://www.garagemvw.com">http://www.garagemvw.com</a></td><td>98.131.70.53</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.garagemvw.com"></td></tr><tr><td>134</td><td style="background-color: Green">true</td><td><a href="http://www.hugopecas.com">http://www.hugopecas.com</a></td><td>195.22.8.92</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.hugopecas.com"></td></tr><tr><td>135</td><td style="background-color: Green">true</td><td><a href="http://www.interclassico.com">http://www.interclassico.com</a></td><td>94.23.75.210</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.interclassico.com"></td></tr><tr><td>136</td><td style="background-color: Green">true</td><td><a href="http://joaobotequilha.tripod.com">http://joaobotequilha.tripod.com</a></td><td>209.202.252.50</td><td style="background-color: Green">valid</td><td>209.202.252.50</td><td><input name="buf_link[]" type="checkbox" value="http://joaobotequilha.tripod.com"></td></tr><tr><td>137</td><td style="background-color: Green">true</td><td><a href="http://www.freewebs.com">http://www.freewebs.com</a></td><td>75.98.17.24</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.freewebs.com"></td></tr><tr></tr><tr><td>139</td><td style="background-color: Green">true</td><td><a href="http://www.mario-sequeira.supermano.com">http://www.mario-sequeira.supermano.com</a></td><td>188.93.230.110</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.mario-sequeira.supermano.com"></td></tr><tr><td>140</td><td style="background-color: Green">true</td><td><a href="http://pagequipa.com.sapo.pt">http://pagequipa.com.sapo.pt</a></td><td>213.13.145.4</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://pagequipa.com.sapo.pt"></td></tr><tr><td>141</td><td style="background-color: Green">true</td><td><a href="http://rapaziadadosclassicos.blogspot.com">http://rapaziadadosclassicos.blogspot.com</a></td><td>173.194.71.197</td><td style="background-color: Green">valid</td><td>173.194.71.197</td><td><input name="buf_link[]" type="checkbox" value="http://rapaziadadosclassicos.blogspot.com"></td></tr><tr><td>142</td><td style="background-color: Green">true</td><td><a href="http://www.store-kit.com">http://www.store-kit.com</a></td><td>67.222.1.198</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.store-kit.com"></td></tr><tr><td>143</td><td style="background-color: Green">true</td><td><a href="http://www.superlite-wheels.com">http://www.superlite-wheels.com</a></td><td>172.245.137.57</td><td style="background-color: Green">valid</td><td>172.245.137.57</td><td><input name="buf_link[]" type="checkbox" value="http://www.superlite-wheels.com"></td></tr><tr></tr><tr><td>145</td><td style="background-color: Green">true</td><td><a href="http://vwcarochaportugal.googlepages.com">http://vwcarochaportugal.googlepages.com</a></td><td>173.194.71.121</td><td style="background-color: Green">valid</td><td>173.194.71.121</td><td><input name="buf_link[]" type="checkbox" value="http://vwcarochaportugal.googlepages.com"></td></tr><tr><td>146</td><td style="background-color: Green">true</td><td><a href="http://www.addthis.com">http://www.addthis.com</a></td><td>208.49.103.220</td><td style="background-color: Green">valid</td><td>208.49.103.220</td><td><input name="buf_link[]" type="checkbox" value="http://www.addthis.com"></td></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>208</td><td style="background-color: Green">true</td><td><a href="http://www.meteomoita.com">http://www.meteomoita.com</a></td><td>213.239.218.173</td><td style="background-color: Green">valid</td><td>DE</td><td><input name="buf_link[]" type="checkbox" value="http://www.meteomoita.com"></td></tr><tr><td>209</td><td style="background-color: Green">true</td><td><a href="http://www.brasil.adobe.com">http://www.brasil.adobe.com</a></td><td>192.150.16.117</td><td style="background-color: Green">valid</td><td>192.150.16.117</td><td><input name="buf_link[]" type="checkbox" value="http://www.brasil.adobe.com"></td></tr><tr><td>210</td><td style="background-color: Green">true</td><td><a href="http://issuu.com">http://issuu.com</a></td><td>174.129.235.52</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://issuu.com"></td></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>223</td><td style="background-color: Green">true</td><td><a href="http://www.ufbbva.pt">http://www.ufbbva.pt</a></td><td>188.93.225.8</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.ufbbva.pt"></td></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>284</td><td style="background-color: Green">true</td><td><a href="http://www.iperrent.pt">http://www.iperrent.pt</a></td><td>193.126.240.145</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.iperrent.pt"></td></tr><tr></tr><tr></tr><tr></tr><tr><td>288</td><td style="background-color: Green">true</td><td><a href="http://www.adsbb.pt">http://www.adsbb.pt</a></td><td>188.93.225.8</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.adsbb.pt"></td></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr><td>299</td><td style="background-color: Green">true</td><td><a href="http://www.clube600500.net">http://www.clube600500.net</a></td><td>211.132.123.122</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.clube600500.net"></td></tr><tr></tr><tr><td>301</td><td style="background-color: Green">true</td><td><a href="http://www.clubedorio.com">http://www.clubedorio.com</a></td><td>216.8.179.25</td><td style="background-color: Green">valid</td><td>216.8.179.25</td><td><input name="buf_link[]" type="checkbox" value="http://www.clubedorio.com"></td></tr><tr><td>302</td><td style="background-color: Green">true</td><td><a href="http://www.twitter.com">http://www.twitter.com</a></td><td>199.16.156.70</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.twitter.com"></td></tr><tr><td>303</td><td style="background-color: Green">true</td><td><a href="http://s16.sitemeter.com">http://s16.sitemeter.com</a></td><td>63.135.90.205</td><td style="background-color: Green">valid</td><td>63.135.90.205</td><td><input name="buf_link[]" type="checkbox" value="http://s16.sitemeter.com"></td></tr><tr><td>304</td><td style="background-color: Green">true</td><td><a href="http://s1274.beta.photobucket.com">http://s1274.beta.photobucket.com</a></td><td>209.17.80.1</td><td style="background-color: Green">valid</td><td>209.17.80.1</td><td><input name="buf_link[]" type="checkbox" value="http://s1274.beta.photobucket.com"></td></tr><tr></tr><tr></tr><tr><td>307</td><td style="background-color: Green">true</td><td><a href="http://www.adobe.com">http://www.adobe.com</a></td><td>193.104.215.61</td><td style="background-color: Green">valid</td><td>IE</td><td><input name="buf_link[]" type="checkbox" value="http://www.adobe.com"></td></tr><tr></tr><tr><td>309</td><td style="background-color: Green">true</td><td><a href="http://www.d-w.pt">http://www.d-w.pt</a></td><td>130.185.86.90</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.d-w.pt"></td></tr><tr><td>310</td><td style="background-color: Green">true</td><td><a href="http://www.westfield-sportscars.pt">http://www.westfield-sportscars.pt</a></td><td>217.23.159.104</td><td style="background-color: Green">valid</td><td>RU</td><td><input name="buf_link[]" type="checkbox" value="http://www.westfield-sportscars.pt"></td></tr><tr></tr><tr></tr><tr><td>313</td><td style="background-color: Green">true</td><td><a href="http://www.dispnal.pt">http://www.dispnal.pt</a></td><td>109.71.43.105</td><td style="background-color: Green">valid</td><td>PT</td><td><input name="buf_link[]" type="checkbox" value="http://www.dispnal.pt"></td></tr><tr><td>314</td><td style="background-color: Green">true</td><td><a href="http://www.beta-tools.com">http://www.beta-tools.com</a></td><td>5.8.101.12</td><td style="background-color: Red">in database</td><td>null</td><td><input name="buf_link[]" type="checkbox" value="http://www.beta-tools.com"></td></tr><tr><td>315</td><td style="background-color: Green">true</td><td><a href="http://www.bompiso.com">http://www.bompiso.com</a></td><td>104.27.135.227</td><td style="background-color: Green">valid</td><td>104.27.135.227</td><td><input name="buf_link[]" type="checkbox" value="http://www.bompiso.com"></td></tr><tr><td>316</td><td style="background-color: Green">true</td><td><a href="http://youtu.be">http://youtu.be</a></td><td>173.194.122.229</td><td style="background-color: Green">valid</td><td>173.194.122.229</td><td><input name="buf_link[]" type="checkbox" value="http://youtu.be"></td></tr><tr></tr><tr></tr><tr></tr></tbody></table>
