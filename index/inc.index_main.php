<?php // inc index main ?>

	<div id="main_container" class="container">	
		<?php /*<header>
			<h1><b><?=$LANG->APP_NAME;?></b><span><?=$LANG->APP_INFO;?></span></h1>	
		</header>*/?>
		<?php /*<h3 style="text-align:center;"><b><u><?=$selected_LOCATION_name;?></u></b></h3>*/?>
		<?php /*<h2 style="text-align:center;"><b><?=$selected_GROUP_name;?></b></h2>*/?>
		
		<div class="col-md-12 main_container">
			<div id="main_container_top" class="row top_container" style="padding:7px 0px 9px;">
				<div class="col-sm-12">
					<h3 id="location_name" style="float:left;"><b><u><?=$selected_LOCATION_name;?></u></b></h3>	
					<div id="group_n_athlete">
						<div id="GRP_select_row" style="margin-top:2px;">
							<span id="GRP_select_title" style="font-size:18px; vertical-align:middle;"><?=$LANG->INDEX_GROUP;?> : &nbsp; </span> 
							<select name="GRP_select" id="GRP_select" style="width:100%; max-width:350px; font-size:17px; vertical-align:middle; color:#444; font-weight:bold;">
								<?php if (substr_count($GP_select_options, '<option') AND count($private_groups)) echo '<option></option>';?>
								<?=$GP_select_options;?>
							</select>
							<div id="private_group" class="form-group" style="margin:0px; margin-bottom:-12px; display:inline-block; display:none;">
								<div class="input-group" style="width:100%; white-space:nowrap; max-width:350px; box-shadow:0 0 3px #777; border-radius:4px;">
									<input type="text" id="private_key" name="private_key" value="" class="form-control" style="width:100%; display:inline-block; height:28px;" placeholder="<?=$LANG->PRIVATE_KEY;?>"/>
									<span id="private_submit" title="<?=$LANG->REQUEST_FOR_GROUP;?>" class="input-group-addon" style="width:100px; cursor:pointer; color:blue; border-right-width:2px;"><span class="fa fa-sign-in"></span> &nbsp; <span class="fa fa-group"></span></span>
									<span id="private_close" title="<?=$LANG->BACK;?>" class="input-group-addon" style="padding:6px; cursor:pointer; color:red;"><span class="fa fa-times-circle"></span></span>
								</div>
							</div>
						</div>
						<div id="ATH_select_row">
							<span style="display:inline-block; width:100%; max-width:500px;"><?php /*345*/?>
								<div id="ATH_name_div" style="margin-top:8px; margin-bottom:1px; color:#333333;"><?=$Athlete_Name;?></div>
								<div id="ATH_select_div" style="margin-top:8px; width:100%; display:none;"><?=$Athletes_Select;?></div>
							</span>
						</div>
						<div id="VIEW_select_row">
							<span id="view_radio" style="position:relative; display:inline-block; margin-top:10px;">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-default" style="font-size:15px; padding:3px 12px; box-shadow:0 0 3px #777;"><input type="radio" name="options_calendar" id="view_calendar" autocomplete="off" checked><i class="fa fa-calendar"></i> &nbsp; <?=$LANG->VIEW_CALENDAR;?></label>
									<label class="btn btn-default" style="font-size:15px; padding:3px 12px; box-shadow:0 0 3px #777;"><input type="radio" name="options_calendar" id="view_options" autocomplete="off"><i class="fa fa-gear"></i> &nbsp; <?=$LANG->VIEW_OPTIONS;?>
									</label>
								</div>
								<span id="requestsCount">
									<span id="requestsCountValue">0</span>
								</span>
								<img id="rC_loading" style="width:32px; top:-2px; right:75px;" src="img/ldg.gif">
							</span>
						</div>
						<div class="shadow" style="bottom:-15px;"></div>
					</div>
				</div>
			</div>
			
			<div id="views">
			
				<div id="group_calendar" class="row">
					<div id="calendar"></div>
				</div>
				
