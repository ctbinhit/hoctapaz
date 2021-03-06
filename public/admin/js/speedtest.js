// Specify your actual API key here:
var API_KEY = 'AIzaSyBnhwCt5ZkelRWHAURmh6zan9tsqR3NRUU';
// Specify the URL you want PageSpeed results for here:
var URL_TO_GET_RESULTS_FOR = 'http://hoctapaz.com.vn/';
var API_URL = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?';
var CHART_API_URL = 'http://chart.apis.google.com/chart?';
// Object that will hold the callbacks that process results from the
// PageSpeed Insights API.
var callbacks = {};
// Invoke the callback that fetches results. Async here so we're sure
// to discover any callbacks registered below, but this can be
// synchronous in your code.

var RESOURCE_TYPE_INFO = [
    {label: 'JavaScript', field: 'javascriptResponseBytes', color: 'e2192c'},
    {label: 'Images', field: 'imageResponseBytes', color: 'f3ed4a'},
    {label: 'CSS', field: 'cssResponseBytes', color: 'ff7008'},
    {label: 'HTML', field: 'htmlResponseBytes', color: '43c121'},
    {label: 'Flash', field: 'flashResponseBytes', color: 'f8ce44'},
    {label: 'Text', field: 'textResponseBytes', color: 'ad6bc5'},
    {label: 'Other', field: 'otherResponseBytes', color: '1051e8'},
];

// Invokes the PageSpeed Insights API. The response will contain
// JavaScript that invokes our callback with the PageSpeed results.
function runPagespeed() {
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    var query = [
        'url=' + URL_TO_GET_RESULTS_FOR,
        'callback=runPagespeedCallbacks',
        'locale=vi',
        'key=' + API_KEY,
        'strategy=desktop',
    ].join('&');
    s.src = API_URL + query;
    document.head.insertBefore(s, null);
}

// Our JSONP callback. Checks for errors, then invokes our callback handlers.
function runPagespeedCallbacks(result) {
    console.log(result);
    if (result.error) {
        var errors = result.error.errors;
        for (var i = 0, len = errors.length; i < len; ++i) {
            if (errors[i].reason == 'badRequest' && API_KEY == 'AIzaSyBnhwCt5ZkelRWHAURmh6zan9tsqR3NRUU') {
                alert('Please specify your Google API key in the API_KEY variable.');
            } else {
                // NOTE: your real production app should use a better
                // mechanism than alert() to communicate the error to the user.
                alert(errors[i].message);
            }
        }
        return;
    }

    // Dispatch to each function on the callbacks object.
    for (var fn in callbacks) {
        var f = callbacks[fn];
        if (typeof f == 'function') {
            callbacks[fn](result);
        }
    }
}

callbacks.displayPageSpeedScore = function (result) {
    var score = result.ruleGroups.SPEED.score;
    // Construct the query to send to the Google Chart Tools.
    var query = [
        'chtt=Page+Speed+score:+' + score,
        'chs=180x100',
        'cht=gom',
        'chd=t:' + score,
        'chxt=x,y',
        'chxl=0:|' + score,
    ].join('&');
    var i = document.createElement('img');
    i.src = CHART_API_URL + query;
    $('#google-speed-test').html(i);
    //document.body.insertBefore(i, null);
};

callbacks.displayTopPageSpeedSuggestions = function (result) {
    var results = [];
    var ruleResults = result.formattedResults.ruleResults;
    for (var i in ruleResults) {
        var ruleResult = ruleResults[i];
        // Don't display lower-impact suggestions.
        if (ruleResult.ruleImpact < 3.0)
            continue;
        results.push({name: ruleResult.localizedRuleName,
            impact: ruleResult.ruleImpact});
    }
    results.sort(sortByImpact);
    var ul = document.createElement('ul');
    for (var i = 0, len = results.length; i < len; ++i) {
        var r = document.createElement('li');
        r.innerHTML = results[i].name;
        ul.insertBefore(r, null);
    }
    if (ul.hasChildNodes()) {
        document.body.insertBefore(ul, null);
    } else {
        var div = document.createElement('div');
        div.innerHTML = 'No high impact suggestions. Good job!';
        document.body.insertBefore(div, null);
    }
};

// Helper function that sorts results in order of impact.
function sortByImpact(a, b) {
    return b.impact - a.impact;
}

// Display a resource size breakdown pie chart

callbacks.displayResourceSizeBreakdown = function (result) {
    var stats = result.pageStats;
    var labels = [];
    var data = [];
    var colors = [];
    var totalBytes = 0;
    var largestSingleCategory = 0;
    for (var i = 0, len = RESOURCE_TYPE_INFO.length; i < len; ++i) {
        var label = RESOURCE_TYPE_INFO[i].label;
        var field = RESOURCE_TYPE_INFO[i].field;
        var color = RESOURCE_TYPE_INFO[i].color;
        if (field in stats) {
            var val = Number(stats[field]);
            totalBytes += val;
            if (val > largestSingleCategory)
                largestSingleCategory = val;
            labels.push(label);
            data.push(val);
            colors.push(color);
        }
    }
    // Construct the query to send to the Google Chart Tools.
    var query = [
        'chs=200x140',
        'cht=p3',
        'chts=' + ['000000', 16].join(','),
        'chco=' + colors.join('|'),
        'chd=t:' + data.join(','),
        'chdl=' + labels.join('|'),
        'chdls=000000,14',
        'chp=1.6',
        'chds=0,' + largestSingleCategory,
    ].join('&');
    var i = document.createElement('img');
    
    i.src = 'http://chart.apis.google.com/chart?' + query;
    //document.body.insertBefore(i, null);
    $('#google-displayResourceSizeBreakdown').html(i);
};

$(document).ready(function () {
    //setTimeout(runPagespeed, 0);
    var key = 'AIzaSyBnhwCt5ZkelRWHAURmh6zan9tsqR3NRUU';
    var url = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=https://developers.google.com/speed/pagespeed/insights/&strategy=mobile&key=' + key;
});