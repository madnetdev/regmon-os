<?php 
// load language & database ##########
require_once('no_validate.php');
// ###################################
$PATH_2_ROOT = '../';

if ($_POST) {
	$uname = $_POST['uname'] ?? false;
	$sport = $_POST['sport'] ?? false;
	$code = $_POST['code'] ?? false;
	$sport_group = $_POST['sport_group'] ?? false;
}
else {
	$uname = $_GET['uname'] ?? false;
	$sport = $_GET['sport'] ?? false;
	$code = $_GET['code'] ?? false;
	$sport_group = $_GET['sport_group'] ?? false;
}
if (!$uname OR !$sport OR !$code) exit;
if (!$sport_group OR $sport_group == '') $sport_group = 0;

$mes = '';
$new_data = false;
$rows = $db->fetchRow("SELECT name FROM sports WHERE status = 1 AND name = ?", array($sport)); 
if ($db->numberRows() > 0)  {
	$mes = $LANG->REGISTER_SPORT_EXIST; //'Already Exist Sport';
}
else {
	$activate_sport_code = MD5($CONFIG['SEC_Encrypt_Secret'] . $uname.$sport);
	if ($activate_sport_code == $code) 
	{
		if ($_POST) 
		{
			//Insert Sport
			$values = array();
			$values['sport_group_id'] = $sport_group;
			$values['name'] = $sport;
			$values['modified'] = get_date_time_SQL('now');
			$values['created'] = get_date_time_SQL('now');
			
			$db->insert($values, "sports");
			
			
			//Update User
			$user = $db->fetchRow("SELECT * FROM users WHERE uname = ?", array($uname)); 
			if ($db->numberRows() > 0)  {
				$valuesU = array();
				if ($user['sport'] == '') {
					$valuesU['sport'] = $sport;
				} else {
					$valuesU['sport'] = $user['sport'] . ',' . $sport;
				}
				
				$db->update($valuesU, "users", "uname=?", array($uname));
			}
		}
	}
	else {
		$mes = $LANG->REGISTER_ACTIVATE_CODE_ERROR;
	}
}

//#####################################################################################
$title = $LANG->REGISTER_APPROVE_PROPOSAL;
require($PATH_2_ROOT.'php/inc.head.php');
//#####################################################################################
?>
</head>
<body>

<?php require($PATH_2_ROOT.'php/inc.header.php');?>

<div style="text-align:center;">
	<a href="." id="home" class="home"> &nbsp; <?=$LANG->HOMEPAGE;?></a>
</div>

<div class="container">
	<div class="row">
        <div class="col-md-12" style="text-align:center; padding-top:80px;">
         	<h1 style="color:#333"><?=$LANG->REGISTER_APPROVE_PROPOSAL;?></h1>
			<br>
			<h3 style="color: #0000ff"><?=$LANG->REGISTER_SPORT;?> : <b><u><?=$sport;?></u></b></h3>
	<?php if ($mes != '') { ?>
			<h3 style="color: #ff0000"><?=$mes;?></h3>
	<?php } else { ?>
		<?php if (!$_POST) { ?>
			<form name="form1" id="wrapped" action="new_sport_suggestion.php" method="POST">
				<input type="hidden" name="sport" value="<?=$sport;?>">
				<input type="hidden" name="uname" value="<?=$uname;?>">
				<input type="hidden" name="code" value="<?=$code;?>">
				<h4>
					<?=$LANG->REGISTER_SPORT_GROUP_SEL;?> : 
					<div class="styled-select" style="margin:15px 0;">
						<select name="sport_group" class="form-control">
							<option value=""><?=$LANG->REGISTER_SPORT_GROUP;?></option>
							<?php
								//Sports Groups Select Options
								$sport_groups_options = ''; 
								$rows = $db->fetch("SELECT o.id, o.options 
										FROM dropdowns d
										LEFT JOIN dropdowns o ON o.idd = d.id
										WHERE d.name='Sport_Groups' AND o.status=1 ORDER BY o.options", array()); 
								if ($db->numberRows() > 0)  {
									foreach ($rows as $row) {
										$sport_groups_options .= '<option value="'.$row['id'].'">'.$row['options'].'</option>';
									}
								}
								echo $sport_groups_options;
							?>
						</select>
					</div>
				</h4>
				<button type="submit" name="forward" class="forward"><?=$LANG->REGISTER_SUBMIT;?>&nbsp; &nbsp;</button>
			</form>
		<?php } else { ?>
			<h3 style="color: #6C3"><?=$LANG->REGISTER_APPROVED;?></h3>
		<?php } ?>
	<?php } ?>
        </div>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<?php //require($PATH_2_ROOT.'php/inc.footer.php');?>

</body>
</html>