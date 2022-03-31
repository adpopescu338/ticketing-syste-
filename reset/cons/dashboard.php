<?php
$configs = json_decode(file_get_contents('config.json'));
?>
<html>

<head>
   <meta charset="UTF-8" />
</head>
<style>
body {
   padding-bottom: 20px;
}

#demo-wrap {
   width: 350px;
   padding: 5px;
   position: absolute;
   right: 15px;
   top: 30px;
   box-shadow: 0 0 3px black;
   border-radius: 5px;
   border: 1px solid black;
}

#demo-wrap-1 {
   height: 200px;
   box-shadow: 0 0 3px black;
   border-radius: 5px;
   background-color: <?php echo $configs->body_background_color?>;
   color: <?php echo $configs->text_color?>;
   text-align: center;
   font-size: 40px;
   overflow: hidden;
   padding: 0;
   box-sizing: border-box;
}

#demo-wrap-1-main {
   font-size: 10px;
   display: inline-block;
}

#demo-wrap-2 {
   height: 200px;
   box-shadow: 0 0 3px black;
   border-radius: 5px;
   margin-top: 15px;
   text-align: center;
   line-height: 200px;
   font-size: 25px;
   background-color: <?php echo $configs->custom_message_div_background_color?>;
   color: <?php echo $configs->custom_message_div_text_color?>;

}

textarea {
   padding: 10px;
   font-size: large;
   border-radius: 5px;
   box-shadow: 0 0 3px grey;
}

.small-div {
   color: <?php echo $configs->text_color?>;
   width: 31%;
   text-align: center;
   display: inline-block;
   border: <?php echo $configs->borders ? '0.5px solid black': 'none';
   ?>;
   font-size: 5px;
}

table {
   font-family: arial, sans-serif;
   border-collapse: collapse;
}

td,
th {
   border: 1px solid black;
   text-align: left;
   padding: 8px;
   text-align: center
}

tr:nth-child(even) {
   background-color: #dddddd;
}

td label {
   width: 70px;
   height: 70px;
   line-height: 70px;
   display: inline-block;
   cursor: pointer;
}

td label input {
   margin-top: 28px;
   width: 25px;
}

.tdr {
   width: 70px;
   height: 80px;
   overflow: hidden;
}

input {
   margin-bottom: 10px;
   font-size: large;
   border-radius: 4px;
   padding: 3px;
   width: 100px;
}

label {
   font-size: larger
}

#secondary {
   margin-top: 0.7%;
   height: <?php echo 98 - $configs->main_height?>%;
   border-top: <?php echo $configs->borders ? '1px solid black': 'none';
   ?>;
}

[type='checkbox'],
[type='submit'],
button {
   cursor: pointer
}

.small-div {
   width: <?php echo 100/$configs->number_of_small_divs - 2?>%;
   height: 100%;
}
</style>

