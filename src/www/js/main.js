var DATAGRID = DATAGRID || {};

DATAGRID.common = {
    ajax: function(url, async) {

        if(typeof(async)==='undefined') async = false;

        var xmlhttp,
            output = false;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 ) {
                if(xmlhttp.status == 200){
                    output = xmlhttp.responseText;
                }
                else if(xmlhttp.status == 400) {
                    console.log('There was an error 400');
                    output = false;
                }
                else {
                    console.log('something else other than 200 was returned');
                    output = false;
                }
            }
        }

        xmlhttp.open("GET", url, async);
        xmlhttp.send();

        return output;
    }
}

//console.log(DATAGRID.common.ajax('http://localhost/datagrid/?getJson'));

var td = document.getElementsByClassName('cell');

function getText(e) {
    console.log(e.target.innerHTML);
}

Array.prototype.forEach.call(td, function(e) {
    e.addEventListener('click', getText, false);
});