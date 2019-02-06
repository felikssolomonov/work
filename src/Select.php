        <div>
            <form method="post">
                <label>What you want do, select please?</label>
                <select name="option">
                    <?php foreach ($arrAction as $key=>$value) { ?>
                        <option class="menuWWW" value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>
                </select><br>
<!--                <label>Enter name for new Contact:</label>-->
<!--                <input type="text" name="name" placeholder="name of contact" >-->
                <input type="submit" name="adder" value="Перейти">
            </form>
            <form method="post">
                <label>What you want do, select please?</label>
                <input type="submit" name="adder" value="Добавить">
            </form>
        </div>
