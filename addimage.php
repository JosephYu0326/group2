<?php
$title = 'Add image';
$pageName = 'Add image';
require_once 'parts/connect_db.php';
$sid = isset($_GET['Museum_id']) ? intval($_GET['Museum_id']) : 0;


$sql = "select Museum_id,Museum_name from museum_museum";
$sql1 = "SELECT Museum_id,Museum_name from museum_museum where Museum_id=$sid";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll();
} catch (Exception $ex) {
    echo ($ex->getMessage());
}
$row = $pdo->query($sql1)->fetchAll();
?>


<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<?php include __DIR__ . '/parts/nav.php'; ?>

<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="statusMsg"></div>
                        <h3 class="box-title mt-3">上傳圖片</h3>
                    </div>
                    <div class="box-body">
                        <form id="Form1" enctype="multipart/form-data">
                            <div class="main-form">
                                <div class="col-lg-6 mt-3 ">
                                    <div class="form-group">
                                        <label for="museum_name" class="form-label">館名</label>
                                        <select name="Museum_id[]" id="Museum_id" class="form-select">
                                            <?php foreach ($row as $output) { ?>
                                                <option selected value="<?= $output["Museum_id"] ?>"><?= $output["Museum_name"] ?></option>
                                            <?php } ?>
                                            <option>-- select Museum --</option>
                                            <?php foreach ($results as $output) { ?>
                                                <option value="<?= $output["Museum_id"] ?>"><?= $output["Museum_name"] ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <div class="form-text"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6 mt-3 ">
                                    <label for="file">上傳圖片</label>
                                    <input type="file" class="form-control" id="file" name="image_url[]" multiple />
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-success submitBtn" value="SUBMIT" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/parts/scripts.php'; ?>
<script>
    $(document).ready(function(){
        $("#Form1").on('submit',function(e){
            e.preventDefault();
            $.ajax({
                type:'POST',
                url:'submit.php',
                data: new FormData(this),
                dataType:'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function(){
                    $('.submitBtn').attr("disabled","disabled");
                    $("#Form1").css("opacity",".5");
                },
                success: function(response){
                    $('.statusMsg').html('');
                    if(response.status == 1){
                        $('#Form1')[0].reset();
                        $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
                    }else{
                        $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
                    }
                    $("Form1").css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                }
            });
        });
        var match = ['image/jpeg', 'image/png', 'image/jpg'];
        $("#file").change(function() {
        for(i=0;i<this.files.length;i++){
            var file = this.files[i];
            var fileType = file.type;
			
            if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))){
                alert('Sorry, only JPG, JPEG, & PNG files are allowed to upload.');
                $("#file").val('');
                return false;
            }
        }
    });
        
    });

    
</script>
<?php include __DIR__ . '/parts/html-foot.php'; ?>