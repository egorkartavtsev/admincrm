<<<<<<< Upstream, based on origin/master
(function() {
  CodeMirror.commands.newlineAndIndentContinueMarkdownList = function(cm) {
    var pos = cm.getCursor(), token = cm.getTokenAt(pos);
    var space;
    if (token.className == "string") {
      var full = cm.getRange({line: pos.line, ch: 0}, {line: pos.line, ch: token.end});
      var listStart = /\*|\d+\./, listContinue;
      if (token.string.search(listStart) == 0) {
        var reg = /^[\W]*(\d+)\./g;
        var matches = reg.exec(full);
        if(matches)
          listContinue = (parseInt(matches[1]) + 1) + ".  ";
        else
          listContinue = "*   ";
        space = full.slice(0, token.start);
        if (!/^\s*$/.test(space)) {
          space = "";
          for (var i = 0; i < token.start; ++i) space += " ";
        }
      }
    }

    if (space != null)
      cm.replaceSelection("\n" + space + listContinue, "end");
    else
      cm.execCommand("newlineAndIndent");
  };
})();
=======
<<<<<<< HEAD
(function() {
  CodeMirror.commands.newlineAndIndentContinueMarkdownList = function(cm) {
    var pos = cm.getCursor(), token = cm.getTokenAt(pos);
    var space;
    if (token.className == "string") {
      var full = cm.getRange({line: pos.line, ch: 0}, {line: pos.line, ch: token.end});
      var listStart = /\*|\d+\./, listContinue;
      if (token.string.search(listStart) == 0) {
        var reg = /^[\W]*(\d+)\./g;
        var matches = reg.exec(full);
        if(matches)
          listContinue = (parseInt(matches[1]) + 1) + ".  ";
        else
          listContinue = "*   ";
        space = full.slice(0, token.start);
        if (!/^\s*$/.test(space)) {
          space = "";
          for (var i = 0; i < token.start; ++i) space += " ";
        }
      }
    }

    if (space != null)
      cm.replaceSelection("\n" + space + listContinue, "end");
    else
      cm.execCommand("newlineAndIndent");
  };
})();
=======
(function() {
  CodeMirror.commands.newlineAndIndentContinueMarkdownList = function(cm) {
    var pos = cm.getCursor(), token = cm.getTokenAt(pos);
    var space;
    if (token.className == "string") {
      var full = cm.getRange({line: pos.line, ch: 0}, {line: pos.line, ch: token.end});
      var listStart = /\*|\d+\./, listContinue;
      if (token.string.search(listStart) == 0) {
        var reg = /^[\W]*(\d+)\./g;
        var matches = reg.exec(full);
        if(matches)
          listContinue = (parseInt(matches[1]) + 1) + ".  ";
        else
          listContinue = "*   ";
        space = full.slice(0, token.start);
        if (!/^\s*$/.test(space)) {
          space = "";
          for (var i = 0; i < token.start; ++i) space += " ";
        }
      }
    }

    if (space != null)
      cm.replaceSelection("\n" + space + listContinue, "end");
    else
      cm.execCommand("newlineAndIndent");
  };
})();
>>>>>>> origin/master
>>>>>>> 0ccdbb6 Фиксация 21,01,2019
