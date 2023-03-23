<?php // Forms Grid
require_once('../_settings.regmon.php');
require('../login/validate.php');

if (!$ADMIN AND !$LOCATION_ADMIN AND !$GROUP_ADMIN AND !$GROUP_ADMIN_2) exit;
?>
<table id="forms" alt=""></table>
<div id="Fpager"></div>
<script>
user_forms = true;
<?php include('../forms/js/grid.forms.js');?>
</script>
