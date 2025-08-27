<?php
$people = isset($instance['people']) && is_array($instance['people']) ? $instance['people'] : [];
?>
<style>
.iguide-people-link {
    position: relative;
    display: block;
}

.iguide-people-link .card-img-top {
    transition: filter 0.3s;
}

.iguide-people-link:hover .card-img-top {
    filter: brightness(0.5);
}

.iguide-link-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 2em;
    opacity: 0;
    transition: opacity 0.3s;
    pointer-events: none;
    z-index: 2;
}

.iguide-people-link:hover .iguide-link-icon {
    opacity: 1;
}
</style>
<div class="row justify-content-center">
    <?php foreach ($people as $person): ?>
    <?php
        $img = '';
        if (isset($person['image'])) {
            if (is_array($person['image']) && isset($person['image']['url'])) {
                $img = esc_url($person['image']['url']);
            } elseif (is_numeric($person['image'])) {
                $img_url = wp_get_attachment_url($person['image']);
                $img = esc_url($img_url);
            } else {
                $img = esc_url($person['image']);
            }
        }
        $name = isset($person['name']) ? esc_html($person['name']) : '';
        $affiliation = isset($person['affiliation']) ? esc_html($person['affiliation']) : '';
        $position = isset($person['position']) ? esc_html($person['position']) : '';
        $profile_url = isset($person['profile_url']) ? esc_url($person['profile_url']) : '';
        ?>
    <div class="col-6 col-sm-4 col-md-2 col-lg-2">
        <div class="card people-card ">
            <?php if ($profile_url): ?>
            <a href="<?php echo $profile_url; ?>" class="stretched-link iguide-people-link" target="_new">
                <span class="iguide-link-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24">
                        <path
                            d="M9.16488 17.6505C8.92513 17.8743 8.73958 18.0241 8.54996 18.1336C7.62175 18.6695 6.47816 18.6695 5.54996 18.1336C5.20791 17.9361 4.87912 17.6073 4.22153 16.9498C3.56394 16.2922 3.23514 15.9634 3.03767 15.6213C2.50177 14.6931 2.50177 13.5495 3.03767 12.6213C3.23514 12.2793 3.56394 11.9505 4.22153 11.2929L7.04996 8.46448C7.70755 7.80689 8.03634 7.47809 8.37838 7.28062C9.30659 6.74472 10.4502 6.74472 11.3784 7.28061C11.7204 7.47809 12.0492 7.80689 12.7068 8.46448C13.3644 9.12207 13.6932 9.45086 13.8907 9.7929C14.4266 10.7211 14.4266 11.8647 13.8907 12.7929C13.7812 12.9825 13.6314 13.1681 13.4075 13.4078M10.5919 10.5922C10.368 10.8319 10.2182 11.0175 10.1087 11.2071C9.57284 12.1353 9.57284 13.2789 10.1087 14.2071C10.3062 14.5492 10.635 14.878 11.2926 15.5355C11.9502 16.1931 12.279 16.5219 12.621 16.7194C13.5492 17.2553 14.6928 17.2553 15.621 16.7194C15.9631 16.5219 16.2919 16.1931 16.9495 15.5355L19.7779 12.7071C20.4355 12.0495 20.7643 11.7207 20.9617 11.3787C21.4976 10.4505 21.4976 9.30689 20.9617 8.37869C20.7643 8.03665 20.4355 7.70785 19.7779 7.05026C19.1203 6.39267 18.7915 6.06388 18.4495 5.8664C17.5212 5.3305 16.3777 5.3305 15.4495 5.8664C15.2598 5.97588 15.0743 6.12571 14.8345 6.34955"
                            stroke="#ffffff" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </span>
                <div class="card-img-top box-shadow" style="background-image: url('<?php echo $img; ?>');"></div>
            </a>
            <?php else: ?>
            <div class="card-img-top box-shadow" style="background-image: url('<?php echo $img; ?>');"></div>
            <?php endif; ?>
            <div class="card-body ">
                <h5 class="card-title name "><?php echo $name; ?></h5>
                <p class="card-text affiliation "><?php echo $affiliation; ?></p>
                <?php if ($position): ?>
                <p class="card-text position "><?php echo $position; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>