<body>
   <form action='./change-config.php'>
      <label>Background color</label>
      <input oninput='editColorBackground(event)' id='background-color' name='background-color'
         value='<?php echo $configs->body_background_color?>'>
      <br />
      <label>Text color</label>
      <input oninput='editColorText(event)' id='text-color' name='text-color' value='<?php echo $configs->text_color?>'>
      <br />
      <label>Message background color</label>
      <input oninput=' editColorBackgroundAlert(event)' id='background-color-alert' name='background-color-alert'
         value='<?php echo $configs->custom_message_div_background_color?>'>
      <br />
      <label>Message text color</label>
      <input oninput='editColorTextAlert(event)' id='text-color-alert' name='text-color-alert'
         value='<?php echo $configs->custom_message_div_text_color?>'>
      <br>
      <label>Percentage height current number section</label>
      <input type='number' oninput='changeHeight(event)' id='main-height' name='main-height'
         value='<?php echo $configs->main_height?>'>
      <br>
      <label for='borders'>Show borders</label>
      <input onchange='changeBorders(event)' type='checkbox' id='borders' name='borders'
         <?php echo $configs->borders ? 'checked' : '' ?>>
      <br>
      <label>Text for current number </label><br>
      <textarea id='template-big' cols="30" rows="5" oninput='manageDivInput(event)'></textarea>
      <input id='hidden-input-1' type='hidden' name='template-big' value="<?php echo $configs->format?>">
      <br>
      <label>Text for previous numbers</label><br>
      <textarea id='template-small' cols="30" rows="5" oninput='manageDivInput(event)'></textarea>
      <input id='hidden-input-2' type='hidden' name='template-small' value="<?php echo $configs->secondary_format?>">
      <br><br><br>
      <label for='audio-alert'>Play audio when there's a message</label>
      <input type='checkbox' id='audio-alert' name='audio-alert'
         <?php echo $configs->audio_custom_message->active ? 'checked' : '' ?>>
      <br>
      <label for='audio-nr'>Play audio when the number changes</label>
      <input type='checkbox' id='audio-nr' name='audio-nr' <?php echo $configs->audio->active ? 'checked' : '' ?>>

      <table id='audios-table'>
         <tr>
            <th>Audio</th>
            <th>When the number changes</th>
            <th>When a message is shown</th>
         </tr>
      </table>

      <br>
      <label>Update interval seconds</label>
      <input type='number' name='fetch-interval' value='<?php echo $configs->fetch_interval?>'>
      <br>
      <label>How many seconds should each number be displayed</label>
      <input type='number' name='delay' value='<?php echo $configs->delay?>'>
      <br>
      <label>How many seconds should custom message be displayed by default</label>
      <input type='number' name='custom_message_delay' value='<?php echo $configs->custom_message_delay?>'>
      <br>
      <label>Number of secondary boxes (preview unavailable) </label>
      <input type="number" name="number_of_small_divs" min="1" max="6"
         value='<?php echo $configs->number_of_small_divs?>'>

      <br><br><br>
      <input type='submit'>
   </form>

   <a href="../reset/"><button>
         <h4>Reset everything to default (will erase all numbers and
            configurations)</h4>
      </button></a>

   <div id='demo-wrap'>
      <h3>Preview</h3>
      <div id='demo-wrap-1'>
         <div style='height: <?php echo $configs->main_height?>%'>
            <span id='demo-wrap-1-main'></span>
         </div>
         <div id='secondary'>
            <?php
            for($i = 0; $i < $configs->number_of_small_divs; $i++){
               echo "<div class='small-div'><span class='small-span'></span></div>";
            }
            ?>
         </div>

      </div>

      <div id='demo-wrap-2'>
         Vă rugăm să păstrați liniștea
      </div>

   </div>
</body>

</html>
<script>
! function injectTemplatesValue() {
   var value = "<?php echo $configs->format?>"
   injectChangesOnDemo('main', value)
   value = value.replace("<span id='counter'>100</span>", '{Number}')
   value = value.replace("<span id='desk'>10</span>", '{Desk}')
   value = value.replace(/<br>/ig, '\n')
   value = value.replace(/&nbsp/ig, ' ')
   document.getElementById('template-big').value = value;
   ///second one
   value = "<?php echo $configs->secondary_format?>"
   injectChangesOnDemo('secondary', value)
   value = value.replace("<span class='counter'>100</span>", '{Number}')
   value = value.replace("<span class='desk'>10</span>", '{Desk}')
   value = value.replace(/<br>/ig, '\n')
   value = value.replace(/&nbsp/ig, ' ')
   document.getElementById('template-small').value = value;
}();

function manageDivInput(e) {
   var value = e.target.value.trim();
   var input = e.target.nextElementSibling;
   var classOrId = event.target.id === 'template-big' ? 'id' : 'class'
   value = value.replace(/ /ig, '&nbsp')
   value = value.replace(/\n/ig, '<br>')
   value = value.replace(/\{Number\}/ig, "<span " + classOrId + "='counter'>100</span>")
   value = value.replace(/\{Desk\}/ig, "<span " + classOrId + "='desk'>10</span>")
   input.value = value;
   classOrId === 'id' ? injectChangesOnDemo('main', value) : injectChangesOnDemo('secondary', value)
}

function injectChangesOnDemo(whichOne, html) {
   if (whichOne === 'main') {
      var div = document.getElementById('demo-wrap-1-main');
      var parent = div.parentElement;
      div.innerHTML = html;
      var font = 10;
      div.style.width = ''
      while (
         div.offsetWidth < parent.offsetWidth - 5 &&
         div.offsetHeight < parent.offsetHeight - 5
      ) {
         font++;
         div.style.fontSize = font + 'px'
      }
      div.style.width = '98%'
   } else {
      resizeSmallDivs(html)
   }
}

