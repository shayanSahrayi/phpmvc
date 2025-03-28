<?php
// ddd(BASE_PATH);
require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-box bg-white text-dark">
            <h3>لیست پیام های ارسال شده</h3>
         </div>
    </div>
    <div class="col-12">
        <div class="dashboard-box">
            <table class="table table-resposive table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>سانس</th>
                        <th>ظرفیت سانس</th>
                        <th>ظرفیت باقیمانده سانس</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                     </tr>
                </thead>
                <tbody id="tbody">
                    <?php
                    $counter =  1;
                    foreach ($times as $time) {
                    ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= $time->start_time . " تا" . $time->end_time ?></td>
                            <td><?= $time->capacity ?></td>
                            <td><?= $time->remaining_capacity?></td>
                 
                            <td>
                                <a href="" class="btn btn-sm <?= $time->status == 10 ? 'btn-success' : 'btn-danger' ?>">
                                    <?= $time->status == 10 ? 'فعال' : 'غیر فعال' ?>
                                </a>
                            </td>
                            <td><a class="btn btn-warning" href="<?=url('admin/times/edit/'.$time->id)?>">ویرایش</a></td>
                         </tr>
                    <?php } ?>
                </tbody>

            </table>
  
        </div>
    </div>
</div>

 
<?php
require BASE_PATH . "/resources/view/admin/layouts/footer.php";
?>