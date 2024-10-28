
function updateBorders(color) {
    var hexColor = "transparent";
    if(color) {
        hexColor = color.toHexString();
    }
    jQuery("#docs-content").css("border-color", color);
    jQuery('#color_icon').val( color );
    //jQuery('.sp-preview-inner').css('background-color', color);
}


jQuery(function() {
    var get_color = jQuery('#color_icon').val();

jQuery("#color_icon").spectrum({
    allowEmpty:true,
    color: get_color,
    showInput: true,
    containerClassName: "full-spectrum",
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    showAlpha: true,
    maxPaletteSize: 10,
    preferredFormat: "hex",
    localStorageKey: "spectrum.demo",
    move: function (color) {
        updateBorders(color);
    },
    show: function () {

    },
    beforeShow: function () {

    },
    hide: function (color) {
        updateBorders(color);
    },

    palette: [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", /*"rgb(153, 153, 153)","rgb(183, 183, 183)",*/
        "rgb(204, 204, 204)", "rgb(217, 217, 217)", /*"rgb(239, 239, 239)", "rgb(243, 243, 243)",*/ "rgb(255, 255, 255)"],
        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
        /*"rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
        "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",*/
        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
    ]
});

jQuery("#hideButtons").spectrum({
    showButtons: false,
    change: updateBorders
});


var isDisabled = true;
jQuery("#toggle-disabled").click(function() {
    if (isDisabled) {
        jQuery("#disabled").spectrum("enable");
    }
    else {
        jQuery("#disabled").spectrum("disable");
    }
    isDisabled = !isDisabled;
    return false;
});

jQuery("input:disabled").spectrum({

});
jQuery("#disabled").spectrum({
    disabled: true
});

jQuery("#pick1").spectrum({
    flat: true,
    change: function(color) {
        var hsv = color.toHsv();
        var rgb = color.toRgbString();
        var hex = color.toHexString();
        //console.log("callback",color.toHslString(), color.toHsl().h, color.toHsl().s, color.toHsl().l)
        jQuery("#docs-content").css({
            'background-color': color.toRgbString()
        }).toggleClass("dark", hsv.v < .5);
        jQuery("#switch-current-rgb").text(rgb);
        jQuery("#switch-current-hex").text(hex);
    },
    show: function() {

    },
    hide: function() {

    },
    showInput: true,
    showPalette: true,
    palette: ['white', '#306', '#c5c88d', '#ac5c5c', '#344660']
});

jQuery("#collapsed").spectrum({
    color: "#dd3333",
    change: updateBorders,
    show: function() {

    },
    hide: function() {

    }
});

jQuery("#flat").spectrum({
    flat: true,
    showInput: true,
    move: updateBorders
});

jQuery("#flatClearable").spectrum({
    flat: true,
    move: updateBorders,
    change: updateBorders,
    allowEmpty:true,
    showInput: true
});

jQuery("#showInput").spectrum({
    color: "#dd33dd",
    showInput: true,
    change: updateBorders,
    show: function() {

    },
    hide: function() {

    }
});

jQuery("#showAlpha").spectrum({
    color: "rgba(255, 128, 0, .5)",
    showAlpha: true,
    change: updateBorders
});

jQuery("#showAlphaWithInput").spectrum({
    color: "rgba(255, 128, 0, .5)",
    showAlpha: true,
    showInput: true,
    showPalette: true,
    palette: [
        ["rgba(255, 128, 0, .9)", "rgba(255, 128, 0, .5)"],
        ["red", "green", "blue"],
        ["hsla(25, 50, 75, .5)", "rgba(100, .5, .5, .8)"]
    ],
    change: updateBorders
});

jQuery("#showAlphaWithInputAndEmpty").spectrum({
    color: "rgba(255, 128, 0, .5)",
    allowEmpty:true,
    showAlpha: true,
    showInput: true,
    showPalette: true,
    palette: [
        ["rgba(255, 128, 0, .9)", "rgba(255, 128, 0, .5)"],
        ["red", "green", "blue"],
        ["hsla(25, 50, 75, .5)", "rgba(100, .5, .5, .8)"]
    ],
    change: updateBorders
});

jQuery("#showInputWithClear").spectrum({
    allowEmpty:true,
    color: "",
    showInput: true,
    change: updateBorders,
    show: function() {

    },
    hide: function() {

    }
});

jQuery("#openWithLink").spectrum({
    color: "#dd3333",
    change: updateBorders,
    show: function() {

    },
    hide: function() {

    }
});

jQuery("#className").spectrum({
    className: 'awesome'
});

jQuery("#replacerClassName").spectrum({
    replacerClassName: 'awesome'
});

jQuery("#containerClassName").spectrum({
    containerClassName: 'awesome'
});

jQuery("#showPalette").spectrum({
    showPalette: true,
    palette: [
        ['black', 'white', 'blanchedalmond'],
        ['rgb(255, 128, 0);', 'hsv 100 70 50', 'lightyellow']
    ],
    hide: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Hidden: " + c.toHexString());
    },
    change: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Change called: " + c.toHexString());
    },
    move: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Move called: " + c.toHexString());
    }
});

