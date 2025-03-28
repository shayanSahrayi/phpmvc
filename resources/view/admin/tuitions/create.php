<?php
// ddd(BASE_PATH);

use Morilog\Jalali\Jalalian;

require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>


<div class="row d-flex justify-content-evenly">
    <div class="col-12 dashboard-box bg-white text-black">



        <form class="row g-3 mt-2" method="post" id="formCreate2" action="<?= url("admin/tuitions/store") ?>">
            <div id="alertContainer" class="position-relative">

            </div>
            <h3 class="my-3">مشخصات فردی :</h3>
            <div class="col-md-6">
                <label for="fname" class="form-label">ورزشکار را انتخاب کنید: </label>
                <select name="user" class="js-example-basic-single form-control my-3 p-3">
                    <option value="">انتخاب کنید</option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?= $user->id ?>"><?= $user->first_name . " " . $user->last_name ?></option>
                    <?php } ?>
                </select>
            </div>


            <div class="col-md-6">
                <label for="fname" class="form-label">مبلغ پرداختی</label>
                <input type="text" name="amount" class="form-control" id="amount">

            </div>
            <div class="col-md-6">
                <label for="count_session" class="form-label">تعداد جلسات</label>
                <input type="number" name="count_session" class="form-control" id="count_session">
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">وضعیت دوره</label>
                <select name="status" id="status" class="form-control">
                    <option value="">انتخاب کنید</option>
                    <option value="فعال">دوره فعال</option>
                    <option value="غیر فعال">دوره غیر فعال</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">روز های تمرین :</label>
                <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="days[]" id="saturday" value="7">
                    <label class="form-check-label" for="saturday">شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="days[]" id="sunday" value="1">
                    <label class="form-check-label" for="sunday">یک شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="days[]" id="monday" value="2">
                    <label class="form-check-label" for="monday">دو شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="days[]" id="tuesday" value="3">
                    <label class="form-check-label" for="tuesday">سه شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="days[]" id="wednesday" value="4">
                    <label class="form-check-label" for="wednesday">چهار شنبه</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="days[]" id="thursday" value="5">
                    <label class="form-check-label" for="thursday">پنج شنبه</label>
                </div>
            </div>
            <div class="col-md-6">
                <label for="session_time" class="form-label">ساعت سانس</label>
                <select name="session_time" id="session_time" class="form-control">
                    <option value="">انتخاب کنید</option>
                    <?php foreach ($sessions as $session) { ?>
                        <option value="<?= $session->id ?>">ساعت <?= $session->start_time . " تا " . $session->end_time ?> ظرفیت باقیمانده <?= $session->remaining_capacity ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="date_payment" class="form-label">تاریخ پرداخت</label>
                <input type="text" name="date_payment" class="form-control" id="date_payment">
            </div>
            <div class="col-12">
                <button type="submit" id="create_btn" class="btn  btn-success">ایجاد</button>
            </div>

        </form>
    </div>
</div>
<script src="https://unpkg.com/jalali-moment/dist/jalali-moment.browser.js"></script>
<script>
    $('.js-example-basic-single').select2({
        theme: "bootstrap-5",
    });
    $("#date_payment").pDatepicker({
        format: 'YYYY-MM-DD hh:m:s',
        // format:'LLLL',
        calendar: {
            persian: {
                locale: 'en'
            }
        }
    });
    document.getElementById("formCreate2").addEventListener("submit", async (e) => {
        e.preventDefault();
        const formDatas = new FormData(e.target);
        $("#create_btn").attr('disabled', true);
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
                 
                $("#alertContainer").html('<div class="alert alert-success">' + data.success + '</div>');
            })
            .catch((err) => {
                 $("#alertContainer").html('<div class="alert alert-danger">خطای رخ داده است</div>');
            }).finally(() => {

                $("#alertContainer").animate({
                    'display': 'none',
                    'opacity': 0
                }, 5000, () => {
                    $("#create_btn").attr('disabled', false);
                })

            })
    })
</script>
<?php
require BASE_PATH . "/resources/view/admin/layouts/footer.php";
?>