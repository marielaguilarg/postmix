<?php 

include "Controllers/menuController.php";
include "Models/crud_permisos.php";

?>
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <ul class="sidebar-menu" data-widget="tree">
        <?php $menuController=new MenuController();
        echo $menuController->desplegarMenu();?>
</ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
