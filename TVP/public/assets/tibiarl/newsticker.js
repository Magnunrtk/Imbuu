state = new Array("0", "0", "0", "0", "0");

function TickerAction(id) {
  var line = id.substr(12, 1);
  if (state[line] == "0") {
    state[line] = "1";
    OpenNews(id);
  } else {
    state[line] = "0";
    CloseNews(id);
  }
}

function OpenNews(id) {
  var div = document.getElementById(id);
  var idShort = id.concat("-ShortText");
  var idMore = id.concat("-FullText");
  var idButton = id.concat("-Button");
  var idTime = id.concat("-Time");
  document.getElementById(idShort).style.display = "none";
  document.getElementById(idMore).style.display = "block";
  document.getElementById(idTime).style.display = "block";
  document.getElementById(idButton).style.backgroundImage = "url('" + JS_DIR_IMAGES + "general/minus.gif')";
}

function CloseNews(id) {
  var div = document.getElementById(id);
  var idShort = id.concat("-ShortText");
  var idMore = id.concat("-FullText");
  var idButton = id.concat("-Button");
  var idTime = id.concat("-Time");
  document.getElementById(idShort).style.display = "table";
  document.getElementById(idMore).style.display = "none";
  document.getElementById(idTime).style.display = "none";
  document.getElementById(idButton).style.backgroundImage = "url('" + JS_DIR_IMAGES + "general/plus.gif')";
}