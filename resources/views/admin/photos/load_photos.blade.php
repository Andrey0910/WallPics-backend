@extends('layouts.admin_layout')

@section('title', 'Загрузка файлов')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Загрузка фотографий</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="dropzone">
                <form action="{{ route('dropzoneFileUpload') }}" class="dropzone" method="post" id="file-upload" enctype="multipart/form-data">
                    @csrf
                    <div class="dz-message">
                        Drag and Drop Single/Multiple Files Here<br>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
