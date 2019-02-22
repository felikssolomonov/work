<input type='email' name='email' placeholder='email'><br>
<input type='text' name='position' placeholder='position'><br>
<input type='text' name='text' placeholder='text'><br>
<input type='number' name='number' placeholder='number'><br>
<label>Select: </label>
<input type='checkbox' name='flag' placeholder='flag'><br>
<select name='list' style='width: 180px'>
    <option >select please!</option>
    <option value='listOption1'>listOption1</option>
    <option value='listOption1'>listOption2</option>
    <option value='listOption1'>listOption3</option>
    <option value='listOption1'>listOption4</option>
</select><br><br>
<select name='multiList[]' size='3' multiple style='width: 180px'>
    <option value='listOption1' itemtype='checkbox'>listOption1</option>
    <option value='listOption1'>listOption2</option>
    <option value='listOption1'>listOption3</option>
    <option value='listOption1'>listOption4</option>
    <option value='listOption1'>listOption5</option>
</select><br>
<label>Date: </label>
<input type='date'  name='date' value='2018-07-22'><br>
<input type='url' name='link' placeholder='url'><br>
<input type='text' name='textarea' placeholder='textarea'><br>
<div>
    <input type='radio' name='switch' value='switch1'>switch1<br>
    <input type='radio' name='switch' value='switch2' checked>switch2<br>
    <input type='radio' name='switch' value='switch2'>switch3<br>
    <input type='radio' name='switch' value='switch2'>switch4<br>
</div><br>
<input type='text' name='shortAddress' placeholder='short address'><br>
<div class='multiselect'>
    <div class='selectBox' onclick='showCheckboxes()'>
        <select>
            <option>Select an option</option>
        </select>
        <div class='overSelect'></div>
    </div>
    <div id='checkboxes'>
        <label for='one'>
            <input type='checkbox' id='one'/>First checkbox</label>
        <label for='two'>
            <input type='checkbox' id='two' />Second checkbox</label>
        <label for='three'>
            <input type='checkbox' id='three' />Third checkbox</label>
    </div>
</div>
<label>Address: </label>
<div class='multiselect'>
    <div class='selectBox' onclick='showInputs()'>
        <select name='tel2[]'>
            <option>Select an option</option>
        </select>
        <div class='overSelect'></div>
    </div>
    <div id='inputs'>
        <label for='one'>
            <input type='text' id='one' placeholder='First checkbox'/></label>
        <label for='two'>
            <input type='text' id='two' placeholder='Second checkbox'/></label>
        <label for='three'>
            <input type='text' id='three' placeholder='Third checkbox'/></label>
    </div>
</div>
<label>Birthday: </label>
<input type='date'  name='birthday' value='2000-07-22'><br>
<input type='submit'  name='viewSend' value='Отправить'><br>


<input type="text" name="city" list="cityname">
<datalist id="cityname">
    <select>
        <option value="Boston">
        <option value="Cambridge">
    </select>
</datalist>

<select name='multiList[]' size='3' multiple style='width: 180px'>
    <option value='listOption1' itemtype=''>listOption1</option>
    <option value='listOption1' >listOption2</option>
    <option value='listOption1'>listOption3</option>
    <option value='listOption1'>listOption4</option>
    <option value='listOption1'>listOption5</option>
</select><br>

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//        print_r($this->data);
//        echo "<pre>";
//        var_dump($this->data);
//        echo "</pre>";
//        echo "<br>";

//        $this->data = [
//            'add' => [
//                0 => [
//                    'name' => $_POST['name'],
//                    'custom_fields' => [
//                        0 => [
//                            'id' => '225283',
//                            'values' => [
//                                0 => [
//                                    'value' => $_POST['tel'],
//                                    'enum' => 'MOB',
//                                ],
//                            ],
//                        ],
//                        1 => [
//                            'id' => '225285',
//                            'values' => [
//                                0 => [
//                                    'value' => $_POST['email'],
//                                    'enum' => 'WORK',
//                                ],
//                            ],
//                        ],
//                        2 => [
//                            'id' => '225281',
//                            'values' => [
//                                0 => [
//                                    'value' => $_POST['position'],
//                                ],
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ];