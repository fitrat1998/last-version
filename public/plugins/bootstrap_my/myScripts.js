/*
* My functions for admin panel
*/
$(function () {
    $("#dataTable").DataTable();
});

function preloader() {
    $(".loader-in").fadeOut();
    $(".loader").delay(150).fadeOut("fast");
    $(".wrapper").fadeIn("fast");
    $("#app").fadeIn("fast");
}

//Initialize Select2 Elements
$('.select2').select2({
    theme: 'bootstrap4'
});

//Initialize Select2 Elements
$('.select2bs4').select2({
    theme: 'bootstrap4'
});

//select all
$("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);

});

$('.duallistbox').bootstrapDualListbox({
    nonSelectedListLabel: 'Не разрешено',
    selectedListLabel: 'Разрешено',
});

$(document).on('click', '.toggle-password', function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});


function alertMessage(message = '', type = 'default') {

    let messageDiv =
        '<div class="alert alert-default-' + type + ' alert-dismissible fade show" role="alert">\n' +
        message + '\n' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '    <span aria-hidden="true">&times;</span>\n' +
        '  </button>\n' +
        '</div>';

    return messageDiv;
}

$('form').submit(function () {
    let button = $(this).find("button[type=submit]:focus");
    button.prop('disabled', true);
    button.html('<i class="spinner-border spinner-border-sm text-light"></i> ' + $(button).text() + '...');
});

$('.submitButton').click(function () {

    if (confirm('Confirm action')) {
        $(this).prop('disabled', true);
        $(this).html('<i class="spinner-border spinner-border-sm text-light"></i> ' + $($(this)).text() + '...');
        $(this).parents('form:first').submit();
    }

});

function SpinnerGo(obj) {
    $(obj).prop('disabled', true);
    $(obj).html('<i class="spinner-border spinner-border-sm text-light"></i> ' + $($(obj)).text());
}

function SpinnerStop(obj) {
    $(obj).prop('disabled', false);
    $(obj).html($($(obj)).text());
}

function afterSubmit(obj) {
    $(obj).prop('disabled', true);
    $(obj).html('<i class="spinner-border spinner-border-sm text-light"></i> ' + $($(obj)).text());
    obj.form.submit();
}

function toggle_avtospisaniya(client_id, token, obj) {

    $.ajax({
        url: '/clients/auto-toggle',
        type: "post", //send it through post method
        data: {
            _token: token,
            client_id: client_id
        },
        beforeSend: function () {
            // $(obj).removeAttr('class');
            $(obj).attr('class', 'spinner-border spinner-border-sm text-secondary');
        },
        success: function (result) {

            if (result.auto === true) {
                $(obj).attr('class', 'fas fa-check-circle text-success');
            } else if (result.auto === false) {
                $(obj).attr('class', 'fas fa-times-circle text-danger');
            } else {
                $(obj).attr('class', 'fas fa-question-circle text-warning');
            }
        },
        error: function (err) {
            $(obj).attr('class', 'fas fa-question-circle text-warning');
        }
    })
}


