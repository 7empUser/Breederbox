function fetchResult() {
    let search = "%"+$(".search-form").val()+"%";
    let userId = $(".search-form").attr("data-id");
    let filters = [];
    $(("input[name=filter]")).each(function() {
        filters.push($(this).is("input[name=filter]:checked"));
    });

    $.ajax({
        url: "scripts/pets_output.php",
        type: "POST",
        data: {
            userId, userId,
            search: search,
            filters: filters
        },
        success: function(response) {
            $("div[name=petResults]").html(response);
        }
    });
}

function feedsData(action, parent) {
    let feedId = $(parent).attr("data-id");
    let brand = parent.find("input[name=brand]").val();
    let quantity = parent.find("input[name=quantity]").val();
    let price = parent.find("input[name=price]").val();

    if (action == "add") {
        if (brand == "" || quantity == "" || price == "") return ;
        let feedEmpty = $("#empty");
        feedEmpty.find("button[name=add]").remove();    
        feedEmpty.append(
            "<div class='feed-split'><button name='save'>Сохранить</button>" +
            "<button name='delete'>Удалить</button></div>"
        );
        feedEmpty.removeAttr("id");
        feedEmpty.parent().prepend(
            "<div class='block-feeds' data-id='" + (feedId + 1) + "' id='empty'>" + 
            "<input type='text' name='brand' placeholder='Название товара'>" +
            "<div class='feed-split'><input type='text' name='quantity' placeholder='Объем'>" + 
            "<input type='text' name='price' placeholder='Цена'></div>" + 
            "<button name='add'>Добавить</button>" +
            "</div>"
        );
    } else if (action == "delete") {
        let deleteDiv = $("div[data-id=" + feedId + "]");
        deleteDiv.remove();
    } else {
        if (brand == "" || quantity == "" || price == "") return ;
    }

    $.ajax({
        url: "scripts/feedData.php",
        type: "POST",
        data: {
            feedId: feedId,
            brand: brand,
            quantity: quantity,
            price, price,
            action: action
        },
        success: function(response) {
            console.log(response);
        }
    });
}

function calcCost() {
    let selectPet = [];
    $("input[name=selectPet]").each(function() {
        if ($(this).is("input[name=selectPet]:checked")) selectPet.push($(this).parent().parent().attr("data-id"));
    });
    if (selectPet.length != 0) {
        $.ajax({
            url: "scripts/calc.php",
            method: "POST",
            data: {petsId: selectPet},
            success: function(response) {
                $("div[name=calcDiv] p").html(response);
            }
        });
    } else {
        $("div[name=calcDiv] p").html("Не выбран ни один питомец");
    }
}

$(document).ready(function() {
    $(".search-form").on("input", fetchResult);
    $("input[name=filter]").on("change", fetchResult);

    $("div[name=petResults]").on("click", ".block-animals", function() {
        let petId = $(this).attr("data-id");
        window.location.href = "pet.php?pet=" + petId;
    });

    $(".block-feeds").on("click", "button[name=add], .feed-split button", function() {
        let action = $(this).attr("name");
        let parent = (action == "add") ? $(this).parent() : $(this).parent().parent();
        feedsData(action, parent);
    });

    $("div[name=petResults]").on("click", "input[name=selectPet]", function(event) {
        event.stopPropagation();
        calcCost();
    });

    $("button[name=selectAll]").on("click", function() {
        $("input[name=selectPet").each(function() {
            $(this).prop("checked", true);
        });
        calcCost();
    });

    $("button[name=clearAll]").on("click", function() {
        $("input[name=selectPet").each(function() {
            $(this).prop("checked", false);
        });
        calcCost();
    });

    $(".calcTrigger").on("click", function() {
        let calcDiv = $("div[name=calcDiv]");
        let selectInput = $(".selectPetDiv input[type=checkbox]");
        let feedDiv = $("div[name=feedResults]");
        if (calcDiv.attr("class")) {
            calcDiv.removeAttr("class");
            selectInput.removeAttr("class");
            feedDiv.attr("class", "hiddenObject");
        } else {
            calcDiv.attr("class", "hiddenObject");
            selectInput.attr("class", "hiddenObject");
            feedDiv.removeAttr("class");
        }
    });
});