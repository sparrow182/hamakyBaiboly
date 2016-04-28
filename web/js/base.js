// IIFE - Immediately Invoked Function Expression
(function (yourcode) {

    // The global jQuery object is passed as a parameter
    yourcode(window.jQuery, window, document);

}(function ($, window, document) {

    // The $ is now locally scoped 
    // Listen for the jQuery ready event on the document
    $(function () {

    });

    // The rest of the code goes here!
    function loadBookByTranslation(translationId, targetURL) {
        var dynamicData = {};
        dynamicData["tranlationId"] = translationId;
        return $.ajax({
            url: targetURL,
            type: "get",
            data: dynamicData
        });
    }

}));

