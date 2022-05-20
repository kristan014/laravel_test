@extends('layouts.app')

@section('title')
    Courses
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
                    <h3>Course List</h3>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" onclick="return formReset('show')">Add a new
                        course</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="data-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created_at</th>
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
                            <div class="modal-title">Add new course</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fas fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="hidden_id" id="hidden_id">
                        <div class="form-group">
                            <label for="course_name">Course Name</label>
                            <input type="text" class="form-control form-control-user" id="course_name" name="course_name"
                                placeholder="Course Name">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control form-control-user"></textarea>

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
                        course_name: {
                            required: true,
                        },
                        description: {
                            required: true,
                        },
                    },
                    messages: {
                        course_name: {
                            required: "Please provide course name",
                        },

                        description: {
                            required: "Please provide description",
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
                            // console.log(form_data);
                            // for (var value of form_data.values()) {
                            //   console.log(value);
                            // }

                            // add record
                            $.ajax({
                                url: apiURL + "course",
                                type: "POST",
                                data: form_data,
                                contentType: false,
                                cache: false,
                                processData: false,
                                dataType: "json",

                                success: function(data) {
                                    console.log(data)
                                    loadTable();
                                    formReset("hide");

                                    if (data) {
                                        notification("success", "Success!",
                                            "Course Successfully Added");
                                    } else {
                                        notification("error", "Error!",
                                            "Error in Creating Course");
                                    }

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
                                url: apiURL + "course/" + $('#hidden_id').val(),
                                type: "POST",
                                data: form_data,
                                contentType: false,
                                cache: false,
                                processData: false,
                                dataType: "json",
                                success: function(data) {
                                    console.log(data)
                                    loadTable();

                                    // if (data) {

                                    // 	// notification("success", "Success!", data.message);
                                    // } else {
                                    // 	// notification("error", "Error!", data.message);
                                    // }

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

        loadTable = () => {
            $("#data-table").dataTable().fnClearTable();
            $("#data-table").dataTable().fnDraw();
            $("#data-table").dataTable().fnDestroy();
            $('#data-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('courses.datatable') }}",
                },
                columns: [{
                        data: 'course_name',
                        name: 'course_name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'created_at',
                        name: 'created_at'
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
                url: apiURL + "course/" + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data.data)
                    formReset("show");


                    $("#hidden_id").val(data.data["id"]);
                    $("#course_name").val(data.data["course_name"]);
                    $("#description").val(data.data["description"]);



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
                    url = apiURL + "course/" + id;
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "json",
                        success: function(data) {
                            loadTable();
                            notification("warning", "Success!", "Course Successfully Deleted");


                        },
                        error: function({
                            responseJSON
                        }) {
                            notification("error", "Error!", "Error In Deleting Course");

                        },
                    });
                }
            });
        };
    </script>
@endsection
