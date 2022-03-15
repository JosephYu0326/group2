<?php
$title = 'Add Ticket';
$pageName = 'Add Ticket';
require_once 'parts/connect_db.php';
?>


<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '/parts/nav.php'; ?>

<div class="content-wrapper">
    <div class="content ">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title mt-3">新增票券<a href="javascript:void(0)" class="float-end btn btn-dark me-3 add-more-form">增加票種</a></h3>
                    </div>
                    <div class="box-body">
                        <form name="form1" method="post" novalidate onsubmit="checkForm(); return false;">
                            <div class="main-form">
                                <div class="col-lg-6 mt-3 ">
                                    <div class="form-group">
                                        <label for="museum_name" class="form-label">館名</label>
                                        <input type="text" class="form-control" id="museum_name" name="Museum_id" required>
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <div class="form-group">
                                        <label for="Museum_price_kind" class="form-label">票種</label>
                                        <input type="text" class="form-control" id="Museum_price_kind" name="Museum_price_kind" required>
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <div class="form-group">
                                        <label for="Museum_ticket_price" class="form-label">票價</label>
                                        <input type="text" class="form-control" id="Museum_ticket_price" name="Museum_ticket_price" required>
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-3">
                                    <div class="form-group">
                                        <button type="button" class="remove-btn btn btn-danger mb-3">移除</button>
                                    </div>
                                </div>
                            </div>
                            <div class="paste-new-forms">

                            </div>
                            <div class="col-lg-6 mt-3">
                                <button type="submit" class="btn btn-dark mb-3">新增</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    $(document).ready(function() {
        $(document).on('click', '.remove-btn', function() {
            $(this).closest('.main-form').remove();
        })
        $(document).on('click', '.add-more-form', function() {
            $('.paste-new-forms').append('<div class="main-form">\
                                <div class="col-lg-6 mt-3 ">\
                                    <div class="form-group">\
                                        <label for="museum_name" class="form-label">館名</label>\
                                        <input type="text" class="form-control" id="museum_name" name="Museum_id" required>\
                                        <div class="form-text"></div>\
                                    </div>\
                                </div>\
                                <div class="col-lg-6 mt-3">\
                                    <div class="form-group">\
                                        <label for="Museum_price_kind" class="form-label">票種</label>\
                                        <input type="text" class="form-control" id="Museum_price_kind" name="Museum_price_kind" required>\
                                        <div class="form-text"></div>\
                                    </div>\
                                </div>\
                                <div class="col-lg-6 mt-3">\
                                    <div class="form-group">\
                                        <label for="Museum_ticket_price" class="form-label">票價</label>\
                                        <input type="text" class="form-control" id="Museum_ticket_price" name="Museum_ticket_price" required>\
                                        <div class="form-text"></div>\
                                    </div>\
                                </div>\
                                <div class="col-lg-6 mt-3">\
                                    <div class="form-group">\
                                        <button type="button" class="remove-btn btn btn-danger mb-3">移除</button>\
                                    </div>\
                                </div>\
                            </div>');
        });
    })
</script>
<script>
    const name = document.form1.museum_name;
    const name_msg = museum_name.closest('.mt-3').querySelector('.form-text');
    // const features_msg = Museum_features.closest('.mb-3').querySelector('.form-text');

    function checkForm(){
        let isPass = true;
        if( museum_name.value.length<2){
            isPass = false;
            name_msg.innerText= '請填寫正確的姓名'
        }
        // if(Museum_features.value.length>50){
        //     isPass = false;
        //     features_msg.innerText='字數不得超過50字'
        // }

        //TODO: 表單資料送出之前，要做格式檢查


        if(isPass){
            
            const fd = new FormData(document.form1);

            
            fetch('add_ticket_api.php',{
                method:'POST',
                body: fd
            }).then(r => r.json())
            .then(obj=>{
                console.log(obj);
                if(obj.success){
                    alert('新增成功');
                    // location.href='ab-list.php';
                }else{
                    alert('新增失敗');
                }
            })
         
        }
    }
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>