<?php

class ViewTags{
    public static function select($array){
        echo "
            <select name='typeItem'>";
            foreach ($array as $key=>$value) {

            };
        echo "
                <option value='1'>Контакт</option>
                <option value='2'>Сделка</option>
                <option value='3'>Компания</option>
                <option value='12'>Покупатель</option>
            </select><br>
        ";
    }
}