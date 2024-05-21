<div class="wrapper" style="padding:50px">
<div style="display:flex; justify-content:space-between; align-items:center;">
<h3>Add Text Files</h3>

</div>

<form class="add-new-file">
    <div style="display:flex; flex-flow:column;">
    <input type="text" placeholder="Enter File Name" name="fileName" required/>
    <br>
    <textarea name="content" cols="20" rows="20" required></textarea>
    </div>
    <button style="margin-top:20px; background-color:#000; color:#fff; padding:10px;" type="submit">Submit</button>
    <?php wp_nonce_field( 'ntCreateFile', 'ntCreateFileNonce' ); ?>
</form>
</div>