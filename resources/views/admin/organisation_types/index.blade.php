@extends('layouts.admin')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Organisation Types</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Organisation Types</li>
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

                                        <a href="{{route('admin.organisation-types.index')}}"
                                           class="btn btn-info  add-btn">
                                            <i class="fa fa-refresh"></i> Refresh
                                        </a>
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
                                <div id="tree"></div>
                                <!--end tree-->
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-8">
                        <!-- Place this where you want to display messages -->
                        <div id="messageContainer"></div>
                        <div id="errorContainer"></div>


                        <div class="card border card-border-light">
                            <div class="card-header">
                                <h6 id="card-title" class="card-title mb-0">Add New Organisation Type</h6>
                            </div>
                            <div class="card-body">
                                <form id="organisationTypeform" action="/admin/organisation-types/store" method="post"
                                      enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Organisation Type</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="Enter organisation type" value="">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Describe Organisation Type</label>
                                        <textarea type="text" name="description" class="form-control" id="description"
                                                  placeholder="Describe Organisation Type"></textarea>
                                    </div>
                                    <div class="text-start">
                                        <button id="submit-button" type="submit" class="btn btn-primary">Add New
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>
                    <!--end col-->
                    <!--end card-->
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
            // Initialize the tree
            var tree = $('#tree').tree({
                primaryKey: 'id',
                dataSource: '/api/admin/organisation-types',
                uiLibrary: 'bootstrap4',
                cascadeCheck: false,
            });

            var hiddenNodeIdField = $('#hiddenNodeId');
            var checkedNodeNameElement = $('#checkedNodeName');
            var submitButton = $('#submit-button');
            var cardTitle = $('#card-title');
            var pageTitle = $('#page-title');

            let primaryNodeId = null;
            let nodeName = null;
            let organisationTypeName = null;
            let organisationTypeSlug = null;
            let actionUrl = null;
            actionUrl = '/admin/organisation-types/store';
            // Handle node selection
            tree.on('select', function (e, $node, id) {
                saveSelectedNodeId(id);
                var nodeData = tree.getDataById(id);

                if (nodeData) {
                    primaryNodeId = nodeData.id;
                    nodeName = nodeData.text;
                    organisationTypeName = nodeName;
                    organisationTypeSlug = nodeData.slug;

                    cardTitle.text('Add - ' + organisationTypeName + ' (children organisation types)');
                    pageTitle.text('Add - ' + organisationTypeName + ' (children organisation types)');
                    submitButton.text('Add ' + organisationTypeName + '(children organisation types)');
                    /*$('#organisationTypeform').attr('action', '/admin/organisation-types/' + organisationTypeSlug);*/
                    actionUrl =  '/admin/organisation-types/' + organisationTypeSlug;

                    hiddenNodeIdField.val(primaryNodeId);
                    checkedNodeNameElement.text(nodeName);

                    // Clear form fields
                    $('#name').val('');
                    $('#description').val('');
                }
            });
            tree.on('unselect', function (e, node, id) {
                actionUrl = '/admin/organisation-types/store';
                clearSavedNodeId();
            });

            $('#organisationTypeform').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    type: 'POST',
                    url: actionUrl, // The URL to the server-side script that will process the form data
                    data: formData,
                    success: function(response) {
                        $('#organisationTypeform').trigger('reset');

                        // Set the flag to true and reload the tree
                        treeReloaded = true;
                        tree.reload();

                        if (response.success) {
                            // Display success message
                            $('#messageContainer').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                '<strong>Message!</strong> ' + response.message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                                '</div>');
                        }

                        console.log('Form successfully submitted. Server responded with: ' + response);
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

            var treeReloaded = true; // Flag to check if tree has been reloaded

            // Function to save selected node ID to local storage
            function saveSelectedNodeId(nodeId) {
                localStorage.setItem('selectedNodeId', nodeId);
            }

            // Function to get selected node ID from local storage
            function getSelectedNodeId() {
                return localStorage.getItem('selectedNodeId');
            }

            // Function to clear the saved node ID from local storage
            function clearSavedNodeId() {
                localStorage.removeItem('selectedNodeId');
            }

            // Function to expand from root to a given node
            function expandFromRootToNode(nodeId) {
                var parents = tree.parents(nodeId);
                if (parents && parents.length) {
                    parents.reverse().forEach(function(parentId) {
                        tree.expand(parentId);
                    });
                }
                tree.expand(nodeId);
            }

            // Function to select and expand from root to a node by ID
            function selectAndExpandFromRootToNode(nodeId) {
                console.log("Selecting and expanding node: ", nodeId);
                var nodeToSelect = tree.getNodeById(nodeId);
                if (nodeToSelect) {
                    tree.select(nodeToSelect);  // Selects the node
                    expandFromRootToNode(nodeId);  // Expands from root to the node
                } else {
                    console.log("Node not found: ", nodeId);
                }
            }

            // Select and expand from root to the node if it's saved in local storage
            var savedNodeId = getSelectedNodeId();
            if (savedNodeId) {
                selectAndExpandFromRootToNode(savedNodeId);
            }

            // Event listener for node selection
            tree.on('select', function (e, node, id) {
                saveSelectedNodeId(id);
            });

            // Event listener for node unselection (if applicable)
            // Replace 'unselect' with the correct event name if different
            tree.on('unselect', function (e, node, id) {
                clearSavedNodeId();
            });

            // Handle the dataBound event
            tree.on('dataBound', function() {
                if (treeReloaded) {
                    var savedNodeId = getSelectedNodeId();
                    if (savedNodeId) {
                        selectAndExpandFromRootToNode(savedNodeId);
                    }
                    // Reset the flag
                    treeReloaded = false;
                }
            });
        });


    </script>

@endsection
