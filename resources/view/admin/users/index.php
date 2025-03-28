<?php
// ddd(BASE_PATH);
require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-box bg-white text-dark">
            <h3>جستجوی کاربر :</h3>
            <input class="form-control my-3 p-3" type="text" name="search" id="search" placeholder="نام یا نام خانوادگی،کد ملی یا شماره تماس را وارد کنید">
        </div>
    </div>
    <div class="col-12">
        <div class="dashboard-box">
            <table class="table table-resposive table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام و نام خانوادگی</th>
                        <th>وضعیت دوره</th>
                        <th>تاریخ پرداخت</th>
                        <th>عملیات </th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php
                    $counter = ((int)$users['record']) + 1;
                    foreach ($users['data'] as $user) {
                    ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= $user->first_name . " " . $user->last_name ?></td>
                            <td>
                                <a href="" class="btn btn-sm <?= $user->status == 0 ? 'btn-danger' : 'btn-success' ?>">
                                    <?= $user->status == 0 ? 'غیر فعال' : 'فعال' ?>
                                </a>

                            </td>
                            <td><?= \Morilog\Jalali\Jalalian::forge($user->created_at) ?></td>
                            <td>
                                <a href="<?= url('admin/users/edit/' . $user->id) ?>" class="btn btn-sm btn-danger">ویرایش</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
            <div class="col-12 text-center" id="pagenation">
                <?php
                $count = $users['pages'];
                for ($i = 1; $i < $count; $i++) {
                ?>
                    <a href="?page=<?= $i ?>" class="btn btn-md <?= $users['current_page'] == $i ? 'btn-danger ' : 'btn-primary' ?> pagination_link"> <?= $i ?></a>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<script>
    $("#search").on("keyup", ((e) => {

        if (e.target.value.length > 2) {
            $.ajax({
                url: "<?= url('admin/search-users') ?>",
                method: 'POST',
                data: {
                    'search': e.target.value
                },
                success: (response) => {
                    data = JSON.parse(response);
                    $("#tbody").empty();
                    $("#pagenation").empty()
                    let counter=1;
                    data['data'].forEach(function(elm, index) {
                        
                        td = "<tr>"
                        td += `<td>${counter++}</td>`;
                        td += `<td>${elm.first_name} ${elm.last_name}</td>`;
                        td += `<td><a class="btn ${(elm.status==0) ? 'btn-danger' :'btn-success'}">${elm.status==0 ? 'غیر فعال' :' فعال'}</a></td>`;
                        td += `<td>${elm.created_at}</td>`;
                        td += `<td> <a href="<?= url('admin/users/edit/') ?>${elm.id}" class="btn btn-sm btn-danger">ویرایش</a></td>`;
                        td += "</tr>"
                        $("#tbody").append(td);
                    });
                },
                error: (error) => {
                    console.log(error);
                }
            })
        }
    }))
</script>
<?php
require BASE_PATH . "/resources/view/admin/layouts/footer.php";
?>