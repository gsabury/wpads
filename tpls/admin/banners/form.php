<div class="wrap">
    <h2>بنر جدید</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    ناحیه :
                </th>
                <td>
                    <select name="wpads_banner_zone" id="wpads_banner_zone">
                        <option value="0">-- لطفا انتخاب کنید --</option>
                        <?php if ( $all_zones && count( $all_zones ) > 0 ): ?>
                            <?php foreach ( $all_zones as $zone ): ?>
                                <option value="<?php echo $zone->zone_id; ?>"><?php echo $zone->zone_name; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    کاربر :
                </th>
                <td>
                    <select name="wpads_banner_user" id="wpads_banner_user">
                        <option value="0">-- لطفا انتخاب کنید --</option>
                        <?php if ( $all_users && count( $all_users ) > 0 ): ?>
                            <?php foreach ( $all_users as $user ): ?>
                                <option value="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    تصویر بنر :
                </th>
                <td>
                    <input type="file" name="wpads_banner_image">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    متن تبلیغات :
                </th>
                <td>
                    <textarea name="wpads_banner_text" id="wpads_banner_text" cols="30" rows="10"></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    آدرس تبلیغات :
                </th>
                <td>
                    <input type="text" name="wpads_banner_url">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    تعداد روز های فعال بودن :
                </th>
                <td>
                    <input type="text" name="wpads_banner_expire_days">
                </td>
            </tr>
        </table>
        <?php submit_button( 'ذخیره سازی اطلاعات' ); ?>
    </form>
</div>