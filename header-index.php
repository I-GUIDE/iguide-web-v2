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

    
<style>
.carousel-item {
    height: 700px;
    min-height: 300px;
    background-size: cover;
    background-position: center center;
    position: relative;
    color: white;
}

.carousel-indicators {
    bottom: 0%;
    left: 0;
    justify-content: left;
    margin-left: 5%;
    z-index: 27;
}

.carousel-indicators [data-bs-target] {
    background-color: black;
}

.carousel-caption {
    /* background-color: rgba(0, 0, 0, 0.5); */
    padding: 20px;
    width: 50%;
    border-radius: 10px;
    bottom: 15%;
    right: 10%;
    left: unset;
    transform: translateY(100%);
    transition: transform 0.6s ease-in-out;
    text-align: right;
    z-index: 20;
}

.carousel-item.active .carousel-caption {
    transform: translateY(0);
}

.carousel-caption h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
}

.carousel-caption p {
    font-size: 1rem;
    color: white;
    margin: 5px 0 10px;
}
.hero-section .custom-shape-divider-bottom-1676052306 {
    z-index: 26;
}
/* // `sm` applies to x-small devices (portrait phones, less than 576px) */
@media (max-width: 575.98px) {
    .carousel-caption a.btn {
        font-size: 0.5rem;
    }
    .hero-section {
        padding-top: 0;
    }
    .carousel-indicators {
        display: none;
    }
    .carousel-control-next, .carousel-control-prev {
        width: 10%;
    }
    .hero-section .custom-shape-divider-bottom-1676052306 {
        display: none;
    }
    .carousel-item {
        height: 150px;
    }
    .carousel-caption {
        text-align: center;
        width: 80%;
        bottom: 5%;
        right: 10%;
        left: 10%;
    }
    .carousel-caption h1 {
        font-size: 1rem;
    }
    .carousel-caption p {
        font-size: 0.6rem;
        font-weight: lighter;
    }
}
/* // `md` applies to small devices (landscape phones, less than 768px) */
@media  (min-width: 576px) and (max-width: 767.98px) {
    .carousel-control-next, .carousel-control-prev {
        width: 10%;
    }
    .hero-section .custom-shape-divider-bottom-1676052306 {
        display: none;
    }
    .carousel-item {
        height: 450px;
    }
    .carousel-caption {
        bottom: 10%;
        right: 7%;
        left: unset;
    }
    .carousel-caption h1 {
        font-size: 1.5rem;
    }
    .carousel-caption p {
        font-size: 0.75rem;
        font-weight: lighter;
    }
}

/* // `lg` applies to medium devices (tablets, less than 992px) */
@media (min-width: 768px) and (max-width: 991.98px) {
    .hero-section {
        padding-top: 0;
    }
    .carousel-control-next, .carousel-control-prev {
        width: 10%;
    }
    .hero-section .custom-shape-divider-bottom-1676052306 {
        display: none;
    }
    .carousel-item {
        height: 450px;
    }
    .carousel-caption {
        bottom: 10%;
        right: 7%;
        left: unset;
    }
    .carousel-caption h1 {
        font-size: 1.5rem;
    }
    .carousel-caption p {
        font-size: 0.75rem;
        font-weight: lighter;
    }

}

/* // `xl` applies to large devices (desktops, less than 1200px) */
@media (min-width: 992px) and (max-width: 1199.98px) {
    .hero-section .custom-shape-divider-bottom-1676052306 {
        bottom: -20px;
        z-index: 26;
    }
    .carousel-item {
        height: 500px;
    }
    .carousel-caption {
        bottom: 10%;
        right: 10%;
        left: unset;
    }
    .carousel-caption h1 {
        font-size: 1.7rem;
    }
    .carousel-caption p {
        font-size: 0.75rem;
        font-weight: lighter;
    }

}



</style>
</head>

<body>
    <nav id="navigation" class="tw-sticky tw-top-0 tw-z-50 tw-p-0 scrolledUp">
        <div id="desktop-menu" style="height: 80px;" class="tw-hidden 2xl:tw-container md:tw-flex tw-items-center tw-justify-between tw-flex-wrap tw-bg-transparent md:tw-px-5 lg:tw-px-20 xl:tw-px-10 2xl:tw-px-0">
            <div class="tw-flex tw-items-center tw-flex-shrink-0 tw-ml-3 md:tw-ml-4 tw-mr-6">
                <a href="<?php echo home_url(); ?>">
                <img style="width: 80px;" class="logo-color" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-color.png" alt="">
                <img style="width: 80px;" class="logo-white" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-w.png" alt="">
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
    