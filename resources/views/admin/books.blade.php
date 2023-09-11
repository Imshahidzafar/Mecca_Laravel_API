@extends('layout.admin.list_master')
@section('content')
    <style>
        .btn-light{
          padding-left:10px;
        }
    </style>
    <!-- Add Book -->
    <div class="modal fade" id="exampleModalAddBook">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            @section('titleBar')
            <span class="ml-2">Add Book</span>
            @endsection 
                <div class="modal-header">
                    <h5 class="modal-title">Add Book</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="add_book_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="basic-form">
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Category</b>
                                <b>
                                    <select class="form-control" name="categories_id" id="addCategory">
                                    </select>
                                </b>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Author</b>
                                <b>
                                    <select class="form-control" name="authors_id" id="addAuthor">
                                    </select>
                                </b>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Book Title</b>
                                <b><input  type="text" name="title" class="form-control title input" required></b>
                                <span class="error_msg" id="title_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Book Cover</b>
                                <b><input  type="file" name="cover" id="cover" class="form-control cover input" required></b>
                                <span class="error_msg" id="cover_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Book</b>
                                <b><input  type="file" name="book" id="book" class="form-control book input" required></b>
                                <span class="error_msg" id="book_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Number of Pages</b>
                                <b><input  type="text" name="pages" class="form-control pages input" required></b>
                                <span class="error_msg" id="pages_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary add_book">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Book -->

    <!-- Edit Book -->
    <div class="modal fade" id="editBookModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            @section('titleBar')
            <span class="ml-2">Edit Book</span>
            @endsection 
                <div class="modal-header">
                    <h5 class="modal-title">Edit Book</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
            <form action="" method="POST" id="edit_book_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="basic-form">
                        <input type="hidden" name="books_id" class="input" id="books_id">
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Category</b>
                                <b>
                                    <select class="form-control" name="categories_id" id="editCategory">
                                    </select>
                                </b>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Author</b>
                                <b>
                                    <select class="form-control" name="authors_id" id="editAuthor">
                                    </select>
                                </b>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Book Title</b>
                                <b><input  type="text" name="title" id="title" class="form-control title input" required></b>
                                <span class="error_msg" id="title_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Book Cover</b>
                                <b><input  type="file" name="cover" id="edit_cover" class="form-control cover input" required></b>
                                <span class="error_msg" id="cover_error"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <b>Old cover</b>
                            <div class="image-box text-center mx-auto">
                                <img src="" class="img-fluid" id="cover_preview" class="img-fluid" width="80px" height="80px" alt="book cover">
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Book</b>
                                <b><input  type="file" name="book" id="edit_book" class="form-control book input" required></b>
                                <span class="error_msg" id="book_error"></span>
                            </div>
                        </div>
                        <div class="row col-md-12"> 
                            <div class="form-group col-md-12">
                                <b>Number of Pages</b>
                                <b><input  type="text" name="pages" id="pages" class="form-control pages input" required></b>
                                <span class="error_msg" id="pages_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="edit_book">Edit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- Edit Book -->

    <!-- View Book -->
    <div class="modal fade" id="viewBookModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            @section('titleBar')
            <span class="ml-2">View Book</span>
            @endsection 
                <div class="modal-header">
                    <h5 class="modal-title">View Book</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div id="BookViewModal">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Book -->

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles mb-n5">
				<ol class="breadcrumb">
                    @section('titleBar')
                    <span class="ml-2">Books</span>
                    @endsection
				</ol>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-12">
                    

                    <div class="card">
                        <div class="card-body">                                    
                        <legend style="float: right;"><a style="float: right;" class="btn btn-primary" id="add_book"  data-toggle="modal" data-target="#exampleModalAddBook"> Add Book </a></legend>
                            <div class="table-responsive">
                                <table id="example" class="table dt-responsive nowrap display min-w850">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Title</th>
                                            <th>Pages</th>
                                            <th>Book cover</th>
                                            <th>Downloads</th>
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
            
            fetch();
            function fetch() {
                var getsettings = {
                    "url": "{{ env('API_URL') }}" + "categories_fetch",
                    "method": "GET",
                    "timeout": 0,
                };
                $.ajax(getsettings).done(function(response){ 
                    $('#addCategory').html("");            
                    $.each(response.categories, function (key, item) {
                        $("#addCategory").append('<option value="'+item.categories_id+'">'+item.name+'</option>');
                    });
                    var selectElement = document.getElementById('addCategory');
                    var bootstrapSelect = $(selectElement).data('selectpicker');
                    if (bootstrapSelect !== undefined) {
                       bootstrapSelect.destroy();
                    }
                });
                $.ajax(getsettings).done(function(response) {
                    $('#editCategory').html(""); 
                    $.each(response.categories, function (key, item) {
                        $("#editCategory").append('<option id="categories_id_'+item.categories_id+'" value="'+item.categories_id+'">'+item.name+'</option>');
                    });
                    var selectElement = document.getElementById('editCategory');
                    var bootstrapSelect = $(selectElement).data('selectpicker');
                    if (bootstrapSelect !== undefined) {
                       bootstrapSelect.destroy();
                    }
                });
                var getsettings = {
                    "url": "{{ env('APP_URL') }}" + "authors_fetch",
                    "method": "GET",
                    "timeout": 0,
                };
                $.ajax(getsettings).done(function(response) {
                    $('#addAuthor').html("");            
                    $.each(response.authors, function (key, item) {
                        $("#addAuthor").append('<option value="'+item.authors_id+'">'+item.name+'</option>');
                    });
                    var selectElement = document.getElementById('addAuthor');
                    var bootstrapSelect = $(selectElement).data('selectpicker');
                    if (bootstrapSelect !== undefined) {
                       bootstrapSelect.destroy();
                    }
                });
                $.ajax(getsettings).done(function(response) {
                    $('#editAuthor').html("");            
                    $.each(response.authors, function (key, item) {
                        $('#editAuthor').append('<option id="authors_id_'+item.authors_id+'" value="'+item.authors_id+'">'+item.name+'</option>');
                    });
                    var selectElement = document.getElementById('editAuthor');
                    var bootstrapSelect = $(selectElement).data('selectpicker');
                    if (bootstrapSelect !== undefined) {
                       bootstrapSelect.destroy();
                    }
                });
                var settings = {
                    "url": "{{ env('APP_URL') }}" + "books_fetch",
                    "method": "GET",
                    "timeout": 0,
                };
                
                $.ajax(settings).done(function (response) {
                                $('tbody').html("");
                                $.each(response.books, function (key, item) { 
                                    var titletxt= item.title;
                                    var title='';
                                    if(titletxt.length > 40){
                                        title=titletxt.substring(0,40) + '.....';
                                    }else{
                                        title=item.title;
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
                                    
                                        actionHtml += '<button class="btn m-1 btn-primary view_book" value="' + item.books_id + '">';
                                        actionHtml += '<i class="fa fa-eye"></i>';
                                        actionHtml += '</button>';
                                        
                                        actionHtml += '<button class="btn m-1 btn-info edit_book"  value="' + item.books_id + '">';
                                        actionHtml += '<i class="fa fa-edit"></i>';
                                        actionHtml += '</button>';
                                    if (item.status == "Active") {
                                        actionHtml += '<button class="btn m-1 btn-warning update_data" value="' + item.books_id + '" data-info="Inactive">';
                                        actionHtml += '<i class="fa fa-times"></i>';
                                        actionHtml += '</button>';
                                        
                                    } else if (item.status == "Inactive") {
                                        actionHtml += '<button class="btn m-1 btn-success update_data" value="' + item.books_id + '" data-info="Active" >';
                                        actionHtml += '<i class="fa fa-check"></i>';
                                        actionHtml += '</button>';
                                    }

                                    if (item.status == "Pending" || item.status == "Deleted") {
                                        actionHtml += '<button class="btn m-1 btn-warning update_data" value="' + item.books_id + '" data-info="Inactive">';
                                        actionHtml += '<i class="fa fa-times"></i>';
                                        actionHtml += '</button>';
                                        actionHtml += '<button class="btn m-1 btn-success update_data" value="' + item.books_id + '" data-info="Active">';
                                        actionHtml += '<i class="fa fa-check"></i>';
                                        actionHtml += '</button>';
                                    }

                                    if (item.status != "Deleted") {
                                        actionHtml += '<button class="btn m-1 btn-danger delete_data" value="' + item.books_id + '" data-info="Deleted">';
                                        actionHtml += '<i class="fa fa-trash"></i>';
                                        actionHtml += '</button>';
                                    }
                                    var book_cover = "{{ url('/public') }}" + "/" +item.cover;
                                    $('tbody').append('\
                                        <tr class="odd gradeX">\
                                        <td>' + (key+1) + '</td>\
                                        <td>' + item.author.name + '</td>\
                                        <td>' + item.category.name + '</td>\
                                        <td>' + title + '</td>\
                                        <td>' + item.pages + '</td>\
                                        <td><img src="'+book_cover+'" class="img-fluid" alt="book cover" srcset="" width="50px" height="50px"></td>\
                                        <td>'+ item.downloads +'</td>\
                                        <td>' + statusHtml + '</td>\
                                        <td>' + actionHtml + '</td>\
                                        </tr>\
                                    ');
                                    });
                });
            }

            $(document).on("click",'.edit_book', function (e) {
                e.preventDefault();
                var books_id=$(this).val();
                $('#editBookModal').modal('show');
                
                var settings = {
                    "url": "{{ env('APP_URL') }}" + "book_edit/"+books_id,
                    "method": "GET",
                    "timeout": 0,
                };

                $.ajax(settings).done(function (response) {
                    var book_cover = "{{ url('/public') }}" + "/" +response.data.cover;
                    if(response.status == "error"){
                        toastr.success(response.message);
                    }else{
                        $('#authors_id_' + response.data.authors_id).attr('selected', true);
                        $('#categories_id_' + response.data.categories_id).attr('selected', true);
                        $('#title').val(response.data.title);
                        $('#pages').val(response.data.pages);
                        $('#books_id').val(response.data.books_id);
                        $('#cover_preview').attr('src', book_cover);
                    }
                });
            });

            $(document).on("click",'.delete_data', function (e) {
                    e.preventDefault();
                    var books_id=$(this).val();;
                    var settings = {
                    "url": "{{ env('APP_URL') }}" + "book_delete",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'books_id':books_id,
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
                    var books_id=$(this).val();
                    var status=$(this).data("info");
                    var settings = {
                    "url": "{{ env('APP_URL') }}" + "book_update",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'books_id':books_id,
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


            $(document).on("click",'.view_book', function (e) {
                e.preventDefault();
                var books_id=$(this).val();
                $('#viewBookModal').modal('show');
                var settings = {
                "url": "{{ env('APP_URL') }}" + "book_edit/"+books_id,
                "method": "GET",
                "timeout": 0,
            };

            $.ajax(settings).done(function (response) {
                        $('#BookViewModal').html("");
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
                                var book_cover = "{{ url('/public') }}" + "/" +response.data.cover
                                $('#BookViewModal').append('<div class="modal-body"> \
                                        <lable><h5>Title:</h5></lable>\
                                        <h5 class="text-primary mb-0">'+ response.data.title +'</h5>\
                                        <lable><h5>Pages:</h5></lable>\
                                        <h5 class="text-primary mb-0">'+ response.data.pages +'</h5>\
                                            <lable><h5>Book cover:</h5></lable>\
                                        <div class="image-box text-center mx-auto">\
                                            <img src="'+book_cover+'" class="img-fluid" width="80px" height="80px" id="cover_preview" alt="">\
                                            </div>\
                                        <lable><h5>Downloads:</h5></lable>\
                                        <span>'+ response.data.downloads+'</span>\
                                        <div><lable><h5>Status:</h5></lable>\
                                    <span class="dropdown ml-auto mt-1">' + statusHtml + '</span></div></div>');
                        }else{
                            toastr.success(response.message);
                        }
                    });
            });
            $(document).on('click','#edit_book',function(e){
                e.preventDefault();
                const formElement = document.getElementById('edit_book_form');
                const formData = new FormData(formElement);
                var settings = {
                "url": "{{ env('APP_URL') }}" + "book_edit_data",
                "method": "POST",
                "data": formData,
                "processData": false,
                "contentType": false,
             };

            $.ajax(settings).done(function (response) {
                console.log(response);
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

        $(document).on('click','.add_book',function(e){
                e.preventDefault();
                const formElement = document.getElementById('add_book_form');
                const formData = new FormData(formElement);
                var settings = {
                "url": "{{ env('APP_URL') }}" + "book_add_data",
                "method": "POST",
                "data": formData,
                "processData": false,
                "contentType": false,
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