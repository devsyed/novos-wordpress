jQuery(document).ready(function($){
    let table = new DataTable('#novosTable');
    
    $(document).on("click", ".novos-delete-file", function(e){
        e.preventDefault();
        var fileRef = $(this).data('file-ref');
        var confirmation = confirm('Are you sure you want to delete this file?');
        if (confirmation) {
            $.ajax({
                url: ajax_handler.ajax_url + '?action=ntfDeleteFile&file_ref=' + fileRef,
                method: 'GET',
                success: function(res) {
                    window.location.href = window.location.href
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
        
    })


    $(document).on("submit", ".add-new-file", function(e){
        e.preventDefault();
        $.ajax({
            url: ajax_handler.ajax_url,
            method: 'POST',
            data:{
                action:'ntCreateFile',
                formData:$(this).serialize(),
            },
            success: function(res) {
                console.log(res)
                // window.location.href = 'https://wbwp.test/wp-admin/admin.php?page=novos_text_files';
                
            },
            error: function(err) {
                console.log(err);
            }
        });
    })

})