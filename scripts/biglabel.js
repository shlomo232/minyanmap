function updateInfowindow(map,marker) {
     if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest(); }// modern browsers
     else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }// IE 5,6
     xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            eval(xmlhttp.responseText);
    } }
    xmlhttp.open("GET","getshulinfo.php?shulid="+marker.shulid,true);
    xmlhttp.send();
    infowindow.open(map,marker);
}

// Define the overlay, derived from google.maps.OverlayView . Based on http://blog.mridey.com/2011/05/label-overlay-example-for-google-maps.html
function BigLabel(opt_options, shulid, shulname, infowindow) {
    // Initialization
    this.setValues(opt_options);
    this.shulid=shulid;
    this.shulname=shulname;
    this.infowindow=infowindow;
    // Label specific
    var span = this.span_ = document.createElement('span');
    span.style.cssText = 'position: relative; left: -50%; top: -8px; cursor:pointer;' +
                          'white-space: nowrap; border: 1px solid blue; ' +
                          'padding: 1px; background-color: #FFFF88;' +
                          'font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 8pt;';
    var div = this.div_ = document.createElement('div');
    div.appendChild(span);
    div.style.cssText = 'position:absolute; display:none';
}

BigLabel.prototype = new google.maps.OverlayView;

BigLabel.prototype.onAdd = function() {
    var pane = this.getPanes().overlayLayer;
    pane.appendChild(this.div_);

    // Ensures the label is redrawn if the text or position is changed.
    var me = this; // because value of "this" changes when the listeners are passed on

    this.listeners_ = [
        google.maps.event.addListener(this, 'position_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'text_changed', function() { me.draw(); }),
        google.maps.event.addDomListener(this.div_, 'click', function() {
            updateInfowindow(map,me);

/*          if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest(); }// modern browsers
            else { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }// IE 5,6
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) { eval(xmlhttp.responseText); } }
            xmlhttp.open("GET","getshulinfo.php?shulid="+me.shulid,true);
            xmlhttp.send();
            infowindow.open(map,me);
*/
        })
 ];
};

BigLabel.prototype.onRemove = function() {
    this.div_.parentNode.removeChild(this.div_);
    // Label is removed from the map, stop updating its position/text.
    for (var i=0, I=this.listeners_.length; i<I; ++i) {
      google.maps.event.removeListener(this.listeners_[i]);
    }
};

BigLabel.prototype.draw = function() {
    var projection = this.getProjection();
    var position = projection.fromLatLngToDivPixel(this.get('position'));

    var div = this.div_;
    div.style.left = position.x + 'px';
    div.style.top = position.y + 'px';
    div.style.display = 'block';
//    div.innerHTML="xxxxxxxxxxxxxxxxxxxxxxxxx";

    this.span_.innerHTML = this.get('text').toString();
};
