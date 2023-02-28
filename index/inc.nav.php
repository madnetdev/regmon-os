	<nav id="nav-header" class="navbar navbar-custom">
		<div id="nav-header-container" class="container-fluid navbar-container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<img id="nav-header-logo" src="img/regman-logo-250-50.png">
				<span id="dashboard_link2" class="fa fa-th"></span>				
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php /*<li><a href="offline/" class="nav_offline" style="color:#ddd;" target="_blank"><i class="fa fa-wifi" style="font-size:14px; color:#ddd;"></i> &nbsp; Offline</a></li>@@@@@@@@@@@@@ offline disabled for now*/?>
					
				<?php /* if ($ADMIN) { ?>
					<li><a href="administration.php" class="nav_link nav_admin"><i class="fa fa-cogs"></i> &nbsp; <?=$LANG->ADMIN;?></a></li>
				<?php  } @@@@@@@@@@@@@@@@ admin page disabled for now*/?>

					<?php /*<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart"></i> &nbsp; <?=$LANG->RESULTS;?> &nbsp; <b class="caret"></b></a>
						<ul class="dropdown-menu" style="padding:1px;">
							<li><a href="results.php" class="nav_link nav_results_group" style="font-size:15px;"><i class="fa fa-bar-chart"></i> &nbsp;<i class="fa fa-user"></i>&nbsp; &nbsp; <?=$LANG->RESULTS;?></a></li>
							<li><a href="results_groups.php" class="nav_link nav_results_group" style="font-size:15px;"><i class="fa fa-bar-chart"></i> <i class="fa fa-users"></i> &nbsp; <?=$LANG->RESULTS_GROUP;?></a></li>
						</ul>
					</li>@@@@@@@@@@@@@@@@ results disabled for now*/?>
			
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:15px; padding-right:10px;"><img src="img/flags/<?=$LANG->LANG_CURRENT;?>.png" title="" style="margin:-10px 0 -5px 0;" />&nbsp;&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu" style="padding:1px; min-width:120px;">
							<li <?=($LANG->LANG_CURRENT=='en'?' class="active"':'');?>><a href="javascript:void(0)" id="lang_en"><img src="img/flags/en.png" /> &nbsp;<?=$LANG->LANG_ENGLISH;?></a></li>
							<li <?=($LANG->LANG_CURRENT=='de'?' class="active"':'');?>><a href="javascript:void(0)" id="lang_de"><img src="img/flags/de.png" /> &nbsp;<?=$LANG->LANG_GERMAN;?></a></li>
						</ul>
					</li>
					
					<li><a href="index/box.regman_info.php" class="nav_link nav_profile fancybox fancybox.ajax"><i class="fa fa-info-circle"></i></a></li>
					<li><a href="login/box.profile_edit.php" class="nav_link nav_profile fancybox fancybox.ajax"><i class="fa fa-user"></i> &nbsp; <?=$LANG->USER_PROFILE;?></a></li>
					<li><a href="login/logout.php" class="nav_link nav_logout"><i class="fa fa-lock"></i> &nbsp; <?=$LANG->LOGOUT;?></a></li>
				</ul>
			</div>
		</div>
	</nav>
