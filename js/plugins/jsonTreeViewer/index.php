<?php
require_once('../../../_settings.regmon.php');
require('../../../login/validate.php');
$PATH_2_ROOT = '../../../';

$file = isset($_GET['file']) ? $_GET['file'] : false;
$mode = 'trackers';
$uid = $UID;
$group = $GROUP;

$file_mode = false;
$separator = ',';
$json = '{}';
if ($file ) {
	$dir = $PATH_2_ROOT . $CONFIG['REGmon_Files'] . $mode .'/'. $uid .'/'. $group .'/';
	$get_file = realpath($dir.'/'.$file);
	if (is_file($get_file)) {
		$ext = strtolower(pathinfo($get_file, PATHINFO_EXTENSION));
		$file_parse = file_get_contents($get_file);
		if ($ext == 'json' AND isJson($file_parse)) { //json
			$file_mode = 'json';
		}
		elseif ($ext == 'csv') { //csv -EquaScan
			$file_mode = 'csv';
			$separator = ',';
			//$file_parse = utf8_encode($file_parse);
			$tmp = explode("\n", $file_parse);
			$line0 = $tmp[0];
			$comma = substr_count($line0, ',');
			$erotimatiko = substr_count($line0, ';');
			$tab = substr_count($line0, "\t");
			if ($erotimatiko > $comma AND $erotimatiko > $tab) $separator = ';';
			if ($tab > $comma AND $tab > $erotimatiko) $separator = "\t";
			//EquaScan has 1st line for nothing and headers in 2nd line
			//if (strpos($tmp[0], 'Anlage ') === 0) $file_parse = str_replace($tmp[0]."\n", '', $file_parse);
			//$file_parse = str_replace(';(TypG) ;', ';', $file_parse);
		}
	}
}

function isJson($str) {
	json_decode($str);
	return (json_last_error() == JSON_ERROR_NONE);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>jsonTreeViewer</title>
<meta charset="utf-8" />
<link href="libs/app/reset.css" rel="stylesheet" />
<link href="libs/app/app.css" rel="stylesheet" />
<link href="libs/jsonTree/jsonTree.css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="<?=$PATH_2_ROOT;?>node_modules/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?=$PATH_2_ROOT;?>node_modules/@fontsource/pt-mono/latin.css" />

<style>
/*loading*/
.ajaxOverlay {z-index:10000; border:none; margin:0px; padding:0px; width:100%; height:100%; top:0px; left:0px; opacity:0.6; cursor:wait; position:fixed; background-color:rgb(0, 0, 0);}
.ajaxMessage {z-index:10011; position:fixed; padding:0px; margin:0px; width:30%; top:40%; left:35%; text-align:center; color:rgb(255, 255, 0); border:0px; cursor:wait; text-shadow:red 1px 1px; font-size:18px; background-color:transparent;}
</style>
</head>
<body class="jsontree_bg">
 	<div id="loading" class="ajaxOverlay" style="display:none">
		<div class="ajaxMessage"><img src="<?=$PATH_2_ROOT;?>img/ldg.gif"></div>
	</div>

<?php //## json ###########################################################
########################################################################
if ($file_mode == 'json') { ?>

	<!-- Buttons -->
	<header id="header">
		<nav id="nav" class="clearfix">
			<ul class="menu menu_level1" style="padding-left:50px;">
				<li data-action="expand" class="menu__item"><span class="menu__item-name"><i class="fa fa-plus-square-o"></i> expand all</span></li>
				<li data-action="collapse" class="menu__item"><span class="menu__item-name"><i class="fa fa-minus-square-o"></i> collapse all</span></li>
				<li data-action="find_and_mark" class="menu__item"><span class="menu__item-name"><i class="fa fa-search-plus"></i> find and mark</span></li>
				<li data-action="unmark_all" class="menu__item"><span class="menu__item-name"><i class="fa fa-search-minus"></i> unmark all</span></li>
			</ul>
		</nav>
		<div id="coords"></div>
		<div id="debug"><!--<span id="time"></span>--></div>
	</header>

	<!-- json tree -->
	<div id="wrapper">
		<div style="text-align:center; font-size:17px;"><?=$file;?></div>
		<div id="tree"></div>
	</div>

	<!-- Find nodes form -->
	<form id="find_nodes_form" class="form" data-header="Find nodes">
		<section>
			<p><label><input type="radio" name="nodes_search_type" value="label" id="nodes_search_by_label" checked="checked" /> By label name:</label></p>
			<input type="text" id="search_by_label_name" />
		</section>
		<section>
			<p><label><input type="radio" name="nodes_search_type" id="nodes_search_by_type" value="type" /> By value type:</label></p>
			<ul class="checkboxes">
				<li><label><input type="checkbox" name="nodes_type" value="string" /> string</label></li>
				<li><label><input type="checkbox" name="nodes_type" value="number" /> number</label></li>
				<li><label><input type="checkbox" name="nodes_type" value="boolean" /> boolean</label></li>
				<li><label><input type="checkbox" name="nodes_type" value="null" /> null</label></li>
				<li><label><input type="checkbox" name="nodes_type" value="object" /> object</label></li>
				<li><label><input type="checkbox" name="nodes_type" value="array" /> array</label></li>
			</ul>
		</section>
		<button id="find_button">Find and mark</button>
	</form>

<script type="text/javascript" src="<?=$PATH_2_ROOT;?>node_modules/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="libs/app/App.js"></script>
<script type="text/javascript" src="libs/jsonTree/jsonTree.js"></script>
<script type="text/javascript" src="jsonTreeViewer.js"></script>

<script>
var loading;
$(function() {
	loading = $("#loading");
	$('ul.checkboxes li input').on('change', function() {
		$('#nodes_search_by_type').trigger("click");
	});
	jsonTreeViewer.no_parse(json);
});
var json = <?=$file_parse;?>;
</script>
	
<?php //## csv ############################################################
########################################################################
} elseif ($file_mode == 'csv') { ?>

	<?php /*<div class="container">*/?>
		<div style="text-align:center; font-size:17px;"><?=$file;?></div>
		<div class="row">
			<div class="col-md-12">
				<div class="output"></div>
			</div>
		</div>
	<?php /*</div>*/?>

<link type="text/css" rel="stylesheet" href="<?=$PATH_2_ROOT;?>node_modules/bootstrap/dist/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="<?=$PATH_2_ROOT;?>node_modules/bootstrap/dist/css/bootstrap-theme.min.css">
<script type="text/javascript" src="<?=$PATH_2_ROOT;?>node_modules/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="<?=$PATH_2_ROOT;?>node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=$PATH_2_ROOT;?>node_modules/jquery-csv/src/jquery.csv.min.js"></script>
<script type="text/javascript" src="csv_2_table.js?mad"></script>
	
<script>
var loading;
$(function() {
	loading = $("#loading");
	//csvToHtml($('.source'), $('.output'), {separator:'<?=$separator;?>'});
	csvToHtml_QueryCSV($('.source'), $('.output'), '<?=$separator;?>');
	//console.log($.csv.toArrays($('.source').val()));
});
</script>
<textarea class="source" style="display:none;"><?=$file_parse;?></textarea>

<?php } ?>
</body>
</html>
