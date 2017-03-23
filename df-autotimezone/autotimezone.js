/**
 * Created by david on 3/3/17.
 */

jQuery(document).ready(dfAutoTimeZone());

function dfAutoTimeZone() {

    // Get Array of dfAtzStrings
    var atz = jQuery(".dfAtzString").map(function() {
        return jQuery(this).text();
    }).get();

    jQuery.each(atz, function(index, value) {

        var inputDt = new Date();
        var tzOffset = - inputDt.getTimezoneOffset();

        console.log(value);

        inputDt = Date.parse(value);

        console.log("offset millis: " + tzOffset * 60000);

        var outputDt = new Date(inputDt + tzOffset * 60000);

        var seconds = outputDt.getSeconds();
        var outputString;

        var options = {hour12: true,
            timeZoneName: 'long',
            year: 'numeric',
            month: 'numeric',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric'};

        // Generate the locale specific string
        outputString = outputDt.toLocaleString(undefined, options);

        jQuery('#dfAtzString_' + index).text(outputString);

    });

}
