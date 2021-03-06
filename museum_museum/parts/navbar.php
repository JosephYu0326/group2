<style>
    .navbar-light .navbar-nav .nav-link.active{
        background-color: #292b2c;
        color: white;
        border-radius: 5px;
        font-weight: 800;
    }
    .navbar{
        border-bottom: 1px solid rgba(102, 102, 102,0.5);
    }
</style>

<div class="content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/group2/museum_museum/museum_list.php">美術館</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName=='Museum' ? 'active' : '' ?>" href="museum_list.php">美術館列表</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $pageName=='Add Museum' ? 'active' : '' ?>" href="add_museum.php">新增美術館</a>
                        </li>
                    </ul>
 
                </div>
            </div>
        </nav>
    </div>


    