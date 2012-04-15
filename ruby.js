/*
 *  ルビ振り君（β）
 *      - Version 1.1
 *      - Published at http://rskull.com/home/
 *
 *  Copyright (C) 2012 R.SkuLL
 */
(function (w) {
    var word = w.getSelection();
    if (word != '') {
        var ruby = new String(word);
        var XHR = new XMLHttpRequest();
        XHR.open('GET', 'http://rskull.com/php/ruby/?word='+encodeURI(ruby));
        XHR.send(null);
        XHR.onreadystatechange = function () {
            if (XHR.readyState == 4 && XHR.status == 200) {
                var json = JSON.parse(XHR.responseText);
                if (json !== null) {
                    for (i = 0; i < json.length; i++) {
                        ruby = ruby.replace(json[i].Surface, '<ruby>'+json[i].Surface+'<rp>(</rp><rt>'+json[i].Furigana+'</rt><rp>)</rp></ruby>');
                    }
                    var range = word.getRangeAt(0).startContainer.parentNode;
                    range.innerHTML = range.innerHTML.replace(word, ruby);
                }
            }
        }
    }
    else {
        alert("Version 1.1");
    }
})(window);