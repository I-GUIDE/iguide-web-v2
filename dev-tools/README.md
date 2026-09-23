# Development Tools

Debug and test scripts for the I-GUIDE Ethics Toolkit plugin. **Not for production use.**

Web access is blocked two ways:
- `.htaccess` denies all HTTP requests (Apache).
- Each script refuses to run unless invoked from the command line (works on nginx too).

## Running

From the WordPress root:

```bash
php wp-content/themes/<theme>/dev-tools/test-plugin-files.php
php wp-content/themes/<theme>/dev-tools/test-plugin-activation.php
php wp-content/themes/<theme>/dev-tools/test-activation.php
```

`debug-ajax-test.php` is meant to be temporarily included from `functions.php`
(`require get_template_directory() . '/dev-tools/debug-ajax-test.php';`).
Its AJAX endpoint only responds to logged-in administrators. Remove the include when done.
