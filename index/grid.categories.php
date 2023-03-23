<?php //Categories Grid
require_once('../_settings.regmon.php');
require('../login/validate.php');

if (!$ADMIN AND !$LOCATION_ADMIN AND !$GROUP_ADMIN AND !$GROUP_ADMIN_2) exit;
?>
<table id="categories" alt="<?=$LANG->CATEGORIES_TITLE;?>"></table>
<div id="Cpager"></div>
<script>
index_categories = true;
<?php include('../index/js/grid.categories.js');?>
</script>
