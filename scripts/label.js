// Define the overlay, derived from google.maps.OverlayView
// From http://blog.mridey.com/2009/09/label-overlay-example-for-google-maps.html
function Label(opt_options, infowindow) {
    // Initialization
    this.setValues(opt_options);
    this.infowindow=infowindow;
    // Label specific
    var span = this.span_ = document.createElement('span');
    span.style.cssText = 'position: relative; left: -50%; top: -8px; cursor:pointer;' +
                          'white-space: nowrap; border: 1px solid blue; ' +
                          'padding: 1px; background-color: #FFFF88;' +
                          'font-family:Verdana,Arial,Helvetica,sans-serif; font-size: 8pt';
    var div = this.div_ = document.createElement('div');
    div.appendChild(span);
    div.style.cssText = 'position: absolute; display: none';
}

Label.prototype = new google.maps.OverlayView;

Label.prototype.onAdd = function() {
    var pane = this.getPanes().overlayLayer;
    pane.appendChild(this.div_);

    // Ensures the label is redrawn if the text or position is changed.
    var me = this;
    this.listeners_ = [
        google.maps.event.addListener(this, 'position_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'text_changed', function() { me.draw(); }),
//        google.maps.event.addDomListener(this.div_, 'click', function() { alert(this.innerHTML); })
    google.maps.event.addDomListener(this.div_, 'mouseover', function() {
        this.infowindow.setPosition(map.get('position'));
        alert('fff');
//        infowindow.setContent(this.text);
//        infowindow.setPosition(this.position);
//        infowindow.open(map); 
    })
 ];
};

Label.prototype.onRemove = function() {
    this.div_.parentNode.removeChild(this.div_);
    // Label is removed from the map, stop updating its position/text.
    for (var i = 0, I = this.listeners_.length; i < I; ++i) {
      google.maps.event.removeListener(this.listeners_[i]);
    }
};

Label.prototype.draw = function() {
 var projection = this.getProjection();
 var position = projection.fromLatLngToDivPixel(this.get('position'));

 var div = this.div_;
 div.style.left = position.x + 'px';
 div.style.top = position.y + 'px';
 div.style.display = 'block';

 this.span_.innerHTML = this.get('text').toString();
};
