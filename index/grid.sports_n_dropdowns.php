<?php 
require_once('../_settings.regmon.php');
require('../login/validate.php');
?>
<table id="dropdowns" alt="<?=$LANG->DROPDOWNS;?>"></table>
<div id="Dpager"></div>
<div id="dropdowns_message" style="text-align:center;"></div>
<br>
<table id="sports" alt="<?=$LANG->SPORTS;?>"></table>
<div id="SPpager"></div>
<div id="sports_message" style="text-align:center;"></div>
<script>
<?php include('../index/js/grid.sports_n_dropdowns.js');?>
</script>
