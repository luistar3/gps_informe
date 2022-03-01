



  /*----------------------------- */
  // elemOrId - jquery element or element id, defaults to $('<body>')'
// settings.color defaults to 'transparent'
// settings.opacity defaults to 1
// settings.zIndex defaults to 2147483647
// if settings.hourglasss==true change cursor to hourglass over mask


/*

maskOn(); // transparent page mask
maskOn(null, {color:'gray', opacity:0.8}); // gray page mask with opacity
maskOff(); // remove page mask
maskOn(div); // transparent div mask
maskOn(divId, {color:'gray', hourglass:true}); // gray div mask with hourglass
maskOff(div); // remove div mask

*/


function maskOn(elemOrId, settings) {
    lockScroll();
    var elem=elemFromParam(elemOrId);
    if (!elem) return;

    var maskDiv=elem.data('maskDiv');
    if (!maskDiv) {
        maskDiv=$('<div style="position:fixed;display:inline"></div>');
        $('body').append(maskDiv);
        elem.data('maskDiv', maskDiv);
    }

    if (typeof settings==='undefined' || settings===null) settings={};
    if (typeof settings.color==='undefined' || settings.color===null) settings.color='transparent';
    if (typeof settings.opacity==='undefined' || settings.opacity===null) settings.opacity=1;
    if (typeof settings.zIndex==='undefined' || settings.zIndex===null) settings.zIndex=2147483647;
    if (typeof settings.hourglass==='undefined' || settings.hourglass===null) settings.hourglass=false;

    // stretch maskdiv over elem
    var offsetParent = elem.offsetParent();
    var widthPercents=elem.outerWidth()*100/offsetParent.outerWidth()+'%';
    var heightPercents=elem.outerHeight()*100/offsetParent.outerHeight()+'%';
    var heightPercents='150%';
    maskDiv.width(widthPercents);
    maskDiv.height(heightPercents);
    maskDiv.offset($(elem).offset());

    // set styles
    maskDiv[0].style.backgroundColor = settings.color;
    maskDiv[0].style.opacity = settings.opacity;
    maskDiv[0].style.zIndex = settings.zIndex;

    if (settings.hourglass) hourglassOn(maskDiv);

    return maskDiv;
}

// elemOrId - jquery element or element id, defaults to $('<body>')'
function maskOff(elemOrId) {
    var elem=elemFromParam(elemOrId);
    if (!elem) return;

    var maskDiv=elem.data('maskDiv');
    if (!maskDiv) {
        console.log('maskOff no mask !');
        return;
    }

    elem.removeData('maskDiv');
    maskDiv.remove();
    unlockScroll();
}

// elemOrId - jquery element or element id, defaults to $('<body>')'
// if decendents is true also shows hourglass over decendents of elemOrId, defaults to true
function hourglassOn(elemOrId, decendents) {
    var elem=elemFromParam(elemOrId);
    if (!elem) return;

    if (typeof decendents==='undefined' || decendents===null) decendents=true;

    if ($('style:contains("hourGlass")').length < 1) $('<style>').text('.hourGlass { cursor: wait !important; }').appendTo('head');
    if ($('style:contains("hourGlassWithDecendents")').length < 1) $('<style>').text('.hourGlassWithDecendents, .hourGlassWithDecendents * { cursor: wait !important; }').appendTo('head');
    elem.addClass(decendents ? 'hourGlassWithDecendents' : 'hourGlass');
}

// elemOrId - jquery element or element id, defaults to $('<body>')'
function hourglassOff(elemOrId) {
    var elem=elemFromParam(elemOrId);
    if (!elem) return;

    elem.removeClass('hourGlass');
    elem.removeClass('hourGlassWithDecendents');
}

function elemFromParam(elemOrId) {
    var elem;
    if (typeof elemOrId==='undefined' || elemOrId===null) 
        elem=$('body');
    else if (typeof elemOrId === 'string' || elemOrId instanceof String) 
        elem=$('#'+elemOrId);
    else
        elem=$(elemOrId);

    if (!elem || elem.length===0) {
        console.log('elemFromParam no element !');
        return null;
    }

    return elem;
}


function lockScroll(){
    $html = $('html'); 
    $body = $('body'); 
    var initWidth = $body.outerWidth();
    var initHeight = $body.outerHeight();

    var scrollPosition = [
        self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
        self.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop
    ];
    $html.data('scroll-position', scrollPosition);
    $html.data('previous-overflow', $html.css('overflow'));
    $html.css('overflow', 'hidden');
    window.scrollTo(scrollPosition[0], scrollPosition[1]);   

    var marginR = $body.outerWidth()-initWidth;
    var marginB = $body.outerHeight()-initHeight; 
    $body.css({'margin-right': marginR,'margin-bottom': marginB});
} 

function unlockScroll(){
    $html = $('html');
    $body = $('body');
    $html.css('overflow', $html.data('previous-overflow'));
    var scrollPosition = $html.data('scroll-position');
    window.scrollTo(scrollPosition[0], scrollPosition[1]);    

    $body.css({'margin-right': 0, 'margin-bottom': 0});
}