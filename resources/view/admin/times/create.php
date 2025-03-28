<?php
// ddd(BASE_PATH);

use Morilog\Jalali\Jalalian;

require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>


<div class="row d-flex justify-content-evenly">
    <div class="col-12 dashboard-box bg-white text-black">



        <form class="row g-3 mt-2" method="post" id="createTimes" action="<?= url("admin/times/store") ?>">
            <div id="alertContainer">

            </div>
            <h3 class="my-3"> اطلاعات مربوط به پرداخت :</h3>
            <div class="col-md-6">
                <label for="fname" class="form-label"> ساعت شروع : </label><br>

                <input type="time" class="form-control bg-white" name="start_time" value="">
            </div>


            <div class="col-md-6">
                <label for="end_time" class="form-label">ساعت پایان</label>
                <input type="time" name="end_time" class="form-control" value="" id="end_time">
            </div>

            <div class="col-md-6">
                <label for="capacity" class="form-label">ظرفیت</label>
                <input type="number" name="capacity" value="" class="form-control" id="capacity">
            </div>
            <div class="col-md-6">
            <label for="" class="form-label">جنسیت :</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender"  id="inlineRadio1" value="1">
                    <label class="form-check-label" for="inlineRadio1">مردان</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">بانوان</label>
                </div>
              
            </div>
            <div class="col-md-6">
                <label for="status" class="form-label">وضعیت دوره</label>
                <select name="status" id="status" class="form-control">
                    <option value="">انتخاب کنید</option>
                    <option value="10">دوره فعال</option>
                    <option value="0" >دوره غیر فعال</option>
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn  btn-success">ایجاد</button>
 
            </div>

        </form>
    </div>
</div>
<script src="https://unpkg.com/jalali-moment/dist/jalali-moment.browser.js"></script>

<script>
 
    document.getElementById("createTimes").addEventListener("submit", async (e) => {
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
                fetch("<?= url("admin/tuitions/delete/") ?>", {
                    method: "POST",
                }).then((response) => {
                    if (!response.ok) {
                        throw Error("خطا در حذف");
                    }
                    return response.text();
                }).then((response) => {
                    console.log(response);

                    Swal.fire({
                        title: "عملیات موفق",
                        text: "با موفقیت  حذف شد",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "تمام"
                    }).then((response) => {
                        if (response.isConfirmed) {
                            window.location = "http://localhost/7_box/admin/tuitions/"
                        }
                    })
                }).catch((err) => {
                    document.getElementById("alertContainer").innerHTML = '<div class="alert alert-danger">' + err + '</div>';

                })
            }
        })
    })
</script>
<?php
require BASE_PATH . "/resources/view/admin/layouts/footer.php";
?>