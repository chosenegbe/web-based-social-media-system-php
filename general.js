$(document).ready(function(){
    
    //initial
    $('#content').load('inbox.php');
    
    //handle menu click
    $('ul#nav li a').click(function(){
        var page = $(this).attr('href');
        $('#content').load( page + '.php');
        return false;
    });
    
});