$(document).ready(function () {
    $('#programm').change(function () {
        var id = $('#programm').val();
        var url = '{{ route("attachstudents.show") }}';
        // console.log(url)

        $.ajax({
            type: 'GET',
            url: url,  // Routing nomini ishlatamiz
            data: {id: id}, // Ma'lumotni so'rovga qo'shamiz
            success: function (response) {
                console.log(response);
                var table = $('#dataTable').DataTable();
                // DataTable jadvallarini tozalash
                table.clear().draw();

                // Har bir JSON qatorini DataTable jadvallariga qo'shish
                for (var i = 0; i < response.length; i++) {
                    table.row.add([
                        '<input type="checkbox"  name="students_id[]" id="checkboxSuccess3" value="' + response[i].id + '">',
                        response[i].id,
                        response[i].fullname,
                        response[i].programm_id
                        // ... qo'shimcha ustunlar
                    ]);
                }

                table.draw();

            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $(document).ready(function () {
        $('#faculty').change(function () {
            var fid = $('#faculty').val();
            var furl = '{{ route("attachteachers.show") }}';

            // alert(fid)

            $.ajax({
                type: 'GET',
                url: '/attachteachers/show',
                data: {id: fid},
                success: function (response) {
                    console.log(response);

                    var table = $('#teachersTable').DataTable();
                    // DataTable jadvallarini tozalash
                    table.clear().draw();


                    for (var i = 0; i < response.length; i++) {
                        var row = [
                            '<input type="checkbox" name="teachers_id[]" id="checkboxSuccess' + response[i].id + '" value="' + response[i].id + '">',
                            response[i].id,
                            response[i].fullname,
                            response[i].faculties_id
                        ];

                        table.row.add(row).draw();
                    }

                },
                error: function (error) {
                    console.log(error);
                }
            });
        });


//end of attach teacher ajax fetch


//end of attach student ajax fetch

        $('#subject_id').change(function () {

            var subject_id = $('#subject_id').val();
            let topic = '';

            var newURL = window.location.pathname;

            var splitURL = newURL.split("/");


            if (splitURL[1].toString() == 'middleexams') {
                topic = '{{ route("middleexams.show") }}';
                console.log(1);
            }
            else if (splitURL[1].toString() == 'selfstudyexams') {
                topic = '{{ route("selfstudyexams.show") }}';
                console.log(1);
            }
            else if (splitURL[1].toString() == 'retriesexams') {
                topic = '{{ route("retriesexams.show") }}';
                console.log(1);
            }
            else if (splitURL[1].toString() == 'finalexams') {
                topic = '{{ route("finalexams.show") }}';
                // console.log(topic);
            }
             else if (splitURL[1].toString() == 'currentexams') {
                topic = '{{ route("currentexams.show") }}';
                // console.log(topic);
            }
            else if (splitURL[1].toString() == 'exercises') {
                topic = '{{ route("exercises.show") }}';
                console.log(1)
            }

            $.ajax({
                url: topic,
                type: 'GET',
                data: {id: subject_id},
                success: function (response) {
                    console.log(response)

                    // Select2 uchun optionlarni tuzing
                    var options = response.map(function (item) {
                        return '<option value="' + item.id + '">' + item.topic_name + '</option>';
                    });

                    // Select2 elementini tanlang
                    var select2Element = $('#exam_topics');

                    // Select2 optionsni yangilang
                    select2Element.empty().append(options);

                    // Select2 ni qayta ishlating
                    select2Element.select2();

                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $('#exercises_group_id').change(function () {

            var exercises_group_id = $('#exercises_group_id').val();
            let exercise_groups = '';

            var newURL = window.location.pathname;

            var splitURL = newURL.split("/");

            // alert(splitURL[1])

            if (splitURL[1].toString() == 'exercises') {
                exercise_groups = '{{ route("exercises.show") }}';
                // console.log(1)
            }

            $.ajax({
                url: exercise_groups,
                type: 'GET',
                data: {id: exercises_group_id},
                success: function (response) {
                    // if(response){
                    //     console.log(12312)
                    // }

                    // Select2 uchun optionlarni tuzing
                    var options = response.map(function (item) {
                        return '<option value="' + item.id + '">' + item.subject_name + '</option>';
                    });

                    // Select2 elementini tanlang
                    var select3Element = $('#exercises_subject_id');

                    select3Element.empty().append(options);


                    // Select2 optionsni yangilang
                    select3Element.append('<option value="" disabled selected>Fanni  tanlang</option>');

                    // Select2 ni qayta ishlating
                    select3Element.select2();

                },
                error: function (error) {
                    console.log(error);
                }
            });

        });

//end subjects exercises fetch

        $('#exercises_subject_id').change(function () {

            var selectedOption = $(this).val();
            var selectedOptionId = $('#exercises_subject_id option:selected').attr('value');

            let exercise_topics = '../topics/' + selectedOptionId;


            var newURL = window.location.pathname;

            var splitURL = newURL.split("/");

            // alert(exercises_subjects_id)

            console.log('exercise_topics:', exercise_topics);

            console.log('exercises_subject_id:', selectedOptionId);


            $.ajax({
                url: exercise_topics,
                type: 'GET',
                success: function (response) {
                    // if(response){
                    //     console.log(response)
                    // }

                    // Select2 elementini tanlang
                    var select4Element = $('#topics_id');

                    // Select2 uchun optionlarni tuzing
                    var options = response.map(function (item) {
                        return '<option value="' + item.id + '">' + item.topic_name + '</option>';
                    });


                    select4Element.empty().append(options);


                    // Select2 optionsni yangilang
                    select4Element.append('<option value="" disabled selected>Mavzuni tanlang</option>');

                    // Select2 ni qayta ishlating
                    select4Element.select2();

                },
                error: function (error) {
                    console.log(error);
                }
            });


        });

//end of exercises subject

        $('#attendance_faculty').change(function () {

            var faculties_id = $('#attendance_faculty').val();
            var hiddenInputValue = $('#url_faculty').val();

            // console.log(hiddenInputValue);

            $.ajax({
                url: hiddenInputValue,
                type: 'GET',
                data: {id: faculties_id},
                success: function (response) {
                    // console.log(response)

                    var select = $('#attendance_groups_id'); // Replace 'yourSelectId' with your actual select element ID

                    // Clear existing options in the select
                    select.empty();

                    select.append('<option value="" disabled selected>Guruhni tanlang</option>');

                    // Iterate through the response data and append options to the select
                    $.each(response, function (index, item) {
                        select.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });

                    // Log the response to the console (optional)
                    // console.log(response);

                },
                error: function (error) {
                    console.log(error);
                }
            });


        });

        //end groups fetch

        $('#attendance_groups_id').change(function () {

            var groups_id = $('#attendance_groups_id').val();
            var groups_url = $('#url_groups').val();

            // console.log(groups_url);

            $.ajax({
                url: groups_url,
                type: 'GET',
                data: {id: groups_id},
                success: function (response) {
                    // console.log(response)

                    var select2 = $('#attendance_subjects_id'); // Replace 'yourSelectId' with your actual select element ID

                    // Clear existing options in the select
                    select2.empty();

                    select2.append('<option value="" disabled selected>Fanni tanlang</option>');

                    // Iterate through the response data and append options to the select
                    $.each(response, function (index, item) {
                        select2.append('<option value="' + item.id + '">' + item.subject_name + '</option>');
                    });

                    // Log the response to the console (optional)
                    // console.log(response);

                },
                error: function (error) {
                    console.log(error);
                }
            });


        });

        //end subjects fetch

        $('#attendance_subjects_id').change(function () {

            var subjects_id = $('#attendance_subjects_id').val();
            var subjects_url = $('#url_subjects').val();
            var url_attendance_check = $('#url_attendance_check').val();

            // let  urls = route(attendance_checks.show);


            console.log(url_attendance_check);

            $.ajax({
                url: subjects_url,
                type: 'GET',
                data: {id: subjects_id},
                success: function (response) {
                    console.log(response)


                    var table = $('#dataTable').DataTable();

                    table.clear().draw();


                    for (var i = 0; i < response.length; i++) {
                        var url = './attendance_checks/' + response[i].id;
                        console.log(url);
                        table.row.add([
                            response[i].id,
                            response[i].title,
                            response[i].name,
                            response[i].fullname,
                            '<a class="btn btn-info" href="./attendancechecks/' + response[i].id + '">Yo`qlama qilish</a>'
                            //
                            // '<a type="checkbox" class="btn btn-info" id="checkboxSuccess3" href="' + url_attendance_check +'/'+ '">Yo`qlama qilish</a>'

                        ]);
                    }

                    // DataTable jadvallarini yangilash
                    table.draw();

                },
                error: function (error) {
                    console.log(error);
                }
            });


        });

    });




// attendance resluts show with ajax

    $('#attendance_faculty_result').on('change', function () {
        var faculties_id = $(this).val();
        var hiddenInputValue = $('#url_faculty_result').val();

        // alert(faculties_id);

        $.ajax({
            url: hiddenInputValue,
            type: 'GET',
            data: {id: faculties_id},
            success: function (response) {
                console.log(response)
                var select = $('#attendance_groups_id_result');


                select.empty();

                select.append('<option value="" disabled selected>Guruhni tanlang</option>');


                $.each(response, function (index, item) {
                    select.append('<option value="' + item.id + '">' + item.name + '</option>');
                });


                // console.log(response);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


        //end groups fetch

        $('#attendance_groups_id_result').change(function () {

            var groups_id = $('#attendance_groups_id_result').val();
            var groups_url = $('#url_groups_result').val();

            // alert(groups_url);

            $.ajax({
                url: groups_url,
                type: 'GET',
                data: {id: groups_id},
                success: function (response) {
                    console.log(response)

                    var select2 = $('#attendance_subjects_id_result');


                    select2.empty();

                    select2.append('<option value="" disabled selected>Fanni tanlang</option>');


                    $.each(response, function (index, item) {
                        select2.append('<option value="' + item.id + '">' + item.subject_name + '</option>');
                    });


                    // console.log(response);

                },
                error: function (error) {
                    console.log(error);
                }
            });


        });

         $('#attendance_subjects_id_result').change(function () {

            var subjects_id = $('#attendance_subjects_id_result').val();
            var subjects_url = $('#url_subjects_result').val();


            // let  urls = route(attendance_checks.show);


            // alert(subjects_url);

            $.ajax({
                url: subjects_url,
                type: 'GET',
                data: {id: subjects_id},
                success: function (response) {

                    console.log(response)


                    var table = $('#dataTable').DataTable();

                    table.clear().draw();
                    let absent;

                    for (var i = 0; i < response.length; i++) {
                            if(response[i].absent){
                                absent = "Qatnashmagan";
                            }
                            else {
                                absent = "Qatnashgan";
                            }
                        table.row.add([
                            response[i].attendance_check_id,
                            response[i].exercise_title,
                            response[i].name,
                            response[i].student_name,
                            absent,
                            response[i].absent_date,
                        ]);
                    }


                    table.draw();

                },
                error: function (error) {
                    console.log(error);
                }
            });


        });

//result exams

      $('#result_programm').on('change', function () {
        var pr_id = $(this).val();
        var pr_url = $('#url_result_programm').val();

        // alert(pr_id);

        $.ajax({
            url: pr_url,
            type: 'GET',
            data: {id: pr_id},
            success: function (response) {
                console.log(response)
                var select = $('#group_result');


                select.empty();

                select.append('<option value="" disabled selected>Guruhni tanlang</option>');


                $.each(response, function (index, item) {
                    select.append('<option value="' + item.id + '">' + item.name + '</option>');
                });



            },
            error: function (error) {
                console.log(error);
            }
        });
    });


        //end groups fetch

        $('#group_result').change(function () {

            var groups_id = $(this).val();
            var groups_url = $('#url_group_result').val();

            // alert(groups_url);

            $.ajax({
                url: groups_url,
                type: 'GET',
                data: {id: groups_id},
                success: function (response) {
                    console.log(response)

                    var select2 = $('#subject_result');


                    select2.empty();

                    select2.append('<option value="" disabled selected>Fanni tanlang</option>');


                    $.each(response, function (index, item) {
                        select2.append('<option value="' + item.id + '">' + item.subject_name + '</option>');
                    });


                    // console.log(response);

                },
                error: function (error) {
                    console.log(error);
                }
            });


        });

         $('#subject_result').change(function () {

            var subjects_id = $(this).val();
            var subjects_url = $('#url_subject_result').val();


            // let  urls = route(attendance_checks.show);


            alert(subjects_url);

            $.ajax({
                url: subjects_url,
                type: 'GET',
                data: {id: subjects_id},
                success: function (response) {

                    console.log(response)


                    var table = $('#dataTable').DataTable();

                    table.clear().draw();
                    let absent;

                    for (var i = 0; i < response.length; i++) {
                            if(response[i].absent){
                                absent = "Qatnashmagan";
                            }
                            else {
                                absent = "Qatnashgan";
                            }
                        table.row.add([
                            response[i].attendance_check_id,
                            response[i].exercise_title,
                            response[i].name,
                            response[i].student_name,
                            absent,
                            response[i].absent_date,
                        ]);
                    }


                    table.draw();

                },
                error: function (error) {
                    console.log(error);
                }
            });


        });


});

