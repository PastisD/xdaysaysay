admin = {};

$(document).ready( function() { admin.init() });

admin.init = function() {
    $('select').not('.not-select2').select2();
};