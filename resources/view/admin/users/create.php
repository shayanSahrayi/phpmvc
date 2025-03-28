<?php
// ddd(BASE_PATH);

use Morilog\Jalali\Jalalian;

require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>


<div class="row d-flex justify-content-evenly">
    <div class="col-12 dashboard-box bg-white text-black">
        <h3 class="my-3">مشخصات فردی :</h3>
        <form class="row g-3 mt-2" method="post" enctype="multipart/form-data" action="<?= url("admin/users/store") ?>" id="formCreate">

            <div id="alertContainer">

            </div>

            <div class="col-md-6">
                <label for="fname" class="form-label">نام</label>
                <input type="text" name="fname" class="form-control" id="fname">
            </div>
            <div class="col-md-6">
                <label for="lname" class="form-label"> نام خانوادگی</label>
                <input type="text" name="lname" class="form-control" id="lname">
            </div>
            <div class="col-md-6">
                <label for="tell" class="form-label">شماره تماس</label>
                <input type="text" name="tell" class="form-control" id="tell">
            </div>
            <div class="col-md-6">
                <label for="statuss" class="form-label">وضعیت دوره</label>
                <select name="status" id="statuss" class="form-control">
                    <option value="">انتخاب کنید</option>
                    <option value="1">دوره فعال</option>
                    <option value="0">دوره غیر فعال</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="insurance" class="form-label">وضعیت بیمه</label>
                <select name="insurance" id="insurance" class="form-control">
                    <option value="">انتخاب کنید</option>
                    <option value="10">دارد</option>
                    <option value="0">ندارد</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="insurance_image" class="form-label">اپلود عکس بیمه</label>
                <input type="file" name="insurance_image" class="form-control" id="insurance_image">
            </div>
            <div class="col-12">
                <button type="submit" class="btn  btn-success" id="create_btn">ایجاد</button>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById("formCreate").addEventListener("submit", async (e) => {
        $("#create_btn").attr('disabled', true);
        e.preventDefault();

        const formDatas = new FormData(e.target);
        fetch(e.target.action, {
                method: "POST",
                body: formDatas
            }).then((response) => {
                if (!response.ok) {
                    return response.json().then((error) => {
                        throw new Error(error.error)

                    })
                 }
                return response.json();
            })
            .then((data) => {
                $("#alertContainer").html('<div class="alert alert-success">' + data.success + '</div>');
                $("#alertContainer").animate({
                    'opacity': 0
                }, 5000, () => {
                    $("#create_btn").attr('disabled', false);
                })
            })
            .catch((response) => {
                console.log(response);

                $("#alertContainer").html('<div class="alert alert-danger">' + response + '</div>');
                $("#alertContainer").animate({
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