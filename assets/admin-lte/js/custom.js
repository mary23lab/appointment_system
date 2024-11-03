window.addEventListener("load", function () {
    $(".loader").addClass('hidden');
});

function showLoaderAnimation(){
    $(".loader").css('background-color', 'rgba(200, 200, 200, 0.319)');
    $(".loader").removeClass('hidden');
}