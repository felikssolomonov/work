    <div>
        <nav id="menuHrefs">
            <div id="menu">Меню<hr></div>
            <div id="menuWW" >
                <?php foreach ($arrMenu as $key=>$value) { ?>
                <div class="menuWWW"><a href="#" id="<?php echo $key; ?>" onclick="onClick(this)" ><?php echo $value; ?></a></div>
                <?php } ?>
            </div>
            <div id="menu"><hr></div>
        </nav>
    </div>