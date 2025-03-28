<?php
// ddd(BASE_PATH);
require BASE_PATH . "/resources/view/admin/layouts/header.php";
// include "../layouts/header.php";
?>


<div class="row">
    <div class="col-12">
        <div class="dashboard-box bg-white text-dark">
            <h3>جستجوی کاربر :</h3>
 
                <input class="form-control my-3 p-3" id="search" type="text" placeholder="نام یا نام خانوادگی،کد ملی یا شماره تماس را وارد کنید">
 
        </div>
    </div>
    <div class="col-12">
        <div class="dashboard-box">
            <table class="table table-resposive table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام و نام خانوادگی</th>
                        <th>هزینه پرداخت</th>
                        <th>وضعیت پرداخت</th>
                        <th>تاریخ پرداخت</th>
                        <th>عملیات </th>
                    </tr>
                </thead>
                <tbody id="tbody">

                    <?php
                    $counter = ((int)$tuitions['record']) + 1;
                    
                    foreach ($tuitions['data'] as $tuition) {
                    ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= $tuition->name ." ".$tuition->familiy ?></td>
                            <td><?= $tuition->amount ?></td>
                            <td>
                                <a href="" class="btn btn-sm <?= $tuition->status == 'غیر فعال' ? 'btn-danger' : 'btn-success' ?>">
                                    <?= $tuition->status ?>
                                </a>

                            </td>
                            <td><?= \Morilog\Jalali\Jalalian::forge($tuition->created_at) ?></td>
                            <td>
                                <a href="<?=url('admin/tuitions/edit/'.$tuition->id    )?>" class="btn btn-sm btn-danger">ویرایش</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
            <div class="col-12 text-center" id="pages">
             
            <?php
                $count = $tuitions['pages'];
                for ($i = 1; $i < $count; $i++) {
                ?>
                    <a href="?page=<?= $i ?>" class="btn btn-md <?= $tuitions['current_page'] == $i ? 'btn-danger ' : 'btn-primary' ?> pagination_link"> <?= $i ?></a>
                <?php } ?>

            </div>
        </div>
    </div>
</div>



</script>
<script>
    $("#search").on("keyup",(e)=>{
            e.preventDefault();
               if(e.target.value.length>3){
                $("#tbody").empty();
                $("#pages").empty()
            $.ajax({
                url:"<?=url("admin/search-tuitions")?>",
                method:"POST",
                data:{'search':e.target.value},
                success:(response)=>{
                    data=JSON.parse(response);
                    counter=1;
                    data['data'].forEach(element => {
                        content="<tr>";
                        content+=`<td>${counter++}</td>`;
                        content+=`<td>${element.name} ${element.family} </td>`;
                        content+=`<td>${element.amount} </td>`;
                        content+=`<td><a class='btn ${element.status=='فعال'? 'btn-success':'btn-danger'}'> ${element.status} </td>`;
                        content+=`<td>  ${element.date==null ? element.created_at :element.date} </td>`;
                        content+=`<td> <a class='btn btn-danger' href="<?=url('admin/tuitions/edit/')?>${element.id}">مشاهده</a> </td>`;
                        content+=`</tr>`;
                        $("#tbody").append(content);
                        
                    });
                },
                error:(err)=>{
                    console.log(errr);

                }
            })
        }
    })
</script>
<?php
require BASE_PATH . "/resources/view/admin/layouts/footer.php";
?>