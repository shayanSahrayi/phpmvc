<?php
// ddd(BASE_PATH);

use Morilog\Jalali\Jalalian;

require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>


<div class="row d-flex justify-content-evenly">
    <div class="col-12 dashboard-box bg-white text-black">



        <form class="row g-3 mt-2" method="post" id="formUpdate" action="<?= url("admin/tuitions/update/$tuition->id") ?>">
            <div id="alertContainer">

            </div>
            <h3 class="my-3"> اطلاعات مربوط به پرداخت :</h3>
            <div class="col-md-6">
                <label for="fname" class="form-label">نام و خانودگی : </label><br>

                <input type="text" class="form-control bg-white" disabled value="<?= $tuition->name . "  " . $tuition->familiy ?>">
                <input type="hidden" name="user_id" class="form-control bg-white"   value="<?= $tuition->user_id ?>">

            </div>


            <div class="col-md-6">
                <label for="amount" class="form-label">مبلغ پرداختی</label>
                <input type="text" name="amount" class="form-control" value="<?= $tuition->amount ?>" id="amount">

            </div>
            <div class="col-md-6">
                <label for="count_session" class="form-label">تعداد جلسات</label>
                <input type="number" name="count_session" value="<?= $session->total_sessions ?>" class="form-control" id="count_session">
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
                        <option value="<?= $time->id ?>" <?= $time->id == $session->session_id ? 'selected' : '' ?>> ساعت <?= $time->start_time . " تا " . $time->end_time ?> ظرفیت باقیمانده <?=$time->remaining_capacity?></option>
                        
                    <?php } ?>

                </select>
            </div>
            <div class="col-md-6">
                <label for="date_payment" class="form-label">تاریخ پرداخت</label>
                <input type="text" name="date_payment" class="form-control" id="date_payment">
            </div>
            <div class="col-12">
                <button type="submit" class="btn  btn-success">ویرایش</button>
                <button id="delete" class="btn btn-danger" >حذف</button>

            </div>

        </form>
    </div>
</div>
<script src="https://unpkg.com/jalali-moment/dist/jalali-moment.browser.js"></script>

<script>
    $("#date_payment").pDatepicker({
        format: 'YYYY-MM-DD H:m:s',
        calendar: {
            persian: {
                locale: 'en'
            }
        }
    });
    document.getElementById("formUpdate").addEventListener("submit", async (e) => {
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
                fetch("<?= url("admin/tuitions/delete/$tuition->id/$session->id") ?>",{
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