<?php /* ############################################################### */?>
<?php /* DISABLED FOR FISRT VERSION @@@@@@@@@@@######################### */?>
<?php /* ############################################################### */?>
<div style="display:none;">
				<div id="group_data" class="row">
					<?php /* LEFT SIDE ################################################################ */?>
					<div class="col-sm-6">
						<div class="panel-group" id="accordion1">
						<?php /*##### Athlete - Edit Selection of Forms ##########################################################*/?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion1" href="#C_Athlete_Forms_Select" id="C_Athlete_Forms_Select_link" class="collapsed"><?=$LANG->MY_FORM_SELECTION;?> ( <?=$selected_GROUP_name;?> )</a>
									</h4>
								</div>
								<div id="C_Athlete_Forms_Select" class="panel-collapse collapse">
									<div class="panel-body" style="text-align:center;">
										<?php /*###### Athlete_Forms_Select_Menu AJAX ######*/?>
										<nav id="A_Athlete_Forms_Select_Menu" class="nav shadow1"></nav>
									</div>
								</div>
							</div>
						<?php /*##### Import-Export Data - ALL ##########################################################################*/?>
							<div class="panel panel-default"<?=((!$ATHLETE)?' style="margin-top:6px;"':'');?>>
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion1" href="#C_Export_Data" id="C_Export_Data_link" class="collapsed"><?=$LANG->IMPORT_EXPORT_TAB;?></a>
									</h4>
								</div>
								<div id="C_Export_Data" class="panel-collapse collapse">
									<div class="panel-body" style="padding:2px;">
										<?php /*###### Export Data Button ######*/?>
										<div style="text-align:center; padding:15px;">
											<button type="button" class="export"><?=$LANG->EXPORT_LINK;?> &nbsp; </button>
										</div>
										<?php /*###### Import Data Button ######*/?>
										<div style="text-align:center; padding:15px;">
											<button type="button" class="import"><?=$LANG->IMPORT_LINK;?> &nbsp; </button>
										</div>
									</div>
								</div>
							</div>
			<?php  if ($ADMIN OR $LOCATION_ADMIN OR $GROUP_ADMIN OR $GROUP_ADMIN_2) { ?>
				<?php  if (!$ADMIN AND !$THIS_LOCATION_ADMIN AND !$THIS_GROUP_ADMIN AND !$THIS_GROUP_ADMIN_2) $dis_panel = true; else $dis_panel = false; ?>
						<?php /*##### Group Requests ##############################################################################*/?>
							<div class="panel panel-default"<?=($dis_panel?$DIS:'');?> style="margin-top:8px;">
								<div class="panel-heading h_group_admin">
									<h4 class="panel-title" style="position:relative;">
										<a data-toggle="collapse" data-parent="#accordion1" href="#C_Group_Requests" id="C_Group_Requests_link" class="collapsed"><?=$LANG->GROUP_ACCESS_TAB;?> ( <?=$selected_GROUP_name;?> )</a>
										<span id="GRP_requestsCount">
											<span id="GRP_requestsCountValue">0</span>
										</span>
									</h4>
								</div>
								<div id="C_Group_Requests" class="panel-collapse collapse">
									<div class="panel-body">
										<?php /*###### Group Requests AJAX ######*/?>
										<nav id="A_Group_Requests" class="nav"></nav>
									</div>
								</div>
							</div>
						<?php /*##### Group Users #################################################################################*/?>
							<div class="panel panel-default"<?=($dis_panel?$DIS:'');?> style="margin-top:6px; margin-bottom:7px;">
								<div class="panel-heading h_group_admin">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion1" href="#C_Group_Users" id="C_Group_Users_link" class="collapsed"><?=$LANG->GROUP_USERS;?><span id="GROUPS_name"><?=' &nbsp; ( '.$selected_GROUP_name.' )';?></span></a>
									</h4>
								</div>
								<div id="C_Group_Users" class="panel-collapse collapse">
									<div class="panel-body" style="padding:2px;">
										<?php /*###### Group Users AJAX ######*/?>
										<div id="A_Group_Users"></div>
									</div>
								</div>
							</div>
			<?php  } //if ($ADMIN OR $LOCATION_ADMIN OR $GROUP_ADMIN OR $GROUP_ADMIN_2) ?>
						<?php /*##### Exit Group - ALL ############################################################################*/?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion1" href="#C_Group_Leave" id="C_Group_Leave_link" class="collapsed"><?=$LANG->GROUP_LEAVE_TAB;?> ("<?=$selected_GROUP_name;?>")</a>
									</h4>
								</div>
								<div id="C_Group_Leave" class="panel-collapse collapse">
									<div class="panel-body" style="padding:2px;">
										<?php /*###### Group Leave Button ######*/?>
										<div id="group_buttons_message_in" style="text-align:center; display:none; margin:20px 0;"></div>
										<div style="text-align:center; padding:5px 0 20px;"><?php /*REQUEST_USER_LEAVE_GROUP*/?>
											<button id="group_user_cancel_access_user" type="submit" class="submit_group" style="vertical-align:middle; display:none;"><?=$LANG->GROUP_LEAVE_TAB;?> ("<?=$selected_GROUP_name;?>") &nbsp; &nbsp; &nbsp; </button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php /* ##################################################################################### */?>
					<?php /* RIGHT SIDE ########################################################################## */?>
					<?php /* ##################################################################################### */?>
					<div class="col-sm-6">
						<div class="panel-group" id="accordion2">
			<?php if ($TRAINER) { //Trainers --admin and others to fisrt column ?>
				<?php if (!$THIS_GROUP_TRAINER) $dis_panel = true; else $dis_panel = false; ?>
				<?php if ($THIS_GROUP_TRAINER) { //new only if trainer and trainer-group ?>
						<?php /*##### Request_Access_From_Athletes ################################################################*/?>
							<div class="panel panel-default"<?=($dis_panel?$DIS:'');?> style="margin-top:-1px;">
								<div class="panel-heading h_trainer">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Request_Access_From_Athletes" id="C_Request_Access_From_Athletes_link" class="collapsed"><?=$LANG->TRAINER_REQUEST_ATHLETES;?></a>
									</h4>
								</div>
								<div id="C_Request_Access_From_Athletes" class="panel-collapse collapse">
									<div class="panel-body" style="padding:2px;">
										<?php /*###### Request_Access_From_Athletes AJAX ######*/?>
										<div id="A_Request_Access_From_Athletes"></div>
									</div>
								</div>
							</div>
						<?php /*######## Show FormsSelect approvals from Athletes to Trainers ######################################*/?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Trainer_Access_To_Athletes_Forms" id="C_Trainer_Access_To_Athletes_Forms_link" class="collapsed"><?=$LANG->FORMS_APPROVE_TITLE_SHOW;?></a>
									</h4>
								</div>
								<div id="C_Trainer_Access_To_Athletes_Forms" class="panel-collapse collapse">
									<div class="panel-body" style="text-align:center;">
										<?php /*###### Trainer_Access_To_Athletes_Forms AJAX ######*/?>
										<nav id="A_Trainer_Access_To_Athletes_Forms" class="nav shadow1"></nav>
									</div>
								</div>
							</div>
				<?php } //if ($THIS_GROUP_TRAINER) ?>
			<?php } //if ($TRAINER) ?>
			<?php  if ($ATHLETE) { //mono Athletes ?>
						<?php /*##### Requests from Trainers ################################################################*/?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title" style="position:relative;">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Requests_From_Trainers" id="C_Requests_From_Trainers_link" class="collapsed"><?=$LANG->ATHLETE_REQUEST_FROM_TRAINER;?></a>
										<span id="ATH_requestsCount">
											<span id="ATH_requestsCountValue">0</span>
										</span>
									</h4>
								</div>
								<div id="C_Requests_From_Trainers" class="panel-collapse collapse">
									<div class="panel-body">
										<?php /*###### Requests from Trainers AJAX ######*/?>
										<nav id="A_Requests_From_Trainers" class="nav"></nav>
									</div>
								</div>
							</div>
						<?php /*######## Athlete_Give_Forms_Access_To_Trainers ##################################################*/?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Athlete_Give_Forms_Access_To_Trainers" id="C_Athlete_Give_Forms_Access_To_Trainers_link" class="collapsed"><?=$LANG->FORMS_APPROVE_TITLE;?></a>
									</h4>
								</div>
								<div id="C_Athlete_Give_Forms_Access_To_Trainers" class="panel-collapse collapse">
									<div class="panel-body" style="text-align:center;">
										<?php /*###### Athlete_Give_Forms_Access_To_Trainers AJAX ######*/?>
										<nav id="A_Athlete_Give_Forms_Access_To_Trainers" class="nav shadow1"></nav>
									</div>
								</div>
							</div>
			<?php  } //if ($ATHLETE) { //mono Athletes ?>
			<?php  if ($ADMIN OR $LOCATION_ADMIN OR $GROUP_ADMIN OR $GROUP_ADMIN_2) { ?>
				<?php  if (!$ADMIN AND !$THIS_LOCATION_ADMIN AND !$THIS_GROUP_ADMIN AND !$THIS_GROUP_ADMIN_2) $dis_panel = true; else $dis_panel = false; ?>
				<?php  if ($ADMIN OR $THIS_LOCATION_ADMIN OR $THIS_GROUP_ADMIN OR $THIS_GROUP_ADMIN_2) { //new only when 'this' admin can see that ?>
						<?php /*######## Group_Forms_Select ####################################################################*/?>
							<div class="panel panel-default" style="margin-top:-1px;<?=($dis_panel?$DIS2:'');?>">
								<div class="panel-heading h_group_admin">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Group_Forms_Select" id="C_Group_Forms_Select_link" class="collapsed"><?=$LANG->GROUP_FORMS_TAB;?> (<?=$LANG->GROUP;?>: "<?=$selected_GROUP_name;?>")</a>
									</h4>
								</div>
								<div id="C_Group_Forms_Select" class="panel-collapse collapse">
									<div class="panel-body" style="text-align:center;">
										<?php /*###### Group_Forms_Select AJAX ######*/?>
										<nav id="A_Group_Forms_Select" class="nav shadow1"></nav>
									</div>
								</div>
							</div>
						<?php /*##### Forms Grid #################################################################################*/?>
							<div class="panel panel-default"<?=((!$ADMIN AND !$THIS_LOCATION_ADMIN AND !$THIS_GROUP_ADMIN AND !$THIS_GROUP_ADMIN_2)?' style="margin-top:-1px;"':'');?>>
								<div class="panel-heading h_group_admin">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Forms" id="C_Forms_link" class="collapsed"><?=$LANG->FORMS_TITLE;?></a>
									</h4>
								</div>
								<div id="C_Forms" class="panel-collapse collapse">
									<div class="panel-body" style="padding:2px;">
										<?php /*###### Forms Grid AJAX ######*/?>
										<div id="A_Forms"></div>
									</div>
								</div>
							</div>
						<?php /*##### Categories ########################################################################################*/?>
							<div class="panel panel-default"<?=((!$ADMIN AND !$THIS_LOCATION_ADMIN AND !$THIS_GROUP_ADMIN AND !$THIS_GROUP_ADMIN_2)?' style="margin-top:-1px;"':'');?>>
								<div class="panel-heading h_group_admin">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Categories" id="C_Categories_link" class="collapsed"><?=$LANG->CATEGORIES_TITLE;?></a>
									</h4>
								</div>
								<div id="C_Categories" class="panel-collapse collapse">
									<div class="panel-body" style="padding:2px;">
										<?php /*###### Categories Grid AJAX ######*/?>
										<div id="A_Categories"></div>
									</div>
								</div>
							</div>
						<?php /*Sports Dropdowns*/?>
							<div class="panel panel-default" style="margin-top:6px;">
								<div class="panel-heading h_group_admin">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Sports_Dropdowns" id="C_Sports_Dropdowns_link" class="collapsed"><?=$LANG->SPORTS_DROPDOWNS;?></a>
									</h4>
								</div>
								<div id="C_Sports_Dropdowns" class="panel-collapse collapse">
									<div class="panel-body" style="padding:2px;">
										<?php /*###### Sports Dropdowns AJAX ######*/?>
										<div id="A_Sports_Dropdowns"></div>
									</div>
								</div>
							</div>
				<?php  } //if $ADMIN OR $THIS_LOCATION_ADMIN OR $THIS_GROUP_ADMIN OR $THIS_GROUP_ADMIN_2 ?>
			<?php  } //if ($ADMIN OR $LOCATION_ADMIN OR $GROUP_ADMIN OR $GROUP_ADMIN_2) ?>
			<?php  if ($ADMIN OR $LOCATION_ADMIN OR $GROUP_ADMIN OR $GROUP_ADMIN_2) { ?>
						<?php /*Location Groups*/?>
							<div class="panel panel-default">
								<div class="panel-heading h_location_admin">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion2" href="#C_Location_Groups" id="C_Location_Groups_link" class="collapsed"><?=$LANG->LOCATION_GROUPS;?><span id="LOCATION_GROUPS_name"><?=' &nbsp; ( '.$selected_LOCATION_name.' )';?></span></a>
									</h4>
								</div>
								<div id="C_Location_Groups" class="panel-collapse collapse">
									<div class="panel-body" style="padding:2px;">
										<?php /*###### Location Groups AJAX ######*/?>
										<div id="A_Location_Groups"></div>
									</div>
								</div>
							</div>
			<?php  } //if ($ADMIN OR $LOCATION_ADMIN OR $GROUP_ADMIN OR $GROUP_ADMIN_2) ?>
						</div>
					</div>
				</div>
				
