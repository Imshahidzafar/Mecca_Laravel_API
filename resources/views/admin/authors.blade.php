@extends('layout.admin.list_master')
@section('content')
    <style>
        .btn-light{
          padding-left:10px;
        }
    </style>
    <!-- Add Author -->
    <div class="modal fade" id="exampleModalAddAuthor">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            @section('titleBar')
            <span class="ml-2">Add Author</span>
            @endsection 
                <div class="modal-header">
                    <h5 class="modal-title">Add Author</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="basic-form">

                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Name</b>
                                <b><input  type="text" name="auth_name" class="form-control auth_name input" required></b>
                                <span class="error_msg" id="auth_name_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Description</b>
                                <b><textarea rows="4" cols="50" name="description" class="form-control description input" ></textarea></b>
                                <span class="error_msg" id="description_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Image</b>
                                <b><input  type="file" name="image" id="image" class="form-control image input" required multiple></b>
                                <span class="error_msg" id="image_error"></span>
                                <textarea rows="10" cols="50" class="input" id="image_string" hidden></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_author">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Author -->

    <!-- Edit Author -->
    <div class="modal fade" id="editAuthorModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            @section('titleBar')
            <span class="ml-2">Edit Author</span>
            @endsection 
                <div class="modal-header">
                    <h5 class="modal-title">Edit Author</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="basic-form">
                        <input type="hidden" class="input" id="authors_id">
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Name</b>
                                <b><input  type="text" name="name" id="name" class="form-control name input" required></b>
                                <span class="error_msg" id="name_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Description</b>
                                <b><textarea rows="4" cols="50" id="description"  name="description" class="form-control description input" ></textarea></b>
                                <span class="error_msg" id="description_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Image</b>
                                <b><input  type="file" name="image" id="edit_image" class="form-control image input" required multiple></b>
                                <span class="error_msg" id="image_error"></span>
                                <textarea rows="10" cols="50" class="input" id="edit_image_string" hidden></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <b>Old Image</b>
                                <div class="image-box text-center mx-auto">
                                    <img src="" class="img-fluid" id="image_preview" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit_author">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Author -->

    <!-- View Author -->
    <div class="modal fade" id="viewAuthorModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            @section('titleBar')
            <span class="ml-2">View Author</span>
            @endsection 
                <div class="modal-header">
                    <h5 class="modal-title">View Author</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div id="AuthorViewModal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Author -->

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles mb-n5">
				<ol class="breadcrumb">
                    @section('titleBar')
                    <span class="ml-2">Authors</span>
                    @endsection
				</ol>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-12">
                    

                    <div class="card">
                        <div class="card-body">                                    
                        <legend style="float: right;"><a style="float: right;" class="btn btn-primary" id="add_author"  data-toggle="modal" data-target="#exampleModalAddAuthor"> Add Author </a></legend>
                            <div class="table-responsive">
                                <table id="example" class="table dt-responsive nowrap display min-w850">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Image</th>
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
                </div>
          	</div>
        </div>
    </div>
    <script src="{{ url('/public/users/assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ url('/public/users/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('/public/users/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('/public/users/assets/js/jquery.ui.min.js') }}"></script>
    <script src="{{ url('/public/users/assets/js/jquery.additional.methods.js') }}"></script>
    <script>
        $(document).ready(function(){
            
            
            // --------------- IMAGE PREVIEW & BSASE64 STRING --------------- //
            function previewImage (image,string) {
                var fileImage = image.files[0];
                var reader = new FileReader();

                reader.addEventListener("load", function() {

                    document.querySelector(string).value = reader.result.toString().replace(/^data:(.*,)?/, "");
                }, false);

                if (fileImage) {
                    reader.readAsDataURL(fileImage);
                }
            }

            document.querySelector("#image").addEventListener("change", function() {
                previewImage(this,"#image_string");
            });
            document.querySelector("#edit_image").addEventListener("change", function() {
                previewImage(this,"#edit_image_string");
            });
            
            fetch();
            function fetch() {
                var settings = {
                    "url": "{{ env('APP_URL') }}" + "authors_fetch",
                    "method": "GET",
                    "timeout": 0,
                };
                
                $.ajax(settings).done(function (response) {
                                $('tbody').html("");
                                $.each(response.authors, function (key, item) { 
                                    var nametxt= item.name;
                                    var name='';
                                    if(nametxt.length > 40){
                                        name=nametxt.substring(0,40) + '.....';
                                    }else{
                                        name=item.name;
                                    }

                                    var descriptiontxt= item.description;
                                    var description='';
                                    if(descriptiontxt != null && descriptiontxt.length > 40){
                                        description=descriptiontxt.substring(0,40) + '.....';
                                    }else if(descriptiontxt != null){
                                        description=descriptiontxt;
                                    }else{
                                        description='N/A';
                                    }
                                    var statusHtml = '';
                                    if (item.status == "Pending") {
                                        statusHtml = '<span class="btn m-1 btn-info">Pending</span>';
                                    } else if (item.status == "Active") {
                                        statusHtml = '<span class="btn m-1 btn-success">Active</span>';
                                    } else if (item.status == "Inactive") {
                                        statusHtml = '<span class="btn m-1 btn-warning">Inactive</span>';
                                    } else {
                                        statusHtml = '<span class="btn m-1 btn-danger">Deleted</span>';
                                    }

                                    var actionHtml = '';
                                    
                                        actionHtml += '<button class="btn m-1 btn-primary view_author" value="' + item.authors_id + '">';
                                        actionHtml += '<i class="fa fa-eye"></i>';
                                        actionHtml += '</button>';
                                        
                                        actionHtml += '<button class="btn m-1 btn-info edit_author"  value="' + item.authors_id + '">';
                                        actionHtml += '<i class="fa fa-edit"></i>';
                                        actionHtml += '</button>';
                                    if (item.status == "Active") {
                                        actionHtml += '<button class="btn m-1 btn-warning update_data" value="' + item.authors_id + '" data-info="Inactive">';
                                        actionHtml += '<i class="fa fa-times"></i>';
                                        actionHtml += '</button>';
                                        
                                    } else if (item.status == "Inactive") {
                                        actionHtml += '<button class="btn m-1 btn-success update_data" value="' + item.authors_id + '" data-info="Active" >';
                                        actionHtml += '<i class="fa fa-check"></i>';
                                        actionHtml += '</button>';
                                    }

                                    if (item.status == "Pending" || item.status == "Deleted") {
                                        actionHtml += '<button class="btn m-1 btn-warning update_data" value="' + item.authors_id + '" data-info="Inactive">';
                                        actionHtml += '<i class="fa fa-times"></i>';
                                        actionHtml += '</button>';
                                        actionHtml += '<button class="btn m-1 btn-success update_data" value="' + item.authors_id + '" data-info="Active">';
                                        actionHtml += '<i class="fa fa-check"></i>';
                                        actionHtml += '</button>';
                                    }

                                    if (item.status != "Deleted") {
                                        actionHtml += '<button class="btn m-1 btn-danger delete_data" value="' + item.authors_id + '" data-info="Deleted">';
                                        actionHtml += '<i class="fa fa-trash"></i>';
                                        actionHtml += '</button>';
                                    }
                                    var profile_image = "{{ url('/public') }}" + "/" +item.image;
                                    $('tbody').append('\
                                        <tr class="odd gradeX">\
                                        <td>' + (key+1) + '</td>\
                                        <td>' + name + '</td>\
                                        <td>' + description + '</td>\
                                        <td><img src="'+profile_image+'" class="img-fluid" alt="image" srcset="" width="55px" height="50px"></td>\
                                        <td>' + statusHtml + '</td>\
                                        <td>' + actionHtml + '</td>\
                                        </tr>\
                                    ');
                                    });
                });
            }

            $(document).on("click",'.edit_author', function (e) {
                e.preventDefault();
                var connect_articles_id=$(this).val();
                $('#editAuthorModal').modal('show');
                
                var settings = {
                    "url": "{{ env('APP_URL') }}" + "author_edit/"+connect_articles_id,
                    "method": "GET",
                    "timeout": 0,
                };

                $.ajax(settings).done(function (response) {
                    var profile_image = "{{ url('/public') }}" + "/" +response.data.image;
                    if(response.status == "error"){
                        toastr.success(response.message);
                    }else{
                        $('#name').val(response.data.name);
                        $('#description').val(response.data.description);
                        $('#authors_id').val(response.data.authors_id);
                        $('#image_preview').attr('src', profile_image);
                    }
                });
            });

            $(document).on("click",'.delete_data', function (e) {
                    e.preventDefault();
                    var authors_id=$(this).val();;
                    var settings = {
                    "url": "{{ env('APP_URL') }}" + "author_delete",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'authors_id':authors_id,
                    },
                };
                $.ajax(settings).done(function (response) {
                    if(response.status == "success"){ 
                        fetch();
                        toastr.success(response.message);
                    }else{
                        toastr.success(response.message);
                    }
                });
            });

            $(document).on("click",'.update_data', function (e) {
                    e.preventDefault();
                    var authors_id=$(this).val();
                    var status=$(this).data("info");
                    var settings = {
                    "url": "{{ env('APP_URL') }}" + "author_update",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'authors_id':authors_id,
                        'status':status,
                    },
                };
                $.ajax(settings).done(function (response) {
                    if(response.status == "success"){ 
                        fetch();
                        toastr.success(response.message);
                    }else{
                        toastr.success(response.message);
                    }
                });
            });


            $(document).on("click",'.view_author', function (e) {
                    e.preventDefault();
                    var authors_id=$(this).val();
                    $('#viewAuthorModal').modal('show');
                    var settings = {
                    "url": "{{ env('APP_URL') }}" + "author_edit/"+authors_id,
                    "method": "GET",
                    "timeout": 0,
                };

                $.ajax(settings).done(function (response) {
                        $('#AuthorViewModal').html("");
                        if(response.status == "success"){
                                var statusHtml = '';
                                if (response.data.status == "Pending") {
                                    statusHtml = '<span class="btn m-1 btn-info">Pending</span>';
                                } else if (response.data.status == "Active") {
                                    statusHtml = '<span class="btn m-1 btn-success">Active</span>';
                                } else if (response.data.status == "Inactive") {
                                    statusHtml = '<span class="btn m-1 btn-warning">Inactive</span>';
                                } else {
                                    statusHtml = '<span class="btn m-1 btn-danger">Deleted</span>';
                                }
                                var profile_image = "{{ url('/public') }}" + "/" +response.data.image
                                $('#AuthorViewModal').append('<div class="modal-body"> \
                                        <lable><h5>Name:</h5></lable>\
                                        <h5 class="text-primary mb-0">'+ response.data.name +'</h5>\
                                        <lable><h5>Description:</h5></lable>\
                                            <p class="modal-description" style="word-wrap: break-word;">' + response.data.description +'</p>\
                                        <lable><h5>Image:</h5></lable>\
                                        <img src="'+profile_image+'" class="img-fluid my-2"  width="250px" height="250px" id="image_preview" alt="">\
                                        <div><lable><h5>Status:</h5></lable>\
                                    <span class="dropdown ml-auto mt-1">' + statusHtml + '</span></div></div>');
                        }else{
                            toastr.success(response.message);
                        }
                    });
            });
            $(document).on('click','#edit_author',function(e){
                    e.preventDefault();
                    var settings = {
                    "url": "{{ env('APP_URL') }}" + "author_edit_data",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'authors_id':$("#authors_id").val(),
                        'name':$('#name').val(),                    
                        'description':$('#description').val(),                                     
                        'image':$('#edit_image_string').val(),
                    },
                };

                $.ajax(settings).done(function (response) {
                        if (response.status == "success") {
                            toastr.success(response.message);
                            fetch();
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            $('.modal').removeClass('show');
                        } else {
                            toastr.error(response.message);
                            fetch();
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            $('.modal').removeClass('show');
                        }
                });
            });     

        $(document).on('click','.add_author',function(e){
                e.preventDefault();
                var settings = {
                "url": "{{ env('APP_URL') }}" + "author_add_data",
                "method": "POST",
                "timeout": 0,
                "data": {
                    'name':$('.auth_name').val(),
                    'description':$('.description').val(),
                    'image':$('#image_string').val(),
                },
            };
            $.ajax(settings).done(function (response) {
                if (response.status == "success") {
                    toastr.success(response.message);
                    fetch();
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('.modal').removeClass('show');
                    $( ".input" ).each(function() {
                        $(this).val("");
                    });
                } else {
                    toastr.error(response.message);
                    fetch();
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('.modal').removeClass('show');
                    $( ".input" ).each(function() {
                        $(this).val("");
                    });
                }
            });
        });


        });
    </script>
@endsection