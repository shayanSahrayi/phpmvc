<?php
// ddd(BASE_PATH);

use Morilog\Jalali\Jalalian;

require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>


<div class="row d-flex justify-content-evenly">
    <div class="col-12 dashboard-box bg-white text-black">
        <h3 class="my-3">مشخصات فردی :</h3>
        <form class="row g-3 mt-2" method="post" action="<?= url("admin/sms/store") ?>" id="formCreate">

            <div id="alertContainer">

            </div>

            <div class="col-md-6">
                <label for="fname" class="form-label">نام</label>
                <select name="user" class="js-example-basic-single form-control my-3 p-3">
                    <option value="">انتخاب کنید</option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?= $user->id ?>"><?= $user->first_name . " " . $user->last_name ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn  btn-success">ارسال پیام</button>
            </div>

        </form>
    </div>
</div>



<script>
    $('.js-example-basic-single').select2({
        theme: "bootstrap-5",
    });

    document.getElementById("formCreate").addEventListener("submit", async (e) => {
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
</script>
<?php
require BASE_PATH . "/resources/view/admin/layouts/footer.php";
?>