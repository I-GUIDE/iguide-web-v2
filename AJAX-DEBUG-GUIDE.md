## AJAX Debugging Guide for I-GUIDE Ethics Toolkit

The JavaScript errors you're seeing indicate that the AJAX request is returning HTML instead of JSON. This typically happens when:

### Most Common Causes:

1. **Plugin Not Properly Activated**
   - Go to WordPress Admin → Plugins
   - Make sure "I-GUIDE Data Ethics Toolkit (I-DET)" is activated
   - If activation fails, check the error message

2. **Database Tables Not Created**
   - The plugin activation should create database tables
   - If activation was interrupted, tables might be missing

3. **PHP Fatal Error in AJAX Handler**
   - Check WordPress error logs
   - Look in `/wp-content/debug.log` if WP_DEBUG is enabled

4. **AJAX Action Not Registered**
   - The shortcodes class might not be instantiated properly

### Quick Debugging Steps:

1. **Enable WordPress Debug Mode**
   Add these lines to `wp-config.php`:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('WP_DEBUG_DISPLAY', false);
   ```

2. **Check the Actual AJAX Response**
   In browser console, modify the fetch call to log the raw response:
   ```javascript
   fetch(idet_ajax.ajax_url, {
       method: 'POST',
       body: formData
   })
   .then(response => response.text()) // Change to .text() instead of .json()
   .then(text => {
       console.log('Raw AJAX response:', text);
       // Try to parse as JSON
       try {
           const json = JSON.parse(text);
           console.log('Parsed JSON:', json);
       } catch (e) {
           console.error('Not JSON, response is:', text);
       }
   });
   ```

3. **Manual Plugin Activation Check**
   - Deactivate the plugin completely
   - Re-activate it and watch for any error messages
   - Check if all database tables are created

4. **Test AJAX URL Directly**
   Try accessing: `your-site.com/wp-admin/admin-ajax.php?action=idet_create_project`
   - Should return an error about missing nonce, but shouldn't return HTML

### Expected Behavior:
- AJAX should return JSON like: `{"success":true,"data":{"project_id":1,"message":"Project created successfully"}}`
- Not HTML containing `<script>` tags

### Files to Check:
- `/wp-content/debug.log` (if debug logging is enabled)
- `/wp-content/plugins/iguide-ethics-toolkit/iguide-ethics-toolkit.php` (main plugin file)
- `/wp-content/plugins/iguide-ethics-toolkit/includes/class-shortcodes.php` (AJAX handlers)

### Quick Fix:
1. Go to WordPress Admin → Plugins
2. Deactivate "I-GUIDE Data Ethics Toolkit (I-DET)"
3. Re-activate it
4. Try creating a project again
5. If still failing, check the debug log for PHP errors