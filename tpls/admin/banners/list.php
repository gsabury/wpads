<div class="wrap">
    <h2>
        مدیریت بنر ها
        <a class="page-title-action" href="<?php echo add_query_arg(array('action' => 'save_banner')); ?>">
            بنر جدید
        </a>
    </h2>
    <table class="table widefat">
        <thead>
            <tr>
                <th>شناسه</th>
                <th>ناحیه</th>
                <th>کاربر</th>
                <th>تصویر</th>
                <th>متن</th>
                <th>آدرس</th>
                <th>تاریخ انقضا</th>
                <th>وضعیت</th>
                <th>تاریخ ایجاد</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>شناسه</th>
                <th>ناحیه</th>
                <th>کاربر</th>
                <th>تصویر</th>
                <th>متن</th>
                <th>آدرس</th>
                <th>تاریخ انقضا</th>
                <th>وضعیت</th>
                <th>تاریخ ایجاد</th>
                <th>عملیات</th>
            </tr>
        </tfoot>
        <tbody>
            <?php if ($all_ads && count($all_ads) > 0): ?>
                <?php foreach ($all_ads as $ad): ?>
                    <tr>
                        <td><?php echo $ad->ID; ?></td>
                        <td><?php echo $ad->zone_name; ?></td>
                        <td><?php echo $ad->display_name; ?></td>
                        <td>
                            <img
                                width="20"
                                height="20"
                                src="<?php echo WPADS_BANNER_URL . $ad->ad_image_file ?>"
                                alt="">
                        </td>
                        <td><?php echo $ad->ad_text; ?></td>
                        <td>
                            <a href="<?php echo $ad->ad_url; ?>">مشاهده</a>
                        </td>
                        <td><?php echo $ad->ad_expire_at; ?></td>
                        <td><?php echo intval($ad->ad_status) ? 'فعال' : 'غیر فعال'; ?></td>
                        <td><?php echo $ad->ad_created_at; ?></td>
                        <td>
                            <a href="<?php echo add_query_arg(array('action' => 'delete', 'ad_id' => $ad->ID)); ?>">
                                <span class="dashicons dashicons-trash"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>