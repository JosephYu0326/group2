<?php
require __DIR__ . '/parts/connect_db.php';
$title = '美術館列表';
$pageName = 'Museum';
$t_sql = "SELECT COUNT(1) FROM "

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
                        <h3 class="box-title">美術館</h3>
                    </div>

                    <div class="box-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <i class="fas fa-trash-alt"></i>
                                    </th>
                                    <th scope="col">#</th>
                                    <th scope="col">館名</th>
                                    <th scope="col">位置</th>
                                    <th scope="col">類別</th>
                                    <th scope="col">特色</th>
                                    <th scope="col">介紹</th>
                                    <th scope="col">購票須知</th>
                                    <th scope="col">更多資訊</th>
                                    <th scope="col">
                                        <i class="fas fa-edit"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="#">
                                        <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

        <?php include __DIR__ . '/parts/scripts.php'; ?>
        <?php include __DIR__ . '/parts/html-foot.php'; ?>
    </div>
</div>