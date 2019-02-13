    <div>
        <nav id="menuNav">
            <div id="menuTitle">Меню<hr></div>
            <div id="menu" >
                <?php foreach ($arrMenu as $key=>$value) { ?>
                <div class="menuItems"><a href="#" id="<?php echo $key; ?>" onclick="onClick(this)" ><?php echo $value; ?></a></div>
                <?php } ?>
                <form class="menuItems" method="post">
                    <a>
                        <input type='submit'  name='destroy' value='Очистить сессию'>
                    </a>
                </form>
            </div>
            <div id="menu"><hr></div>
        </nav>
    </div>