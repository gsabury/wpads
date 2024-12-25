<div class="wrap">
    <h2>ناحیه جدید </h2>
    <form action="" method="post">
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    عنوان ناحیه :
                </th>
                <td>
                    <input type="text" name="wpads_zone_name" value="<?php echo  isset($edit_zone) ? $edit_zone->zone_name : ''; ?>">
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    نوع ناحیه :
                </th>
                <td>
                    <select name="wpads_zone_type" id="wpads_zone_type">
                        <option <?php selected(1, isset($edit_zone->zone_type) ? $edit_zone->zone_type : 0); ?> value="1">بنر</option>
                        <option <?php selected(2, isset($edit_zone) ? $edit_zone->zone_type : 0); ?> value="2">متنی</option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    اندازه بنر ها </th>
                <td>
                    <input type="text" value="<?php echo isset($edit_zone->zone_width) ? $edit_zone->zone_width : 0; ?>" name="zone_width" placeholder="عرض بنر">
                    <input type="text" value="<?php echo isset($edit_zone->zone_height) ? $edit_zone->zone_height : 0; ?>" name="zone_height" placeholder="ارتفاع بنر">
                </td>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    قیمت ناحیه :
                </th>
                <td>
                    <input type="text" name="wpads_zone_price" value="<?php echo  isset($edit_zone) ? $edit_zone->zone_price : ''; ?>">
                </td>
            </tr>
        </table>
        <?php submit_button('ذخیره سازی اطلاعات'); ?>
    </form>
</div>