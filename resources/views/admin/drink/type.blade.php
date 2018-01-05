@extends('layouts.pals')

@section('content')

    <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
            <div class="navbar-collapse collapse in">
                @include('layouts.common.navmobile')
                <ul class="nav navbar-nav navbar-left">
                    <li class="navbar-title"><strong>All Drink Types</strong></li>
                    {{--<li class="navbar-search hidden-sm">
                        <input id="searchTerm" type="text" placeholder="Search.." value="{{ old('search') }}">
                        <button class="btn-search" id="searchBtn"><i class="fa fa-search"></i></button>
                    </li>--}}
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @include('layouts.common.navbar')
                </ul>
            </div>
        </div>
    </nav>

    @include('layouts.common.flash')

    <div class="row">

        <div class="col-sm-6 col-xs-12">
            <div class="card card-mini">
                <div class="card-header">Types</div>
                <div class="card-body">
                    <div class="row" id="card-types">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xs-12">
            <div class="card card-mini">
                <div class="card-header">Add New</div>
                <div class="card-body" id="card-new-type">
                    <div class="row">
                        <form action="" name="formType" class="toggle-disabled">
                            <input type="hidden" id="type-id">

                            <!-- Name Form Input -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name"
                                       class="form-control" value="{{ old('name') }}"
                                       data-validation="length"
                                       data-validation-length="min1"
                                       data-validation-error-msg="Name is required."
                                >
                            </div>
                            <!-- Description Form Input -->
                            <div class="form-group">
                                <label for="description">Color</label>
                                <input type="text" name="color" class="form-control" id="color"
                                       value="{{ old('color') }}" placeholder="#FF0000">
                            </div>

                            <button type="submit" class="btn btn-success" id="btnAddType">Add New</button>

                            <div class="pull-right">
                                <button class="btn btn-default" id="btnCancel" style="display: none;">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>

        $.validate({
            modules: 'toggleDisabled',
            disabledFormFilter: 'form.toggle-disabled',
            showErrorDialogs: false
        });

        var Types = function () {

            return {

                deleteType: function () {
                    $(document).on('click', '.btnDeleteType', function (e) {
                        e.preventDefault();
                        var $dataRequestId = $(this).data('id');
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('ajax.administrator.drink.delete.type') }}",
                            data: {'id': $dataRequestId},
                            dataType: 'json',
                            beforeSend: function () {
                                $('#card-type').LoadingOverlay('show');
                            },
                            success: function (data) {
                                Types.loadTypes();
                                Types.resetForm();
                            }, error: function (xhr, status, error) {
                                var errors = data.responseJSON;
                                console.log(errors);
                                alert('An error has occur, please contact the administrator.');
                                Types.resetForm();
                            }
                        });

                    });
                },
                editType: function () {

                    $(document).on('click', '.btnEditType', function (e) {
                        e.preventDefault();
                        $('#btnCancel').show();

                        var $dataRequestId = $(this).data('id');
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('ajax.administrator.drink.edit.type') }}",
                            data: {'id': $dataRequestId},
                            dataType: 'json',
                            beforeSend: function () {
                                $('#card-new-type').LoadingOverlay('show');
                            },
                            success: function (data) {
                                $('#name').val(data.type.name);
                                $('#type-id').val(data.type.id);
                                $('#color').val(data.type.color);
                                $('#btnAddType').text('Update');

                                Types.validateForm();
                                $('#card-new-type').LoadingOverlay('hide');

                            }, error: function (xhr, status, error) {
                                var errors = data.responseJSON;
                                console.log(errors);
                                alert('An error has occur, please contact the administrator.');
                                Types.resetForm();
                            }
                        });

                    });
                },

                loadTypes: function () {

                    $.ajax({
                        type: 'GET',
                        url: "{{ route('ajax.administrator.drink.types') }}",
                        dataType: 'html',
                        beforeSend: function () {
                            $('#card-types').LoadingOverlay('show');
                        },
                        success: function (data) {
                            $('#card-types').html(data);
                            setTimeout(function () {
                                $('#card-types').LoadingOverlay('hide');
                            }, 1000);
                        }, error: function (xhr, status, error) {
                            var errors = data.responseJSON;
                            console.log(errors);
                            alert('An error has occur, please contact the administrator.');
                            Types.resetForm();
                        }
                    })
                },

                addEditType: function () {

                    $('#btnAddType').on('click', function (e) {

                        var $id = $('#type-id').val();
                        var $name = $('#name').val();
                        var $color = $('#color').val();

                        e.preventDefault();

                        // If button is Add Type
                        if ($('#btnAddType').text() == 'Add New') {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('ajax.administrator.drink.add.type') }}",
                                data: {'name': $name, 'color': $color},
                                dataType: 'json',
                                beforeSend: function () {
                                    $('#card-new-type').LoadingOverlay('show');
                                },
                                success: function (data) {
                                    if (data.status == 'OK') {
                                        Types.loadTypes();
                                        Types.resetForm();
                                    }

                                }, error: function (data) {
                                    var errors = data.responseJSON;
                                    console.log(errors);
                                    alert('An error has occur, please contact the administrator.');
                                    Types.resetForm();
                                }
                            });

                        } else {

                            $.ajax({
                                type: 'POST',
                                url: "{{ route('ajax.administrator.drink.update.type') }}",
                                data: {'id': $id, 'name': $name, 'color': $color},
                                dataType: 'json',
                                beforeSend: function () {
                                    $('#card-new-type').LoadingOverlay('show');
                                },
                                success: function (data) {
                                    if (data.status == 'OK') {
                                        Types.loadTypes();
                                        Types.resetForm();
                                    }

                                    $('#card-new-type').LoadingOverlay('hide');

                                }, error: function (data) {
                                    var errors = data.responseJSON;
                                    console.log(errors);
                                    alert('An error has occur, please contact the administrator.');
                                    Types.resetForm();
                                }
                            });
                        }

                    });


                },

                resetForm: function () {
                    $('#type-id').val('');
                    $('#name').val('');
                    $('#color').val('');
                    Types.validateForm();
                    $('#btnCancel').hide();
                    $('#btnAddType').text('Add New');
                    $('#card-new-type').LoadingOverlay('hide');
                },

                cancelEdit: function () {
                    $('#btnCancel').click(function () {
                        Types.resetForm();
                    });
                },

                validateForm: function () {
                    $('#name').validate();
                },
                // Call all functions
                init: function () {
                    Types.loadTypes();
                    Types.addEditType();
                    Types.resetForm();
                    Types.editType();
                    Types.cancelEdit();
                    Types.deleteType();
                }
            }
        }();

        Types.init();
    </script>
@endsection