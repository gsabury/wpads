<div class="wrap">
    <h2>
        مدیریت ناحیه ها
        <a class="page-title-action" href="<?php echo add_query_arg(array('action' => 'add_new_zone')); ?>">ناحیه
            جدید</a>
    </h2>
    <table class="table widefat">
        <thead>
            <tr>
                <th>شناسه ناحیه</th>
                <th>عنوان</th>
                <th>نوع ناحیه</th>
                <th>قیمت</th>
                <th>تاریخ ایجاد</th>
                <th>کد کوتاه</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>شناسه ناحیه</th>
                <th>عنوان</th>
                <th>نوع ناحیه</th>
                <th>قیمت</th>
                <th>تاریخ ایجاد</th>
                <th>کد کوتاه</th>
                <th>عملیات</th>
            </tr>
        </tfoot>
        <tbody>
            <?php if ($all_zones && count($all_zones) > 0): ?>
                <?php foreach ($all_zones as $zone): ?>
                    <tr>
                        <td><?php echo $zone->zone_id; ?></td>
                        <td><?php echo $zone->zone_name; ?></td>
                        <td><?php echo wpads_get_zone_type($zone->zone_type); ?></td>
                        <td><?php echo number_format($zone->zone_price); ?></td>
                        <td><?php echo $zone->zone_created_at; ?></td>
                        <td><?php echo '[wpads_show id="' . $zone->zone_id . '"]'; ?></td>
                        <td>
                            <a href="<?php echo add_query_arg(array(
                                            'action' => 'edit',
                                            'zone_id' => $zone->zone_id
                                        )); ?>">
                                <span class="dashicons dashicons-edit"></span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>