var textPalette = ["rgb(255, 255, 255)", "rgb(204, 204, 204)", "rgb(192, 192, 192)", "rgb(153, 153, 153)", "rgb(102, 102, 102)", "rgb(51, 51, 51)", "rgb(0, 0, 0)", "rgb(255, 204, 204)", "rgb(255, 102, 102)", "rgb(255, 0, 0)", "rgb(204, 0, 0)", "rgb(153, 0, 0)", "rgb(102, 0, 0)", "rgb(51, 0, 0)", "rgb(255, 204, 153)", "rgb(255, 153, 102)", "rgb(255, 153, 0)", "rgb(255, 102, 0)", "rgb(204, 102, 0)", "rgb(153, 51, 0)", "rgb(102, 51, 0)", "rgb(255, 255, 153)", "rgb(255, 255, 102)", "rgb(255, 204, 102)", "rgb(255, 204, 51)", "rgb(204, 153, 51)", "rgb(153, 102, 51)", "rgb(102, 51, 51)", "rgb(255, 255, 204)", "rgb(255, 255, 51)", "rgb(255, 255, 0)", "rgb(255, 204, 0)", "rgb(153, 153, 0)", "rgb(102, 102, 0)", "rgb(51, 51, 0)", "rgb(153, 255, 153)", "rgb(102, 255, 153)", "rgb(51, 255, 51)", "rgb(51, 204, 0)", "rgb(0, 153, 0)", "rgb(0, 102, 0)", "rgb(0, 51, 0)", "rgb(153, 255, 255)", "rgb(51, 255, 255)", "rgb(102, 204, 204)", "rgb(0, 204, 204)", "rgb(51, 153, 153)", "rgb(51, 102, 102)", "rgb(0, 51, 51)", "rgb(204, 255, 255)", "rgb(102, 255, 255)", "rgb(51, 204, 255)", "rgb(51, 102, 255)", "rgb(51, 51, 255)", "rgb(0, 0, 153)", "rgb(0, 0, 102)", "rgb(204, 204, 255)", "rgb(153, 153, 255)", "rgb(102, 102, 204)", "rgb(102, 51, 255)", "rgb(102, 0, 204)", "rgb(51, 51, 153)", "rgb(51, 0, 153)", "rgb(255, 204, 255)", "rgb(255, 153, 255)", "rgb(204, 102, 204)", "rgb(204, 51, 204)", "rgb(153, 51, 153)", "rgb(102, 51, 102)", "rgb(51, 0, 51)"];

jQuery("#showPaletteOnly").spectrum({
    color: 'blanchedalmond',
    showPaletteOnly: true,
    showPalette:true,
    palette: [
        ['black', 'white', 'blanchedalmond',
        'rgb(255, 128, 0);', 'hsv 100 70 50'],
        ['red', 'yellow', 'green', 'blue', 'violet']
    ],
    change: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Change called: " + c.toHexString());
    },
    move: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Move called: " + c.toHexString());
    }
});

jQuery("#hideAfterPaletteSelect").spectrum({
    showPaletteOnly: true,
    showPalette:true,
    hideAfterPaletteSelect:true,
    color: 'blanchedalmond',
    palette: [
        ['black', 'white', 'blanchedalmond',
        'rgb(255, 128, 0);', 'hsv 100 70 50'],
        ['red', 'yellow', 'green', 'blue', 'violet']
    ],
    change: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Change called: " + c.toHexString());
    },
    move: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Move called: " + c.toHexString());
    }
});

