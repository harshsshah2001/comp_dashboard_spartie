$(document).ready(function() {
    
    "use strict";
    
    $('.select2').select2();
    
    $(".js-example-basic-multiple-limit").select2({
        maximumSelectionLength: 2
    });
    
    $(".js-example-tokenizer").select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });
});