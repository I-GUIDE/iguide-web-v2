<?php
// Get widget fields
$text = isset($instance['text']) ? $instance['text'] : '';
$buttons = isset($instance['buttons']) && is_array($instance['buttons']) ? $instance['buttons'] : [];
?>
<div class="i-guide-navigation-widget">
    <div class="navigation-text mt-2">
        <?php echo wpautop($text); ?>
    </div>
    <p class="my-4" style="text-align:center;">
        <?php foreach ($buttons as $button): ?>
            <?php
            $btn_text = isset($button['button_text']) ? esc_html($button['button_text']) : '';
            $btn_url = isset($button['button_url']) ? esc_url($button['button_url']) : '#';
            $btn_style = isset($button['button_style']) ? $button['button_style'] : 'primary';
            $btn_class = 'btn btn-' . $btn_style . ' m-2';
            ?>
            <a href="<?php echo $btn_url; ?>" class="<?php echo $btn_class; ?>">
                <?php echo $btn_text; ?>
            </a>
        <?php endforeach; ?>
    </p>
</div>
<hr />