    <div>
        <nav id="menuNav">
            <div id="menuTitle">Меню<hr></div>
            <div id="menu" >
                <?php foreach ($arrMenu as $key=>$value) { ?>
                <div class="menuItems"><a href="#" id="<?php echo $key; ?>" onclick="onClick(this)" ><?php echo $value; ?></a></div>
                <?php } ?>
            </div>
            <div id="menu"><hr></div>
        </nav>
    </div>