<tr valign="top">
    <th scope="row">Enabled</th>
    <td>
        <label for="<?php echo $urgencyAlertEnabled; ?>">
            <input type="checkbox" name="<?php echo $urgencyAlertEnabled; ?>" <?php echo (boolval(esc_attr(get_rezfusion_option($urgencyAlertEnabled))) === true) ? "checked" : ""; ?> />
            Is feature enabled?
        </label>
    </td>
</tr>
<tr valign="top">
    <th scope="row">Days threshold</th>
    <td><input type="number" min="0" max="999999" step="1" name="<?php echo $daysThreshold; ?>" value="<?php echo esc_attr(stripslashes(get_rezfusion_option($daysThreshold))); ?>" /><br />
        <label for="<?php echo $daysThreshold; ?>">Check last * days.</label>
        <div style="color: #800; font-weight: bold;">If new value is lower than previous, historical data for specific post will be erased on next page view request.</div>
    </td>
</tr>
<tr valign="top">
    <th scope="row">Minimum visitors</th>
    <td><input type="number" min="0" max="999999" step="1" name="<?php echo $minimumVisitors; ?>" value="<?php echo esc_attr(stripslashes(get_rezfusion_option($minimumVisitors))); ?>" /><br />
        <label for="<?php echo $minimumVisitors; ?>">Minimum visitors number required for text to be displayed.</label>
    </td>
</tr>
<tr valign="top">
    <th scope="row">Text</th>
    <td><input type="text" placeholder="Default will be used." name="<?php echo $text; ?>" value="<?php echo esc_attr(stripslashes(get_rezfusion_option($text))); ?>" /><br />
        <label for="<?php echo $text; ?>">Set text used to show recent visits count. Use [[visitorsCount]] tag that will be replaced with actual value.
            <br />If left empty then default text will be used: <i><?php echo $defaultUrgencyText; ?></i>
        </label>
    </td>
</tr>
<tr valign="top">
    <th scope="row">Highlighted Text</th>
    <td><input type="text" placeholder="Not defined." name="<?php echo $highlightedText; ?>" value="<?php echo esc_attr(get_rezfusion_option($highlightedText)); ?>" /><br />
        <label for="<?php echo $highlightedText; ?>">Set highlighted text which will be shown before actual text with visitors count.<br />If it's not defined then nothing will be shown.</label>
    </td>
</tr>