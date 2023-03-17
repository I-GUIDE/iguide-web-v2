<!doctype html>
<html lang="en">

<head>
    <title><?php wp_title($sep="|"); ?></title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PMS4J0Q35S"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-PMS4J0Q35S');
    </script>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/site.webmanifest">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/navigation.css">
    <?php wp_head(); ?>
</head>

<body>
    <nav id="navigation" class="tw-sticky tw-top-0 tw-z-50 tw-p-0 scrolledDown">
        <div id="desktop-menu" class="tw-hidden 2xl:tw-container md:tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-bg-transparent md:tw-h-[100px] lg:tw-h-[120px] md:tw-px-5 lg:tw-px-20 xl:tw-px-10 2xl:tw-px-0">
            <div class="tw-flex tw-items-center tw-flex-shrink-0 tw-ml-3 md:tw-ml-4 tw-mr-6">
                <a href="<?php echo home_url(); ?>">
                <img class="logo-color tw-h-[56px] tw-w-[115px] xl:tw-p-0 xl:tw-h-[80px] xl:tw-w-[165px]" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-color.png" alt="">
                <img class="logo-white tw-h-[56px] tw-w-[115px] xl:tw-p-0 xl:tw-h-[80px] xl:tw-w-[165px]" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-w.png" alt="">
                </a>
            </div>
            <div class="menu-main-navigation-container tw-font-light">
            <?php 
                    $defaults = array(
                        'menu'  => 'primary-menu',
                        'menu_class'      => 'nav d-flex justify-content-end tw-hidden md:tw-flex tw-items-center tw-text-sm xl:tw-text-base tw-space-x-4 xl:tw-space-x-8 tw-font-light',
                        'menu_id'      => 'main-menu',
                    );
                    wp_nav_menu( $defaults );
                ?>
            </div>
        </div>
    </nav>
    