import Vue from 'vue';

// convert to Malaysia Currency

Vue.filter('toMyCurrency', function (value) {

    if (typeof value !== "number") {
        value = parseFloat(value);
        // return value;
    }
    var formatter = new Intl.NumberFormat('ms-Latn-MY', {
        style: 'currency',
        currency: 'MYR',
        minimumFractionDigits: 2
    });

    return formatter.format(value);
});