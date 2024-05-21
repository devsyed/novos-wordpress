<?php 

$api = new NovosTextFilesAPI(NOVOS_BASE_URL);
$allContent = $api->getAllContent();

?>

<div class="wrapper" style="padding:50px">
<div style="display:flex; justify-content:space-between; align-items:center;">
<h3>All Text Files</h3>
</div>
<p><?php echo $allContent; ?></p>
</div>