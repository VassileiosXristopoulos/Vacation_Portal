$(document).ready(function ($) {
    $('.users-table tr').on('click', function(){
        var  link = $(this).find('a:first');
        if(link.length){
            var url = $(link).attr('href');
            window.location.href = url;
        }
        
    });
});