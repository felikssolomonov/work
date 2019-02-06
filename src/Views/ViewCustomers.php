<?php

class ViewCustomers implements View{
    public function __construct(){
    }
    public function add(){
        echo "
    <div>
        <form method='post'>
            <label>It's form to add customers</label>
            <input type='number' min='1' max='10000' name='num' placeholder='number'><br>
            <input type='text' name='name' placeholder='name'><br>
            <input type='date'  name='date'><br>
            <input type='submit'  name='viewSend' value='Отправить'><br>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </form>
    </div>";
    }
    public function show(){
        echo "<div><form method='post'><label>It's form to see list customers</label></form></div>";
    }
    public function update(){
        echo "<div><form method='post'><label>It's form to update customers</label></form></div>";
    }
}