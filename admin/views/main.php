<?php

$api = new NovosTextFilesAPI(NOVOS_BASE_URL);
$files = $api->getFiles();

?>

<div class="wrapper" style="padding:50px">
<div style="display:flex; justify-content:space-between; align-items:center;">
<h3>All Text Files</h3>
<a href="<?php echo admin_url(); ?>admin.php?page=novos_add_text_file">Add New File</a>
</div>
<table id="novosTable" class="display">
    <thead>
        <tr>
            <th>File Name</th>
            <th>File Created at</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php if($files): foreach($files as $file): ?>
        <tr>
            <td><?php echo $file['fileName']; ?></td>
            <td><?php echo $file['file_created_at'] ?></td>
            <td><?php echo '<button data-nonce="'.wp_create_nonce('novos-nonce').'" class="novos-delete-file" data-file-ref="'.$file['refName'].'" >Delete</button>'; ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>
</div>