<?php
$configs = json_decode(file_get_contents('config.json'));
?>
<html>

<head>
   <meta charset="UTF-8" />
   <script>
   var interval = <?php echo $configs->fetch_interval*1000?>
   </script>
</head>
<style>
body {
   background-color: <?php echo $configs->body_background_color?>;
   text-align: center;
   overflow: hidden;
}

#content {
   color: <?php echo $configs->text_color?>;
   font-weight: bolder;
}

#main {
   height: <?php echo $configs->main_height?>vh;
   margin-bottom: 0.7vh;
}

#custom-message-div {
   width: 98vw;
   height: 98vh;
   top: 1vh;
   left: 1vw;
   position: absolute;
   background-color: <?php echo $configs->custom_message_div_background_color?>;
   color: <?php echo $configs->custom_message_div_text_color?>;
   opacity: 0;
}

#secondary {
   border-top: <?php echo $configs->borders ? '2px solid black': 'none';
   ?>;
}

.secondary-div {
   color: <?php echo $configs->text_color?>;
   width: 32vw;
   height: <?php echo 98 - $configs->main_height?>vh;
   ;
   text-align: center;
   display: inline-block;
   border: <?php echo $configs->borders ? '1px solid black': 'none';
   ?>;
}
</style>

<body>
   <div id='main'>
      <span id="content">
         <?php echo $configs->format?>
      </span>
   </div>

   <div id='secondary' style='text-align:center'>

   </div>

   <div id='custom-message-div'>
      <span id='cmds'></span>
   </div>
</body>

</html>
<script>
var id_counter = document.getElementById("counter");
var paused = false
var deskContainer = document.getElementById("desk");
var custom_message_div = document.getElementById("custom-message-div");
var secondaryContainer = document.getElementById('secondary');

function adjust_font() {
   var fontsize = 60;
   var content = document.getElementById("content");
   var mainDiv = document.getElementById("main");
   content.style.fontSize = fontsize + "vw";
   while (
      content.offsetWidth > mainDiv.offsetWidt - 5 ||
      content.offsetHeight > mainDiv.offsetHeight - 5
   ) {
      fontsize = fontsize - 2;
      content.style.fontSize = fontsize + "vw";
   }
}
adjust_font()

function update_content(data) {
   if (data.custom_message) {
      adjust_customMessageFont(data.custom_message.text)
   } else {
      document.getElementById('cmds').textContent = ''
      custom_message_div.style.opacity = 0;
      if (content_is_the_same(data)) {
         setTimeout(get_data_from_server, interval);
         return
      };
      id_counter.textContent = data.current.number;
      deskContainer.textContent = data.current.desk
      secondaryContainer.innerHTML = ''
      for (var i = 0; i < data.past.length; i++) {
         var prev = data.past[i]
         var divBig = document.createElement('div')
         divBig.setAttribute('class', 'secondary-div')
         var div = document.createElement('span')
         div.innerHTML = "<?php echo $configs->secondary_format?>"
         divBig.appendChild(div)
         secondaryContainer.appendChild(divBig)
         div.getElementsByClassName('counter')[0].textContent = prev.number
         div.getElementsByClassName('desk')[0].textContent = prev.desk
         var initialFontSize = 20;
         while (
            div.offsetWidth < divBig.offsetWidth - 10 &&
            div.offsetHeight < divBig.offsetHeight - 10
         ) {
            initialFontSize += 2;
            div.style.fontSize = initialFontSize + 'px'
         }
      }
      setTimeout(get_data_from_server, interval);
   }
}

function get_data_from_server() {
   if (paused) return;
   var xhr = new XMLHttpRequest();
   xhr.onload = function() {
      var data = JSON.parse(this.responseText);
      update_content(data);
   };
   xhr.open("GET", "queue.json?" + Math.random());
   xhr.send();
}

function adjust_customMessageFont(text) {
   var span = document.getElementById('cmds')
   if (text === span.textContent) {
      setTimeout(get_data_from_server, interval);
      return
   }
   custom_message_div.style.opacity = 1;
   span.textContent = text;
   var fontSize = 60;
   span.style.fontSize = fontSize + 'vw';
   while (
      span.offsetWidth > custom_message_div.offsetWidth - 5 ||
      span.offsetHeight > custom_message_div.offsetHeight - 5
   ) {
      fontSize -= 2;
      span.style.fontSize = fontSize + 'vw';
   }
   setTimeout(get_data_from_server, interval);
}

function content_is_the_same(data) {
   var currentDesk = deskContainer.textContent;
   var currentNumber = id_counter.textContent;
   var receivedDesk = data.current.desk;
   var receivedNumber = data.current.number;
   if (data.custom_message && custom_message_div.style.opacity == 1 && custom_message_div.firstElementChild
      .textContent === data.custom_message.text)
      return false;
   if (
      deskContainer.textContent == data.current.desk &&
      id_counter.textContent == data.current.number
   ) return true;
   return false;
}
</script>