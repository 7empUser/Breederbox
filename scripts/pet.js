let file;
let formData;



function save() {
    let userId = $("input[name=userId").val();
    let petId = $("input[name=petId]").val();
    let name = $("input[name=name]").val();
    let type = $("input[name=type]").val();
    let age = $("input[name=age]").val();
    let gender = $("input[name=gender]").val();
    let breed = $("input[name=breed]").val();

    let vetInfo = $("input[name=vetDate");
    let vetId = [];
    let vetDate = [];
    $.each(vetInfo, (id, elem) => {
        vetId.push(elem.getAttribute("data-id"));
        vetDate.push(elem.value);
    });
    if (/\d{2}[.-]\d{2}[.-]\d{4}/.test(vetDate[0])) {
        let vetMaxId = vetId[0];
        let vetEmpty = $("#vetEmpty");
        vetEmpty.removeAttr("id");
        vetEmpty.parent().prepend("<input type='text' id='vetEmpty' name='vetDate' placeholder='ДД.ММ.ГГГГ' data-id='"+(vetMaxId + 1)+"'>");
    }

    let vacInfo = $("input[name=vaccinationName]");
    let vacId = [];
    let vacName = [];
    $.each(vacInfo, (id, elem) => {
        vacId.push(elem.getAttribute("data-id"));
        vacName.push(elem.value);
    });
    if (vacName[0] != "") {
        let vacMaxId = vacId[0];
        let vacEmpty = $("#vacEmpty");
        vacEmpty.removeAttr("id");
        vacEmpty.parent().prepend("<input type='text' id='vacEmpty' name='vacName' placeholder='Название прививки' data-id='"+(vacMaxId + 1)+"'>");    
    }

    let feedId = $("select[name=feedId]").val();
    let count = $("input[name=count]").val();
    let dosage = $("input[name=dosage]").val();

    let weightInfo = $("input[name=weight]");
    let weightDateInfo = $("input[name=weightDate]");
    let weightId = [];
    let weightDate = [];
    let weightValue = [];
    for (let i = 0; i < weightInfo.length; i++) {
        weightId.push(weightInfo[i].getAttribute("data-id"));
        weightValue.push(weightInfo[i].value);
        weightDate.push(weightDateInfo[i].value);
    }
    
    let notes = $("textarea[name=notes]").val();

    let formData = new FormData();
    formData.append("userId", userId);
    formData.append("petId", petId);
    formData.append("name", name);
    formData.append("type", type);
    formData.append("age", age);
    formData.append("gender", gender);
    formData.append("breed", breed);
    formData.append("vetId", vetId);
    formData.append("vetDate", vetDate);
    formData.append("vacId", vacId);
    formData.append("vacName", vacName);
    formData.append("feedId", feedId);
    formData.append("count", count);
    formData.append("dosage", dosage);
    formData.append("weightId", weightId);
    formData.append("weightDate", weightDate);
    formData.append("weightValue", weightValue);
    formData.append("notes", notes);
    formData.append("upload", file);

    $.ajax({
        url: "scripts/animalData.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
        }
    });
}



$(document).ready(function() {
    $(".save").on("click", save);

    $("input[type=file]").on("change", function(event) {
        file = event.target.files[0];
        if (file) {
            document.querySelector(".addImg").src = URL.createObjectURL(file);
        }
    });

    $(".addImg").on("click", function() {
        $("input[type=file]").trigger("click");
    });

    document.querySelectorAll('.row').forEach(row => {
        row.addEventListener('click', event => {

            if (event.target.closest('.panel-form input, textarea, select')) {
                return ;
            }

            const rowIndex = row.getAttribute('data-row');
            const items = document.querySelectorAll('.row[data-row="' + rowIndex + '"] .info-container');

            let isExpanded = items[0].offsetHeight === 320;

            document.querySelectorAll('.info-container').forEach(item => {
                item.style.height = '150px';
            });
            document.querySelectorAll('.panel-form').forEach(item => {
                item.style.display = "none";
            });

            items.forEach(item => {
                if (isExpanded) {
                    item.style.height = '150px';
                    item.querySelector('.panel-form').style.display = 'none';
                } else {
                    item.style.height = '320px';
                    item.querySelector('.panel-form').style.display = 'block';
                }
            });
        });
    });
});