jQuery("#togglePaletteOnly").spectrum({
    color: 'blanchedalmond',
    showPaletteOnly: true,
    togglePaletteOnly: true,
    showPalette:true,
    palette: [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
        ["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ]
});

jQuery("#clickoutFiresChange").spectrum({
    change: updateBorders
});

jQuery("#clickoutDoesntFireChange").spectrum({
    change: updateBorders,
    clickoutFiresChange: false
});

jQuery("#showInitial").spectrum({
    showInitial: true
});

jQuery("#showInputAndInitial").spectrum({
    showInitial: true,
    showInput: true
});

jQuery("#showInputInitialClear").spectrum({
    allowEmpty:true,
    showInitial: true,
    showInput: true
});

jQuery("#changeOnMove").spectrum({
    move: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Move called: " + c.toHexString());
    }
});
jQuery("#changeOnMoveNo").spectrum({
    showInput: true,
    change: function(c) {
        var label = jQuery("[data-label-for=" + this.id + "]");
        label.text("Change called: " + c.toHexString());
    }
});

function prettyTime() {
    var date = new Date();

    return date.toLocaleTimeString();
}

jQuery("#eventshow").spectrum({
    show: function(c) {
        var label = jQuery("#eventshowLabel");
        label.text("show called at " + prettyTime() + " (color is " + c.toHexString() + ")");
    }
});

jQuery("#eventhide").spectrum({
    hide: function(c) {
        var label = jQuery("#eventhideLabel");
        label.text("hide called at " + prettyTime() + " (color is " + c.toHexString() + ")");
    }
});

jQuery("#eventdragstart").spectrum({
    showAlpha: true
}).on("dragstart.spectrum", function(e, c) {
    var label = jQuery("#eventdragstartLabel");
    label.text("dragstart called at " + prettyTime() + " (color is " + c.toHexString() + ")");
});

jQuery("#eventdragstop").spectrum({
    showAlpha: true
}).on("dragstop.spectrum", function(e, c) {
    var label = jQuery("#eventdragstopLabel");
    label.text("dragstop called at " + prettyTime() + " (color is " + c.toHexString() + ")");
});


jQuery(".basic").spectrum({ change: updateBorders });
jQuery(".override").spectrum({
    color: "yellow",
    change: updateBorders
});

jQuery(".startEmpty").spectrum({
    allowEmpty:true,
    change: updateBorders});

jQuery("#beforeShow").spectrum({
    beforeShow: function() {
        return false;
    }
});


jQuery("#custom").spectrum({
    color: "#f00"
});

jQuery("#buttonText").spectrum({
    allowEmpty:true,
    chooseText: "Alright",
    cancelText: "No way"
});


jQuery("#showSelectionPalette").spectrum({
    showPalette: true,
    showSelectionPalette: true, // true by default
    palette: [ ]
});
jQuery("#showSelectionPaletteStorage").spectrum({
    showPalette: true,
    localStorageKey: "spectrum.homepage", // Any picker with the same string will share selection
    showSelectionPalette: true,
    palette: [ ]
});
jQuery("#showSelectionPaletteStorage2").spectrum({
    showPalette: true,
    localStorageKey: "spectrum.homepage", // Any picker with the same string will share selection
    showSelectionPalette: true,
    palette: [ ]
});

jQuery("#selectionPalette").spectrum({
    showPalette: true,
    palette: [ ],
    showSelectionPalette: true, // true by default
    selectionPalette: ["red", "green", "blue"]
});

jQuery("#maxSelectionSize").spectrum({
    showPalette: true,
    palette: [ ],
    showSelectionPalette: true, // true by default
    selectionPalette: ["red", "green", "blue"],
    maxSelectionSize: 2
});

jQuery("#preferredHex").spectrum({
    preferredFormat: "hex",
    showInput: true,
    showPalette: true,
    palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
});
jQuery("#preferredHex3").spectrum({
    preferredFormat: "hex3",
    showInput: true,
    showPalette: true,
    palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
});
jQuery("#preferredHsl").spectrum({
    preferredFormat: "hsl",
    showInput: true,
    showPalette: true,
    palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
});
jQuery("#preferredRgb").spectrum({
    preferredFormat: "rgb",
    showInput: true,
    showPalette: true,
    palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
});
jQuery("#preferredName").spectrum({
    preferredFormat: "name",
    showInput: true,
    showPalette: true,
    palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
});
jQuery("#preferredNone").spectrum({
    showInput: true,
    showPalette: true,
    palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
});

jQuery("#triggerSet").spectrum({
    change: updateBorders
});

// Show the original input to demonstrate the value changing when calling `set`
jQuery("#triggerSet").show();

jQuery("#btnEnterAColor").click(function() {
    jQuery("#triggerSet").spectrum("set", jQuery("#enterAColor").val());
});

jQuery("#toggle").spectrum();
jQuery("#btn-toggle").click(function() {
    jQuery("#toggle").spectrum("toggle");
    return false;
});


jQuery('#toc').toc({
    'selectors': 'h2,h3', //elements to use as headings
    'container': '#docs', //element to find all selectors in
    'smoothScrolling': true, //enable or disable smooth scrolling on click
    'prefix': 'toc', //prefix for anchor tags and class names
    'highlightOnScroll': true, //add class to heading that is currently in focus
    'highlightOffset': 100, //offset to trigger the next headline
    'anchorName': function(i, heading, prefix) { //custom function for anchor name
        return heading.id || prefix+i;
    }
});

//prettyPrint();


});
