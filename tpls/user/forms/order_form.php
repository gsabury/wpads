<style>
    .wpads_order_form .form_row {
        margin-bottom: 15px;
    }

    .wpads_order_form .form_row label {
        display: block;
    }

    .wpads_order_form .form_row input,
    .wpads_order_form .form_row select,
    .wpads_order_form .form_row textarea {
        width: 300px;
        min-height: 35px;
    }

    #wpads_image_wrapper {
        display: none;
    }
</style>
<script>
    jQuery(document).ready(function($) {
        $('#wpads_zone').on('change', function() {
            var $item = $('#wpads_zone').find(':selected');
            var $selected = $item.data('type');
            if (parseInt($selected) === 1) {
                $('#wpads_image_wrapper').show();
            } else {
                $('#wpads_image_wrapper').hide();
            }
        });


    });
</script>
<div class="wpads_order_form">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form_row">
            <?php if ($all_zones && count($all_zones) > 0): ?>
                <label for="wpads_zone">ناحیه تبلیغاتی : </label>
                <select name="zone" id="wpads_zone">
                    <option value="0">لطفا انتخاب کنید </option>
                    <?php foreach ($all_zones as $zone): ?>
                        <option data-type="<?php echo $zone->zone_type; ?>" value="<?php echo $zone->zone_id; ?>">
                            <?php echo $zone->zone_name; ?>
                            -
                            <?php echo number_format($zone->zone_price); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
        <div class="form_row">
            <label for="month">مدت زمان تبلیغ :</label>
            <select name="month" id="month">
                <option value="1">یک ماه</option>
                <option value="2">دو ماه</option>
                <option value="3">سه ماه</option>
                <option value="4">چهار ماه</option>
                <option value="5">پنج ماه</option>
                <option value="6">شش ماه</option>
                <option value="7">هفت ماه</option>
                <option value="8">هشت ماه</option>
                <option value="9">نه ماه</option>
                <option value="10">ده ماه</option>
                <option value="11">یازده ماه</option>
                <option value="12">یک سال</option>
            </select>
        </div>
        <div class="form_row">
            <label for="ads_url">آدرس تبلیغات :</label>
            <input type="text" name="ads_url" id="ads_url">
        </div>
        <div class="form_row">
            <label for="ads_text">متن تبلیغات:</label>
            <textarea name="ads_text" id="ads_text" cols="30" rows="10"></textarea>
        </div>
        <div class="form_row" id="wpads_image_wrapper">
            <label for="ads_image">تصویر تبلیغات :</label>
            <input type="file" name="ads_image" id="ads_image">
        </div>

        <div class="form_row">
            <input type="submit" name="ads_submit">
        </div>
    </form>
</div>