$(function () {
    var mottos = $('#tabs-nav span');

    //// Create tab functionality for the Hero section 
    $('#tabs-nav span:first-child').addClass('active');
    $('.hero-tab-content').hide();
    $('.hero-tab-content:first').show();

    var autoRotate = setInterval(function() {
        var motto = mottos[slideNumber++];
        $(motto).click();
        if(slideNumber >= mottos.length) i = 0;
    }, 7000); 

    // Click function
    $('#tabs-nav span').on('click', function(){
        var clicked = $(this).attr('id');
        switch(clicked) {
            case "map" : slideNumber=1 ; break;
            case "connect" : slideNumber=2 ; break;
            case "discover" : slideNumber=0 ; break;
        }

        $('#tabs-nav span').removeClass('active');
        $(this).addClass('active');
        $('.hero-tab-content').hide();
        
        var activeTab = $(this).attr('link');
        $(activeTab).show();
        $(activeTab).find('.animate').addClass('animate__animated animate__fadeInRight');
        return false;
    });


    //// Create tab functionality for the Hero section 
    $('#project-tabs-nav li:first').addClass('active');
    $('.project-tab-content').hide();
    $('.project-tab-content:first').show();

    // Click function
    $('#project-tabs-nav li').on('click', function(){
        // console.log('test2');
        $('#project-tabs-nav li').removeClass('active');
        $(this).addClass('active');
        $('.project-tab-content').hide();
        
        var activeTab = $(this).attr('link');
        $(activeTab).show();
        $(activeTab).find('.projLeft').addClass('animate__animated animate__fadeInLeft');
        $(activeTab).find('.projRight').addClass('animate__animated animate__fadeInRight');
        return false;
    });

});