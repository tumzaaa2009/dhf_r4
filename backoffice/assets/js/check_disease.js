function check_disease() {
    $('#diseaseModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false,
    });
    $.ajax({
        type: "POST",
        url: "ajax/checkDisease/check_disease.php",
        dataType: "Json",
        success: function(data) {
            if (data.reCkeck == "1") {
                $('#diseaseModal').modal('show');
                $('#diseaseShowModal').load("ajax/checkDisease/form_pick_disease.php", function() {

                });
            }
        }
    });
}

function retweet_disease() {
    $('#diseaseModal').modal('show');
    $('#diseaseShowModal').load("ajax/checkDisease/form_pick_disease.php", function() {

    });
}

function pick_disease(group_id, group_name,group_id_506) {
    $.ajax({
        type: "POST",
        url: "ajax/checkDisease/pick_disease.php",
        data: {
            group_id: group_id,
            group_name: group_name,
            group_id_506: group_id_506
        },
        dataType: "Json",
        success: function(data) {
            if (data.result == "1") {
                $('#diseaseModal').modal('hide');
                $("#name_disease_1").html(group_name);
                $("#name_disease_2").html(group_name);
                location.reload();
            } else {
                window.location.href = 'logout.php';
            }
        }
    });
}