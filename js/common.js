$(function(){
    $.ajax({
       method: 'POST',
       url: 'ajax.php',
       success:function(data) {
         $('.container').html('');
         $('.container').html(data);
       }
    });
    
    $(document).on('click', '.сategory', function() {
        event.preventDefault()
        var href, category;
        href = $(this).attr('href').split('#');
        console.log(href[1]);
          $.ajax({
               method: 'POST',
               url: 'ajax.php',
               data: href[1],
               success:function(data) {
                 $('.container').html('');
                 $('.container').html(data);
               }
            });
});
})