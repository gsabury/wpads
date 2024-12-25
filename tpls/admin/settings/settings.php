<div class="warp">
    <h2>تنظیمات پلاگین</h2>
    <form action="" method="post">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">فعال بودن پلاگین</th>
                <td>
                    <input type="checkbox" <?php checked(1, intval($wpads_options['general']['wpads_is_active'])); ?> name="wpads_is_active" value="1">
                </td>
            </tr>
        </table>
        <?php submit_button('ذخیره اطلاعات'); ?>
    </form>
</div>