<?php

class ViewLeads implements View {
    public function __construct(){
    }
    public function add(){
        echo "
    <div>
        <form method='post'>
            <label>It's form to add leads</label>
            <input type='number' min='1' max='10000' name='num' placeholder='number'><br>
            <input type='text' name='name' placeholder='name'><br>
            <input type='submit'  name='viewSend' value='Отправить'><br>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </form>
    </div>";
    }
    public function show(){
        echo "<div><form method='post'><label>It's form to see list leads</label></form></div>";
    }
    public function update(){
        echo "<div><form method='post'><label>It's form to update leads</label></form></div>";
    }
}