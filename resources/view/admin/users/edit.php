<?php
// ddd(BASE_PATH);

use Morilog\Jalali\Jalalian;

require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>


<div class="row d-flex justify-content-evenly">
    <div class="col-12 dashboard-box bg-white text-black">
        <h3 class="my-3">مشخصات فردی :</h3>
        <form class="row g-3 mt-2" method="post" enctype="multipart/form-data" action="<?= url("admin/users/edit/" . $user->id) ?>" id="formEdit">

            <div id="alertContainer">

            </div>

            <div class="col-md-6">
                <label for="fname" class="form-label">نام</label>
                <input type="text" name="fname" value="<?= $user->first_name ?>" class="form-control" id="fname">
            </div>
            <div class="col-md-6">
                <label for="lname" class="form-label"> نام خانوادگی</label>
                <input type="text" name="lname" value="<?= $user->last_name ?>" class="form-control" id="lname">
            </div>
            <div class="col-md-6">
                <label for="tell" class="form-label">شماره تماس</label>
                <input type="text" name="tell" value="<?= $user->phone ?>" class="form-control" id="tell">
            </div>
            <div class="col-md-6">
                <label for="statuss" class="form-label">وضعیت دوره</label>
                <select name="status" id="statuss" class="form-control">
                    <option value="1" <?= $user->status == 1 ? 'selected' : '' ?>>دوره فعال</option>
                    <option value="0" <?= $user->status == 0 ? 'selected' : '' ?>>دوره غیر فعال</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="insurance" class="form-label">وضعیت بیمه</label>
                <select name="insurance" id="insurance" class="form-control">
                    <option value="10" <?= $user->Insurance == 10 ? 'selected' : '' ?>>دارد</option>
                    <option value="0" <?= $user->Insurance == 0 ? 'selected' : '' ?>>ندارد</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="insurance_image" class="form-label">اپلود عکس بیمه</label>
                <input type="file" name="insurance_image" class="form-control" id="insurance_image">
                <input type="hidden" name="old_image" value="<?= $user->insurance_img ?>" value="">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">ویرایش</button>
                <button type="submit"  onclick='deleteUser(event,"<?=url("admin/users/delete/$user->id")?>",$user->id)' class="btn btn-danger">حذف</button>
            </div>

        </form>
    </div>
</div>
<div class="row d-flex justify-content-evenly">
    <div class="col-12 dashboard-box bg-white text-black">
        <h3 class="my-3">مشخصات دوره :</h3>
        <?php
        if(isset($session) && $session){
        ?>
        <form class="row g-3 mt-2" method="post" action="<?= url("admin/users/edit/session/" . $session->id) ?>" id="formEditSession">

            <div id="alertContainerSession">

            </div>
            <input type="hidden" value="<?=$user->id?>" name="user">
            <div class="col-md-6">

                <label for="count_session" class="form-label">تعداد جلسات</label>
                <input type="number" name="count_session" value="<?= $session->total_sessions ?>" class="form-control" id="count_session">
            </div>
            <div class="col-md-6">
                <label for="count_session" class="form-label"> تعداد جلسات باقی مانده</label>
                <input type="text" disabled value="<?= $session->remaining_sessions ?>" class="form-control bg-white" id="count_session">
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">وضعیت دوره</label>
                <select name="status" id="status" class="form-control">
                    <option value="10" <?= $session->status == 10 ? 'selected' : '' ?>>دوره فعال</option>
                    <option value="0" <?= $session->status == 0 ? 'selected' : '' ?>>دوره غیر فعال</option>
                </select>
            </div>
            <div class="col-md-6">

                <label for="" class="form-label">روز های تمرین :</label>
                <br>
                <?php
                $selctedDayes = explode(",", $session->days);
                ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" <?= (in_array('7', $selctedDayes)) ? 'checked' : '' ?> name="days[]" id="saturday" value="7">
                    <label class="form-check-label" for="saturday">شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" <?= (in_array('1', $selctedDayes)) ? 'checked' : '' ?> name="days[]" id="sunday" value="1">
                    <label class="form-check-label" for="sunday">یک شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" <?= (in_array('2', $selctedDayes)) ? 'checked' : '' ?> name="days[]" id="monday" value="2">
                    <label class="form-check-label" for="monday">دو شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" <?= (in_array('3', $selctedDayes)) ? 'checked' : '' ?> name="days[]" id="tuesday" value="3">
                    <label class="form-check-label" for="tuesday">سه شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" <?= (in_array('4', $selctedDayes)) ? 'checked' : '' ?> name="days[]" id="wednesday" value="4">
                    <label class="form-check-label" for="wednesday">چهار شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" <?= (in_array('5', $selctedDayes)) ? 'checked' : '' ?> name="days[]" id="thursday" value="5">
                    <label class="form-check-label" for="thursday">پنج شنبه</label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="session_time" class="form-label">ساعت سانس</label>
                <select name="session_time" id="session_time" class="form-control">
                    <?php

                    foreach ($times as $time) {

                    ?>
                        <option value="<?= $time->id ?>" <?= $time->id == $session->session_id ? 'selected' : '' ?>> ساعت <?= $time->start_time . " تا " . $time->end_time ?></option>
                    <?php } ?>

                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">ویرایش</button>
                <button id="delete" class="btn btn-danger">حذف</button>
            </form>
            </div>
            onclick='deleteUser(event,"<?=url("admin/users/delete/session/$session->id")?>",$session->id)'
        <?php }else{
            ?>
            <h6>کاربر <span class="text-danger fs-4" >دوره ی فعالی ندارد</span> لطفا جهت  ثبت دوره <a class="btn btn-primary" href="<?=url('admin/tuitions/create')?>">اینجا</a> کلیک کنید</h6>
            <?php }?>
    </div>
