<?php

use Morilog\Jalali\Jalalian;

include "layouts/header.php";
?>
<div class="row">
    <div class="col-md-3">
        <div class="dashboard-box box-color">تعداد کل کاربران: <?= $users->count() ?></div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-box box-color"> تعداد کاربران فعال <?= $users->where('deleted_at', null)->count() ?> </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-box box-color"> پرداختی های این ماه: <?= ($monthlySales->total == null || $monthlySales->total == 0) ? '0' : number_format($monthlySales->total, 3) ?> تومان </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-box box-color"> کل پرداختی ها: <?= number_format($totalSales->total, 3) ?> تومان</div>
    </div>
</div>
<div class="row mt-4">

    <div class="col-12">
        <div class="dashboard-box bg-white text-dark ">
            <h1>لیست حضور غیاب </h1>
            <div class="col p-3 m-3">
                <h6 class="m-3">امروز <?= Jalalian::forge('now')->format('%A') ?> سانس ساعت <?= $users_sessions[0]->start ?? date('H', strtotime('-1 hour')); ?>:</h6>
                <div class="col-12 d-flex users p-3 flex-wrap" id="users_sessions">

                </div>
                <hr>
                <h6 class="m-3">لیست افراد حاظر بدون سانس</h6>
                <div class="col-auto">
                    <label for="usersearch" class="form-label">ورزشکار را انتخاب کنید: </label>
                    <select name="user" class="js-example-basic-single form-control my-3 p-3" id="usersearch">
                        <option value="">انتخاب کنید</option>
                        <?php foreach ($usersList as $user) { ?>
                            <option value="<?= $user->id ?>"><?= $user->first_name . " " . $user->last_name ?> </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-12 d-flex users p-3 flex-wrap" id="users_sessions_manual">
                <?php
                    foreach ($manualAttendaces as $userItem) {
                    ?>
                    <div class="card m-3">
                        <div class="card-head text-center">
                            <a class='text-decoration-none text-success fs-1 d-block' target='_blank' href="<?= url('admin/users/edit/') ?>${data.user_id}"><i class="fa fa-user"></i></a>
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <a class='text-decoration-none' target='_blank' href="<?= url('admin/users/edit/') ?><?=$userItem->user_id?>"><span class='text-primary'><?=$userItem->name."  ".$userItem->family?></span></a>

                            <span>تعداد جلسات باقی مانده :<span class='text-danger'> <?=$userItem->remaining_sessions==0 ? "جلسه اخر" : ($userItem->remaining_sessions -1)?></span></span>
                            <span>تعداد روز باقی مانده :<span class='text-danger'> <?=(29 - $userItem->date)?> روز</span></span>
                        </div>
                        <div class="card-footer bg-white text-center">
                            <button class="btn w-100  btn-danger" data-re=<?=($userItem->remaining_sessions-1)?> data-id="<?=$userItem->users_session_id?>" onclick='absent(event)'>غایب</button>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="dashboard-box bg-white text-dark">نمودار فروش
            <canvas id="myLineChart" width="400" height="200"></canvas>


        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-box bg-white text-dark ">
            لیست کاربران جدید
            <table class="table table-striped texr-right my-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام و نام خانوادگی</th>
                        <th>تاریخ ثبت نام</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    foreach ($newusers as $user) { ?>

                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= $user->first_name . " " . $user->last_name ?></td>
                            <td><?= Jalalian::forge($user->created_at)->ago() ?></td>
                            <td><a href="<?= url('admin/users/edit/' . $user->id) ?>" class="btn btn-sm <?= ($counter % 2 == 0) ? 'btn-danger' : 'btn-warning' ?>">مشاهده</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="dashboard-box bg-white text-dark ">
            لیست پرداختی های جدید
            <table class="table table-striped texr-right my-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام و نام خانوادگی</th>
                        <th>مبلغ پرداختی</th>
                        <th>تاریخ پرداخت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $counter = 1;
                    foreach ($Laset_transactions as $item) { ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= $item->first_name . $item->last_name ?></td>
                            <td><?= $item->amount ?></td>
                            <td><?= \Morilog\Jalali\Jalalian::forge($item->created_at)->ago() ?></td>

                            <td><a href="<?= url('admin/tuitions/edit/' . $item->id) ?>" class="btn btn-sm <?= ($counter % 2 == 0) ? 'btn-danger' : 'btn-warning' ?>">مشاهده</a></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-box bg-white text-dark">
            کاربران رو به اتمام
            <table class="table table-striped texr-right my-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام و نام خانوادگی</th>
                        <th>تاریخ تمدید</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $day = date('Y-m-d');
                    $today = new DateTime();
                    $counter = 1;

                    foreach ($coming_ends as $item) {
                        $earlier = new DateTime($item->date);
                    ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= $item->name . $item->family ?></td>
                            <td><?= $today->diff($earlier)->format('%d روز') ?> باقی مانده تا تمام دوره</td>
                            <td><a href="<?= url('admin/users/edit/' . $item->user_id) ?>" class="btn btn-sm <?= ($counter % 2 == 0) ? 'btn-danger' : 'btn-warning' ?>">مشاهده</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-4">
        <div class="dashboard-box bg-white text-dark">وظایف امروز</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // دریافت عنصر Canvas
        const ctx = document.getElementById('myLineChart').getContext('2d');

        // ایجاد نمودار خطی
        const myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور'],
                datasets: [{
                        label: 'تراکنش های ماهانه  از شهریه)',
                        data: [120, 19, 3, 5, 2, 3],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // پس‌زمینه
                        borderColor: 'rgba(54, 162, 235, 1)', // رنگ خط
                        borderWidth: 2,
                        fill: true, // پر کردن زیر خط
                        tension: 1
                    },
                    {
                        label: 'تراکنش های ماهانه از فروش  ',
                        data: [1.2, 190, 39, 15, 23, 300],
                        backgroundColor: 'rgba(235, 114, 54, 0.2)', // پس‌زمینه
                        borderColor: 'rgb(235, 54, 142)', // رنگ خط
                        borderWidth: 2,
                        fill: true, // پر کردن زیر خط
                        tension: 1
                    },
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'آمار ماهانه'
                    },
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        $('.js-example-basic-single').select2({
            theme: "bootstrap-5",
        });



        function fetchUserSession() {

            fetch("<?= url('admin/attendees-refresh') ?>", {
                method: "POST",
            }).then((response) => {

                if (!response.ok) {

                    throw new Error("hav error")
                }
                return response.json();
            }).then((response) => {

                data = response['data']
                $("#users_sessions").empty();

                data.forEach(element => {
                    content = `<div class="card m-3">
                        <div class="card-head text-center">
                            <a class='text-decoration-none text-success fs-1 d-block' target='_blank' href="<?= url('admin/users/edit/') ?>${element.user_id}"><i class="fa fa-user"></i></a>
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                       <a class='text-decoration-none' target='_blank' href="<?= url('admin/users/edit/') ?>${element.user_id}"><span class='text-primary'> ${element.name} ${element.family}</span></a>
                          
                           <span>تعداد جلسات باقی مانده :<span class='text-danger'> ${element.remaining_sessions==0? "جلسه اخر":element.remaining_sessions}</span></span> 
                           <span>تعداد روز باقی مانده :<span class='text-danger'> ${(29-element.date)} روز</span></span>
                         </div>
                        <div class="card-footer bg-white text-center">
                            <button  class="btn w-100  btn-danger" data-re=${element.remaining_sessions} data-id="${element.id}" onclick='absent(event)'>غایب</button>
                        </div>
                    </div>`
                    $("#users_sessions").append(content)
                });
            }).catch((err) => {
                console.log(err);

            })
        }
        fetchUserSession()
        setInterval(fetchUserSession, 2 * 60 * 1000)

        function absent(e) {
            let id = e.target.dataset.id;
            let re = e.target.dataset.re;
            const data = new URLSearchParams();
            data.append('id', id);
            data.append('re', re)

            fetch("<?= url('admin/absent') ?>", {
                    method: "POST",
                    body: data
                }).then((response) => {
                    if (!response.ok) {
                        throw new Error("hav error");
                    }
                    return response.json();
                }).then((response) => {
                    console.log(response);

                })
                .catch((err) => {
                    console.log(err)
                })
        }
        $("#usersearch").on('change', (e) => {
            let data = new URLSearchParams({
                'id': e.target.value
            });

            console.log(e.target.value);
            fetch("<?= url('admin/attendees') ?>", {
                    method: "POST",
                    body: data
                }).then((response) => {
                    if (!response.ok) {
                        throw new Error("خطای رخ داده است");
                    }
                    return response.json();
                }).then((response) => {
                    console.log(response);

                    data = response['success']

 
                    content = `<div class="card m-3">
                        <div class="card-head text-center">
                            <a class='text-decoration-none text-success fs-1 d-block' target='_blank' href="<?= url('admin/users/edit/') ?>${data.user_id}"><i class="fa fa-user"></i></a>
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                       <a class='text-decoration-none' target='_blank' href="<?= url('admin/users/edit/') ?>${data.user_id}"><span class='text-primary'> ${data.name} ${data.family}</span></a>
                          
                           <span>تعداد جلسات باقی مانده :<span class='text-danger'> ${data.remaining_sessions==0 ? "جلسه اخر" : (data.remaining_sessions-1)}</span></span> 
                           <span>تعداد روز باقی مانده :<span class='text-danger'> ${(29 - data.date)} روز</span></span>
                         </div>
                        <div class="card-footer bg-white text-center">
                            <button  class="btn w-100  btn-danger" data-re=${data.remaining_sessions-1} data-id="${data.id}" onclick='absent(event)'>غایب</button>
                        </div>
                    </div>`
                    $("#users_sessions_manual").append(content)

                })
                .catch((err) => console.log(err));

        })
    </script>
    <?php
    include "layouts/footer.php";
    ?>