</div>
<?php /* ############################################################### */?>
<?php /* DISABLED FOR FISRT VERSION @@@@@@@@@@@######################### */?>
<?php /* ############################################################### */?>
			</div>
			
			<?php
			$request_for_group_txt = str_replace('{GROUP}', $selected_GROUP_name, $LANG->REQUEST_FOR_X_GROUP);
			?>
			<div id="group_buttons_message" style="text-align:center; padding:3em 2em 0; display:none;"></div>
			<div id="group_buttons" style="text-align:center; padding:2em 2em 5em; display:none;">
				<button id="group_user_request_access" type="submit" name="process" class="submit_group" style="vertical-align:middle; margin-top:35px; display:none;"><?=$request_for_group_txt;?> &nbsp; &nbsp; &nbsp; </button>
				<button id="group_user_request_access_AN" type="submit" name="process" class="submit_group" style="vertical-align:middle; display:none;"><?=$request_for_group_txt;?> &nbsp; &nbsp; &nbsp; </button>
				<button id="group_user_request_access_AL_user" type="submit" name="process" class="submit_group" style="vertical-align:middle; display:none;"><?=$request_for_group_txt;?> &nbsp; &nbsp; &nbsp; </button>
				<button id="group_user_request_access_AL_groupadmin" type="submit" name="process" class="submit_group" style="vertical-align:middle; display:none;"><?=$request_for_group_txt;?> &nbsp; &nbsp; &nbsp; </button>
				<button id="group_user_cancel_request_user" type="submit" name="process" class="submit_group" style="vertical-align:middle; display:none;"><?=$LANG->REQUEST_FOR_GROUP_CANCEL;?> &nbsp; &nbsp; &nbsp; </button>
			</div>
		</div>
	</div><?php /*<!-- container -->*/?>
	
	<div style="display:none;">
		<?php /*###### Calendar Forms Select Box AJAX ######*/?>
		<nav id="A_Box_Forms_Menu" class="nav shadow1"></nav>
	</div>

	<div style="display:none;">
		<form id="create_comment" role="form">
		
			<div style="text-align:center; line-height:12px; margin-top:10px;">
				<label>	<?=$LANG->COMMENT_ALL_DAY;?>:&nbsp;&nbsp;<input type="checkbox" id="isAllDay"></label>
			</div>		
		
			<div id="comm_date_div" class="form-group" style="text-align:center;">
				<label id="comm_date_start_label" for="comm_date_start" style="float:left; font-weight:normal;"><?=$LANG->COMMENT_DATE_FROM;?></label>
				<label for="comm_date"><?=$LANG->COMMENT_DATE;?></label>
				<label id="comm_date_end_label" for="comm_date_end" style="float:right; font-weight:normal;"><?=$LANG->COMMENT_DATE_TO;?></label>
				<div style="clear:both;"></div>
				<div class="input-group date" id="datetimepicker_comm_start" style="float:left;">
					<input id="comm_date_start" type="text" class="form-control textfield required" value="" style="width:100px; height:28px; padding:4px 12px;">
					<span class="input-group-addon" style="width:25px; height:28px; display:inline-block; padding:5px;"><span class="fa fa-calendar"></span></span>
				</div>
				<div class="input-group date" id="datetimepicker_comm_end" style="float:right;">
					<input id="comm_date_end" type="text" class="form-control textfield required" value="" style="width:100px; height:28px; padding:4px 12px;">
					<span class="input-group-addon" style="width:25px; height:28px; display:inline-block; padding:5px;"><span class="fa fa-calendar"></span></span>
				</div>
				<div style="clear:both;"></div>
			</div>

			<div id="comm_time_div" class="form-group" style="text-align:center; position:relative; display:none;">
				<label id="comm_time_start_label" for="comm_time_start" style="float:left; font-weight:normal;"><?=$LANG->COMMENT_HOUR_FROM;?></label>
				<label for="comm_time"><?=$LANG->COMMENT_HOUR;?></label>
				<span id="comm_time_now" class="btn btn-default btn-sm input-group-addon" style="width:50px; display:inline-block; padding:2px; height:20px; margin-left:10px; margin-right:-60px;">&nbsp;<?=$LANG->COMMENT_HOUR_NOW;?></span>
				<label id="comm_time_end_label" for="comm_time_end" style="float:right; font-weight:normal;"><?=$LANG->COMMENT_HOUR_TO;?></label>
				<div style="clear:both;"></div>
				<div class="input-group clockpicker time" id="clockpicker_comm_time_start" style="display:inline-block;" data-placement="bottom" data-align="left" data-default="now">
					<span class="input-group-addon" style="width:25px; height:28px; padding:3px; float:left;"><span class="fa fa-clock-o" style="font-size:17px;"></span></span>
					<input id="comm_time_start" name="comm_time_start" type="text" class="form-control textfield time required" style="width:80px; height:28px; padding:4px 12px; border-top-left-radius:0; border-bottom-left-radius:0;" value="" title="<?=$LANG->COMMENT_HOUR_FROM;?>">
					<span class="input-group-addon" style="width:50px; height:28px; display:inline-block; padding:5px 0; border-top-right-radius:0; border-bottom-right-radius:0;"><span class="fa fa-long-arrow-right"></span></span>
				</div>
				<div class="input-group clockpicker time" id="clockpicker_comm_time_end" style="display:inline-block;" data-placement="bottom" data-align="right" data-default="now">
					<input id="comm_time_end" name="comm_time_end" type="text" class="form-control textfield time required" style="width:80px; height:28px; padding:4px 12px; border-top-left-radius:0; border-bottom-left-radius:0; margin-left:-4px;" value="" title="<?=$LANG->COMMENT_HOUR_TO;?>">
					<span class="input-group-addon" style="width:25px; height:28px; display:inline-block; padding:3px 0;"><span class="fa fa-clock-o fa-flip-horizontal" style="font-size:17px;"></span></span>
				</div>
			</div>
			
			<div class="form-group" style="text-align:center;">
				<label for="comm_title"><?=$LANG->COMMENT_TITLE;?></label>
				<div style="position:relative;"><input id="comm_title" type="text" class="form-control textfield required" value=""></div>
			</div>
			<div class="form-group" style="text-align:center;">
				<label for="comm_text"><?=$LANG->COMMENT_TEXT;?></label>
				<textarea id="comm_text" class="form-control" style="min-height:80px;"></textarea>
			</div>

			<div style="text-align:center; line-height:12px; margin-top:10px;">
				<label>	<?=$LANG->COMMENT_IN_GRAPHS;?>:&nbsp;&nbsp;<input type="checkbox" id="showInGraph"></label>
			</div>		
			<div id="comm_color_div" class="form-group" style="text-align:center;">
				<label for="comm_color"><?=$LANG->COMMENT_COLOR;?> :&nbsp;</label>
				<input id="comm_color" class="form-control cpC" type="text" value="rgba(238,238,238,0.5)" style="display:inline-block; width:220px; color:white; text-shadow:black 1px 1px;"/>
			</div>
			<br>
			<div class="clearfix"></div>
			<div id="comment_error" style="text-align:center; color:red; margin:-15px 0 4px 0;" style="display:none;"><?=$LANG->COMMENT_DAY_MAX_3;?></div>
			<div style="text-align:center;">
				<button id="comment_save" type="button" class="save" style="margin:5px;"><?=$LANG->SAVE;?> &nbsp; </button>
			</div>
			<br>
		</form>
	</div>
