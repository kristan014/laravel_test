@extends('layouts.app')

@section('title')
    Students
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">


        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row my-5">
                <div class="col-md-6">
                    <h3>Student List</h3>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" onclick="return formReset('show')">Add a new
                        student</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="data-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Contact</th>
                                    <th>Region</th>
                                    <th>Course</th>
                                    <th>Section</th>
                                    <th>Status</th>

                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    <div class="modal fade" id="div_form">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="form_id" name="form_id">
                    @csrf
                    <div class="modal-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <i class="text-secondary fas fa-plus mr-1"></i>
                            </div>
                            <div class="modal-title">Add new student</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="hidden_id" id="hidden_id">

                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control form-control-user" id="full_name" name="full_name"
                                placeholder="Full Name">
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact</label>
                            <input type="number" class="form-control form-control-user" id="contact" name="contact"
                                placeholder="Contact">

                        </div>
                        <div class="form-group">
                            <label for="region">Region</label>
                            <input type="text" class="form-control form-control-user" id="region" name="region"
                                placeholder="Region">
                        </div>

                        <div class="form-group">
                            <label for="course_id">Course</label>
                            <select id="course_id" class="form-control" name="course_id">

                            </select>

                        </div>

                        <div class="form-group">
                            <label for="section">Section</label>
                            <input type="text" class="form-control form-control-user" id="section" name="section"
                                placeholder="Section">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary submit">Submit <i
                                class="fas fa-sign-out-alt ml-1"></i></button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <script>
        $(function() {
            loadTable();

            $("#form_id")
                .on("submit", function(e) {
                    e.preventDefault();
                    // trimInputFields();
                })
                .validate({
                    rules: {
                        full_name: {
                            required: true,
                        },
                        contact: {
                            required: true,
                        },
                        region: {
                            required: true,
                        },
                        course_id: {
                            required: true,
                        },
                        section: {
                            required: true,
                        },

                    },
                    messages: {
                        full_name: {
                            required: "Please provide full name",
                        },

                        contact: {
                            required: "Please provide contact",
                        },
                        region: {
                            required: "Please provide region",
                        },

                        course_id: {
                            required: "Please select course",
                        },
                        section: {
                            required: "Please provide section",
                        },

                    },
                    errorElement: "span",
                    errorPlacement: function(error, element) {
                        error.addClass("invalid-feedback");
                        // element.closest(".form-group").append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-invalid");
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass("is-invalid");
                        $(element).addClass("is-valid");
                    },
                    submitHandler: function() {
                        var form_data = new FormData(document.getElementById("form_id"));
                        if ($("#hidden_id").val() == "") {

                            // add record
                            $.ajax({
                                url: apiURL + "student",
                                type: "POST",
                                data: form_data,
                                contentType: false,
                                cache: false,
                                processData: false,
                                dataType: "json",
                                success: function(data) {
                                    console.log(data)
                                    loadTable();
                                    if (data) {

                                        notification("success", "Success!",
                                            "Student Successfully Added");
                                    } else {
                                        notification("error", "Error!",
                                            "Error in Adding Student");
                                    }

                                    formReset("hide");
                                    // loadTable();
                                },
                                error: function({
                                    responseJSON
                                }) {
                                    notification("error", "Error!",
                                        "Error in Creating Room");
                                    // console.log(responseJSON);
                                    // console.log(responseJSON.responseText)
                                },
                            });
                        } else {
                            // update record

                            form_data.append("_token", "{{ csrf_token() }}");
                            form_data.append("_method", "PUT");


                            $.ajax({
                                url: apiURL + "student/" + $('#hidden_id').val(),
                                type: "POST",
                                data: form_data,
                                contentType: false,
                                cache: false,
                                processData: false,
                                dataType: "json",
                                success: function(data) {
                                    console.log(data)
                                    loadTable();

                                    if (data) {
                                        notification("success", "Success!",
                                            "Student Successfully Updated");
                                    } else {
                                        notification("error", "Error!",
                                            "Error in Updating Student");
                                    }

                                    formReset("hide");
                                    // loadTable();
                                },
                                error: function({
                                    responseJSON
                                }) {
                                    notification("error", "Error!",
                                        "Error in Updating Room");
                                },
                            });
                        }
                    },
                });
        })

        loadCourses = () => {
            $.ajax({
                url: apiURL + "course",
                type: "GET",
                dataType: "json",
                success: function(responseData) {

                    $("#course_id").empty();
                    $.each(responseData.data, function(i, dataOptions) {
                        var options = "";

                        options =
                            "<option value='" +
                            dataOptions.id +
                            "'>" +
                            dataOptions.course_name +

                            "</option>";

                        $("#course_id").append(options);
                    });

                },
                error: function({
                    responseJSON
                }) {},
            });
        };

        loadCourses();


        loadTable = () => {
            $("#data-table").dataTable().fnClearTable();
            $("#data-table").dataTable().fnDraw();
            $("#data-table").dataTable().fnDestroy();
            $('#data-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('students.datatable') }}",
                },
                columns: [{
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
                    },
                    {
                        data: 'region',
                        name: 'region'
                    },
                    {
                    data: null,
                    name: null,
                    render: function (aData, type, row) {
                        console.log(aData)
                        return aData.courses.course_name;
                    }
                    },

                    {
                        data: 'section',
                        name: 'section'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });
        }


        // function to show details for viewing/updating
        editData = (id, type) => {
            $.ajax({
                url: apiURL + "student/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    formReset("show");


                    $("#hidden_id").val(data["id"]);
                    $("#full_name").val(data["full_name"]);
                    $("#contact").val(data["contact"]);
                    $("#region").val(data["region"]);
                    $("#course_id").val(data["course_id"]).trigger("change");
                    $("#section").val(data["section"]);



                    // if data is for viewing only
                    if (type == 0) {
                        $("#form_id input, select, textarea").prop("disabled", true);
                        $(".submit").hide();
                    } else {
                        $("#form_id input, select, textarea").prop("disabled", false);
                        $(".submit").show();
                    }

                },
                error: function(data) {
                    console.log(data)

                },
            });
        };

        // function to delete data
        deleteData = (id) => {
            Swal.fire({
                title: "Are you sure you want to delete this record?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#34c38f",
                cancelButtonColor: "#f46a6a",
                confirmButtonText: "Yes, delete it!",
            }).then(function(t) {
                // if user clickes yes, delete it.
                if (t.value) {
                    url = apiURL + "student/" + id;
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(data) {
                            loadTable();
                          notification("warning", "Success!", "Student Successfully Deleted");
                  
                       
                        },
                        error: function({
                            responseJSON
                        }) {
                                notification("error", "Error!", "Error In Deleting Student");

                        },
                    });
                }
            });
        };
    </script>
@endsection