</div>
<div class="row d-flex justify-content-evenly">

    <div class="col-md-6 dashboard-box bg-white text-black">
        <div class="col-12">
            <h3 class="my-3">خلاصه ی پرداخت ها :</h3>
        </div>

        <div class="col-12">
            <?php
            if (isset($transaction) || count($transaction) > 0) {
            ?>
                <table class="table table-responsive table-strip">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>مبلغ پرداخت</th>
                            <th>تاریخ پردخت</th>
                            <th>وضعیت پرداخت</th>
                            <th>روش پرداخت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        foreach ($transaction as $item) {
                        ?>
                            <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= $item->amount ?></td>
                                <td><?= Jalalian::forge($item->created_at) ?></td>
                                <td>
                                    <button class="btn btn-md <?= ($item->status == 1) ? 'btn-success' : 'btn-danger' ?>"><?= ($item->status == 10) ? 'موفق' : 'نا موفق' ?></button>
                                </td>
                                <td>
                                    <button class="btn btn-md <?= ($item->method == 1) ? 'btn-primary' : 'btn-success' ?>"><?= ($item->method == 10) ? 'نقدی' : 'انلاین' ?></button>
                                </td>
                                <td>
                                    <a href="<?= url("admin/payments/edit/$item->id") ?>" class="btn btn-md btn-warning">ویرایش</a>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            <?php } else { ?>
                <h1>کاربر تا حالا پرداختی نداشته است</h1>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-5 dashboard-box bg-white text-black">
        <div class="col-12">
            <h3 class="my-3">خلاصه ی پیام های ارسال شده :</h3>
        </div>
        <div class="col-12">
            <?php
            if (isset($sms) || count($sms) > 0) {
            ?>
                <table class="table table-responsive table-strip">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>تاریخ ارسال</th>
                            <th>وضعیت ارسال</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        foreach ($sms as $item) {
                        ?>
                            <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= Jalalian::forge($item->created_at) ?></td>
                                <td>
                                    <button class="btn btn-md <?= ($item->status == 200) ? 'btn-success' : 'btn-danger' ?>"><?= ($item->status == 200) ? 'ارسال شده' : 'خطا در ارسال' ?></button>
                                </td>

                                <td>
                                    <a href="<?= url("admin/sms/delete/$item->id") ?>" class="btn btn-md btn-warning">حذف</a>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <h1>کاربر تا حالا پیامکی ارسالی نداشته است</h1>
            <?php } ?>
        </div>
    </div>
</div>
</div>

<script>
    form = document.getElementById("form")
    document.getElementById("formEdit").addEventListener("submit", async (e) => {
        e.preventDefault();
        const formDatas = new FormData(e.target);
        fetch(e.target.action, {
                method: "POST",
                body: formDatas
            }).then((response) => {
                if (!response.ok) {
                    throw new Error(`خطای پیش امده لطفا دوباره  اقدام کنید`);
                }
                return response.json();

            })
            .then((data) => {
                document.getElementById("alertContainer").innerHTML = '<div class="alert alert-success">' + data.success + '</div>';

            })
            .catch((err) => {
                document.getElementById("alertContainer").innerHTML = '<div class="alert alert-danger">' + err + '</div>';
            })
    })

    document.getElementById("formEditSession").addEventListener("submit", async (e) => {
        e.preventDefault();
        const formDatas = new FormData(e.target);
        fetch(e.target.action, {
                method: "POST",
                body: formDatas
            }).then((response) => {
                if (!response.ok) {
                    throw new Error(`خطای پیش امده لطفا دوباره  اقدام کنید`);
                }
                return response.json();

            })
            .then((data) => {
                 
                document.getElementById("alertContainerSession").innerHTML = '<div class="alert alert-success">' + data.success + '</div>';

            })
            .catch((err) => {
                document.getElementById("alertContainerSession").innerHTML = '<div class="alert alert-danger">' + err + '</div>';
            })
    })

    $("#delete").click((e) => {
        e.preventDefault();
         Swal.fire({
            title: "آیا مطمنی؟",
            text: "میخواهید کاربرا حذف کنید؟",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "بله حذف میکنم",
            cancelButtonText: "خیر"
        }).then((response) => {
            if (response.isConfirmed) {
                fetch("<?= url("admin/tuitions/delete/$user->id") ?>",{
                    method:"POST",
                }).then((response)=>{
                    if(!response.ok){
                        throw Error("خطا در حذف");
                    }
                    return response.text();
                }).then((response)=>{
                    console.log(response);
                    
                    Swal.fire({
                        title:"عملیات موفق",
                        text:"با موفقیت  حذف شد",
                        icon: "success",
                        confirmButtonColor:"#3085d6",
                        confirmButtonText:"تمام"
                    }).then((response)=>{
                        if(response.isConfirmed){
                            window.location="http://localhost/7_box/admin/tuitions/"
                        }
                    })
                }).catch((err)=>{
                    document.getElementById("alertContainer").innerHTML = '<div class="alert alert-danger">' + err + '</div>';

                })
            }
        })
    })
</script>
<?php
require BASE_PATH . "/resources/view/admin/layouts/footer.php";
?>