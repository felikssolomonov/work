<?php

class ViewContacts implements View{
    public function __construct(){
    }
    public function add(){
        echo "
    <div>
        <form method='post'>
            <label>It's form to add contacts</label><br>
            <input type='text' name='name' placeholder='name'>
            <input type='number' min='1' max='10000' name='num' placeholder='number'><br>
            <div>
                 <input name='tel[address][value]' placeholder='Адрес'>
                 <input name='tel[address][enum]' placeholder='Адрес' list='enum'>
                 <datalist id='enum'>
                    <option value='MOB'></option>
                    <option value='HOME'></option>
                    <option value='WORK'></option>
                 </datalist>
            </div>
            <input type='submit'  name='viewSend' value='Отправить'><br>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </form>
    </div>";
    }
    public function show(){
        echo "<div><form method='post'><label>It's form to see list contacts</label></form></div>";
    }
    public function update(){
        echo "<div><form method='post'><label>It's form to update contacts</label></form></div>";
    }
}