function resizeDemo() {
   var fontsize = 70;
   var content = document.getElementById("demo-wrap-1-main");
   var mainDiv = content.parentElement;
   content.style.fontSize = fontsize + "px";
   while (
      content.offsetWidth > mainDiv.offsetWidt - 3 ||
      content.offsetHeight > mainDiv.offsetHeight - 3
   ) {
      fontsize = fontsize - 2;
      content.style.fontSize = fontsize + "px";
   }
}

function editColorBackground(e) {
   document.getElementById('demo-wrap-1').style.backgroundColor = e.target.value
}

function resizeSmallDivs(html) {
   var smallDivs = document.getElementsByClassName('small-div');
   var div = smallDivs[0];
   var span = div.getElementsByClassName('small-span')[0]
   if (html) {
      span.innerHTML = html
   }
   var initialFont = 10;
   var font =  initialFont;
   while (
      font < 200 && //if > 200, it went crazy
      span.offsetWidth < div.offsetWidth - 5 &&
      span.offsetHeight < div.offsetHeight - 5
   ) {
      font += 2;
      span.style.fontSize = font + 'px'
   }
   while (
      font > 5 && //if < 5, it went crazy
      span.offsetWidth > div.offsetWidth - 5 &&
      span.offsetHeight > div.offsetHeight - 5
   ) {
      font -= 2;
      span.style.fontSize = font + 'px'
   }

   var allSpans = document.getElementsByClassName('small-span')
   for (var i = font === initialFont ? 0 : 1; i < allSpans.length; i++) {
      if (html) {
        allSpans[i].innerHTML = html
      }
      allSpans[i].style.fontSize = font + 'px'
   }
}

function editColorText(e) {
   document.getElementById('demo-wrap-1').style.color = e.target.value
   var smallDivs = document.getElementsByClassName('small-div')
   for (var i = 0; i < smallDivs.length; i++) {
      smallDivs[i].style.color = e.target.value
   }
}

function editColorBackgroundAlert(e) {
   document.getElementById('demo-wrap-2').style.backgroundColor = e.target.value
}

function editColorTextAlert(e) {
   document.getElementById('demo-wrap-2').style.color = e.target.value
}

function changeHeight(e) {
   var d = document.getElementById('demo-wrap-1').firstElementChild
   d.style.height = event.target.value + '%';
   d.nextElementSibling.style.height = (98 - event.target.value) + '%';
   resizeDemo()
}

function changeBorders(e) {
   document.getElementById('secondary').style.borderTop = e.target.checked ? '1px solid black' : 'none';
   var smallDivs = document.getElementsByClassName('small-div')
   for (var i = 0; i < smallDivs.length; i++) {
      smallDivs[i].style.border = e.target.checked ? '0.5px solid black' : 'none'
   }
};
! function createAudioTable() {
   <?php
$d = './audio';
$dir = scandir($d);
$dir = array_slice($dir,2, count($dir));
$dir = array_map('prefix_dir', $dir);
function prefix_dir($str){
   return 'audio/'.$str;
}
echo "var audios = ".json_encode($dir);
?>;
   var table = document.getElementById('audios-table')
   var radioconfig1 = "<?php echo $configs->audio->src;  ?>"
   var radioconfig2 = "<?php echo $configs->audio_custom_message->src;  ?>"
   for (let i = 0; i < audios.length; i++) {
      var checked1 = audios[i] === radioconfig1 ? 'checked' : '';
      var checked2 = audios[i] === radioconfig2 ? 'checked' : '';
      var tr = document.createElement('tr')
      var audio = '<td style="width:315px"><audio controls src="' + audios[i] + '"></audio></td>'
      var radio1 = '<td class="tdr"><label for="radio1' + i + '"><input id="radio1' + i + '" type="radio" value="' +
         audios[i] + '" name="audio-for-number-change"' + checked1 + '></label></td>'
      var radio2 = '<td class="tdr"><label for="radio2' + i + '"><input id="radio2' + i + '" type="radio" value="' +
         audios[i] + '" name="audio-for-custom-message"' + checked2 + '></label></td>'
      tr.innerHTML = audio + radio1 + radio2
      table.appendChild(tr)
   }
}();
</script>