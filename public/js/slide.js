$(document).ready(function () {


$(".btn_card").on("click", function() {

    var card = "#" + $(this).attr("id") + "_card";

    if ($(this).hasClass("active")) {
        $(card).hide();
        $(this).text($(this).attr("name") + "OFF");
    } else {
        $(card).show();
        $(this).text($(this).attr("name") + "ON");
    }

    $(this).button('toggle');

    if ($(this).attr("data-toggle") == "popover") {
        $(this).popover('toggle');
    }
});

$(".card1_radio").on("click", function() {

    var card_body = "#btn_card1_card";

    $(card_body).removeClass("text-left text-center text-right");

    switch ($(this).attr("id")) {
        case "card1_radio1": $(card_body).toggleClass("text-left"); break;
        case "card1_radio2": $(card_body).toggleClass("text-center"); break;
        case "card1_radio3": $(card_body).toggleClass("text-right"); break;
    }
});



});