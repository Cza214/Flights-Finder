$(function () {
    $(".type_radio").on('click',function(){
        var dateBackInput = $('.date_return_input');
        console.log($(".type_radio").val());
        if($("input:radio[name='type']:checked").val() !== '2'){
            dateBackInput.attr('disabled', true);
            dateBackInput.val('');
        } else {
            dateBackInput.attr('disabled', false);
        }
    })
});
