jQuery(document).ready(function($) {
    console.log("DateTime Picker Loaded");

    // Check if input field exists
    var $expirationInput = $('input[name="settings[expiration_datetime]"]');

    if ($expirationInput.length > 0) {
        // Initialize DateTime Picker
        $expirationInput.datetimepicker({
            dateFormat: 'yy-mm-dd',
            timeFormat: 'HH:mm:ss',
            showSecond: true,
            controlType: 'select',
            oneLine: true,
            changeMonth: true,
            changeYear: true,
            showAnim: 'fadeIn'
        });
    } else {
        console.error("Expiration DateTime input field not found.");
    }
});
