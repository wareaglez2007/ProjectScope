@extends('layouts.app')

@section('content')
    <div class="container" id="contnet-container">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-4 order-md-2 mb-4">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div>
                                    <h5 class="my-0">Employee image</h5>
                                    <small class="text-muted">Upload employee image</small>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <form action="" method="POST"
                                    enctype="multipart/form-data" id="upload_employee_photo">
                                    @csrf
                                    <div class="row">                                   
                                        <div class="col-md-12">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="upload" id="chosen_image">
                                                <label class="custom-file-label" for="customFile">Choose Employee Photo</label>
    
                                                
                                                <img src="" class="img-thumbnail"/>
                                            </div>
    
                                        </div>
                                    </div>
                                </form>
                            </li>
    
                           
    
    
                            <li class="list-group-item">
                                <a href="#" onclick="UpdateEmployee();"
                                    class="btn btn-success col-md-12">Create</a>
                            </li>
    
    
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <form id="edit_employee">
                            {{-- Employee basics --}}
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">First name <i class="bi bi-asterisk text-danger"
                                                style="font-size: 8px;vertical-align: top;"></i></label>
                                        <input type="text" name="fname" id="fname" class="form-control" placeholder=""
                                            aria-describedby="helpId" value="">
                                        <small id="helpId" class="text-muted">Employee first name</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Middle name</label>
                                        <input type="text" name="mname" id="mname" class="form-control" placeholder=""
                                            aria-describedby="helpId" value="">
                                        <small id="helpId" class="text-muted">Employee middle name</small>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Last name <i class="bi bi-asterisk text-danger"
                                                style="font-size: 8px;vertical-align: top;"></i></label>
                                        <input type="text" name="lname" id="lname" class="form-control" placeholder=""
                                            aria-describedby="helpId" value="">
                                        <small id="helpId" class="text-muted">Employee last name</small>
                                    </div>
                                </div>
    
                            </div>
    
                            
    
                            {{-- manager employee work history --}}
                            <div class="row">
    
                            </div>
                            {{-- employee work hours --}}
                        </form>
                    </div>
    
                </div>



            </div>
        </div>

    </div>
@endsection
