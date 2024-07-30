<footer class="tw-flex tw-p-10">
        <div class="tw-text-white 2xl:tw-container">
            <div class="tw-flex tw-flex-col tw-content-center md:tw-flex-row tw-justify-evenly">
                <div class="tw-flex tw-content-center tw-my-auto tw-gap-x-5">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/nsf.png" alt="" class="tw-h-[50px] md:tw-h-[7vw] 2xl:tw-h-[100px]">
                    <div class="tw-text-xs lg:tw-text-base tw-text-white">
                        <h1 class="tw-font-bold">©
                            <script>document.write(new Date().getFullYear())</script> I-GUIDE All Rights Reserved
                        </h1>
                        <p class="tw-font-light tw-tracking-wide tw-leading-relaxed tw-mt-1">Institute for
                            Geospatial Understanding through an Integrative Discovery Environment <br class="tw-hidden md:tw-block lg:tw-hidden"> (I-GUIDE)  <br class="tw-hidden lg:tw-block">  is supported by the National Science Foundation</p>
                    </div>
                </div>
                <div class="tw-py-5 tw-flex tw-gap-5 tw-justify-center">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/yt.png" alt="" class="tw-object-contain tw-max-w-[30px]">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tw.png" alt="" class="tw-object-contain tw-max-w-[30px]">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/in.png" alt="" class="tw-object-contain tw-max-w-[30px]">
                </div>
            </div>
            <div class="md:tw-mt-5 tw-mx-auto tw-text-center md:tw-w-9/12">
                <p class="tw-text-[2.5vw] md:tw-text-[1.1vw] lg:tw-text-sm tw-font-light tw-inline-block">This material is based upon work supported by the National
                    Science Foundation under award No. 2118329. Any opinions, findings, conclusions, or recommendations
                    expressed in this material are those of the author(s) and do not necessarily reflect the views of
                    the National Science Foundation.</p>
            </div>
        </div>
        <div class="tw-pt-7  tw-mb-0 tw-mt-auto tw-text-white">
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/slicknav.min.css"
        integrity="sha512-heyoieAHmpAL3BdaQMsbIOhVvGb4+pl4aGCZqWzX/f1BChRArrBy/XUZDHW9WVi5p6pf92pX4yjkfmdaIYa2QQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js"
        integrity="sha512-FmCXNJaXWw1fc3G8zO3WdwR2N23YTWDFDTM3uretxVIbZ7lvnjHkciW4zy6JGvnrgjkcNEk8UNtdGTLs2GExAw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <script>
    $(function () {  
        $('#main-menu').slicknav({
            label: '',
            prependTo: 'body',
            closedSymbol: '<i class="mr-1 fa fa-chevron-right" aria-hidden="true"></i>',
            openedSymbol: '<i class="mr-1 fa fa-chevron-down" aria-hidden="true"></i>',
            init: function(){
                
                $('.slicknav_menu').prepend('<div class="mobileLogoWrap"><a href="<?php echo home_url(); ?>"><img class="logo-c mobilLogo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-color.png"alt=""><img class="mobilLogo logo-w" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-w.png"alt=""></a></div>');
                // Add the arrows to navigation items
                $('#navigation #main-menu>li.menu-item-has-children > a').append('<i class="ml-4 fa fa-angle-down" aria-hidden="true"></i>');
                $('#navigation #main-menu>li>ul.sub-menu li.menu-item-has-children > a').prepend('<i class="mr-2 fa fa-angle-left" aria-hidden="true"></i>');

                $('.slicknav_menu').addClass('close');
                $('.slicknav_menu').css('background-color','transparent');
                $('.logo-c').css('display','block');
                $('.logo-w').css('display','none');
                $('.slicknav_menu .slicknav_icon-bar').css('background-color', 'white');
            },
            beforeOpen: function(trigger){
                if($(trigger).hasClass('slicknav_btn')){ 
                    $('.slicknav_menu').addClass('open');
                    $('.slicknav_menu').css('background-color','white');
                    $('.logo-c').css('display','block');
                    $('.logo-w').css('display','none');
                    $('.slicknav_menu .slicknav_icon-bar').css('background-color', 'black');
                }
            }, 
            afterClose: function(trigger){
                if($(trigger).hasClass('slicknav_btn')){ 
                    $('.slicknav_menu').addClass('close');
                    $('.slicknav_menu').css('background-color','transparent');
                    $('.logo-c').css('display','block');
                    $('.logo-w').css('display','none');
                    $('.slicknav_menu .slicknav_icon-bar').css('background-color', 'white');
                }
            }
        });
    });
    </script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js " integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1 " crossorigin="anonymous "></script>
    <script>
        $('#menu .nav-link').click(function (e) {
            e.preventDefault();
            $("#menu .nav-link").removeClass('active');
        });
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js " integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM " crossorigin="anonymous "></script>
    <!-- Begin Constant Contact Active Forms -->
    <script> var _ctct_m = "fc183cbdcaf3982ff12d90bb605ba0ab"; </script>
    <script id="signupScript" src="//static.ctctcdn.com/js/signup-form-widget/current/signup-form-widget.min.js" async defer></script>
    <!-- End Constant Contact Active Forms -->
    <?php wp_footer(); ?>
</body>

</html>