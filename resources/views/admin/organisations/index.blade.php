@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Organisations</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Organisations</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="flex-grow-1">

                                        <a href="" class="btn btn-info add-btn">
                                            <i class="fa fa-refresh"></i> Refresh
                                        </a>
                                        <button id="new-button" class="btn btn-success add-btn">
                                            <i class="fa fa-plus"></i> Add new
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-4">
                        <div class="card">
                            <div class="card-body">
                                <!--start tree-->
                                <div style="overflow:scroll; height:600px;" id="tree"></div>
                                <!--end tree-->
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-8">
                        <!-- Place this where you want to display messages -->
                        <div id="messageContainer"></div>
                        <div id="errorContainer"></div>
                        <!-- Rest of your HTML -->
                        <div class="card">
                            <div class="card-body">
                                <div class="card border card-border-light">
                                    <div class="card-header">
                                        <p id="location"></p>
                                        <h6 id="card-title" class="card-title mb-0">Add New Organisation</h6>
                                        <p style="font-size: 15px;color: red;"><i class="fa fa-arrow-left"></i>
                                            Select an
                                            organisation type</p>
                                    </div>
                                    <div class="card-body">
                                        <form id="organisationForm" action="" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="_method" value="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Organisation</label>
                                                <input type="text" name="name" class="form-control"
                                                       id="fieldName"
                                                       placeholder="Enter organisation name" value="">
                                            </div>
                                            <!-- Make sure the name attribute matches your database column name -->
                                            <input type="hidden" name="parent_id" value="" id="parent_id">
                                            <input type="hidden" name="parent_name" value="" id="parent_name">
                                            <input type="hidden" name="organisation_type" value="" id="organisation_type">
                                            <input type="hidden" name="organisation_type_id" value="" id="organisation_type_id">

                                            <div class="text-start">
                                                <button id="submit-button" type="submit"
                                                        class="btn btn-primary">Add New
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div>


                </div>


            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>

    <script>

        $(document).ready(function () {
            //set up laravel ajax csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            var tree = $('#tree').tree({
                primaryKey: 'id',
                dataSource: '/api/admin/organisations',
                uiLibrary: 'bootstrap4',
                cascadeCheck: false,
            });

            function fetchOrganisation(organisation) {
                $.ajax({
                    url: '/api/admin/organisations/' + organisation + '/edit',
                    type: 'GET',
                    success: function (data) {
                        $('#fieldName').val(data.name);
                        $('#fieldDescription').val(data.description);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }

            function clearOrganisationTypeFields() {
                $('#fieldName').val('');
                $('#fieldDescription').val('');
            }

            var organisationForm = $('#organisationForm');
            var manageOrganisation = $('#manageOrganisation');
            var manageUsers = $('#manageUsers');
            organisationForm.hide();
            manageOrganisation.hide();
            manageUsers.hide();

            let [rand, type, organisation_id] = [null, null, null];

            var hiddenNodeIdField = $('#hiddenNodeId');
            var checkedNodeNameElement = $('#checkedNodeName');

            let parentId = null;
            let parentName = null;
            let primaryNodeId = null;
            let nodeName = null;
            let organisationID = null;
            let organisationType = null;
            let organisationName = null;
            let organisationSlug = null;
            let typeName = null;
            let typeId = null;
            let actionUrl = null;
            actionUrl = '/admin/organisations/store';

            var submitButton = $('#submit-button');
            var cardTitle = $('#card-title');
            var pageTitle = $('#page-title');



            // Handle node selection
            tree.on('select', function (e, $node, id) {
                /*saveSelectedNodeId(id);*/
                var nodeData = tree.getDataById(id);

                if (nodeData) {
                    primaryNodeId = nodeData.id;
                    nodeName = nodeData.text;
                    parentId = nodeData.parentId;
                    parentName = nodeData.parentName;
                    typeName = nodeData.type;
                    typeId = nodeData.type_id;

                    [rand, type, organisation_id] = nodeData.id.split('-');

                    organisationID = organisation_id;
                    organisationType = type;
                    organisationName = nodeName;
                    organisationSlug = nodeData.slug;

                    cardTitle.text('Add - ' + organisationName + ' for ' + parentName);
                    pageTitle.text('Add - ' + organisationName);

                   /* alert('Parent id '+ parentId + ' and Parent Name '+ parentName + ' Type id '+ typeId + ' and Type Name '+ typeName);*/

                    submitButton.text('Add ' + organisationName + ' New');
                    $('#parent_id').val(parentId);
                    $('#parent_name').val(parentName);
                    $('#organisation_type').val(typeName);
                    $('#organisation_type_id').val(typeId);

                    if (organisationType === 'ot') {
                        organisationForm.show();
                        $('input[name="_method"]').val('POST');
                        clearOrganisationTypeFields();
                        $('#organisationForm').attr('action', '/admin/organisations/store');
                        actionUrl = '/admin/organisations/store';
                        manageOrganisation.hide();
                    }

                    if (organisationType === 'o') {
                        organisationForm.show();
                        $('#organisationForm').attr('action', '/admin/organisations/' + organisationSlug + '/update');
                        actionUrl = '/admin/organisations/' + organisationSlug + '/update';
                        $('input[name="_method"]').val('PATCH');
                        submitButton.text('Update ' + organisationName);

                        cardTitle.text('Edit - ' + organisationName);
                        fetchOrganisation(organisationSlug);
                    }

                    hiddenNodeIdField.val(primaryNodeId);
                    checkedNodeNameElement.text(nodeName);
                }
            });


            $('#organisationForm').submit(function (event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    type: 'POST',
                    url: actionUrl, // The URL to the server-side script that will process the form data
                    data: formData,
                    success: function (response) {
                        $('#organisationForm').trigger('reset');
                        treeReloaded = true;
                        tree.reload();

                        if (response.success) {
                            // Display success message
                            $('#messageContainer').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                '<strong>Message!</strong> ' + response.message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>');
                        }
                    },
                    error: function(xhr) { // Added 'xhr' parameter to access response
                        if (xhr.status === 422) { // Validation Error
                            var errors = xhr.responseJSON.errors;
                            var errorsHtml = '';
                            $.each(errors, function(key, value) {
                                errorsHtml += '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    '<strong>Error!</strong> ' + value[0] + // Assuming 'value' is an array of messages
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                    '</div>';
                            });
                            $('#errorContainer').html(errorsHtml);
                        } else {
                            // Handle other kinds of errors
                            console.error('An error occurred while submitting the form.');
                        }
                    }
                });
            });


        });


    </script>
@endsection
