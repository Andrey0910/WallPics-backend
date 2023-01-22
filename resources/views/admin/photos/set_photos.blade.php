@extends('layouts.admin_layout')

@section('title', 'Сет фотографий')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Сет фотографий</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{route('storeSetPhotos')}}">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <input type="submit" value="Создать новый сет">
                                <h1>@isset($result) {{$result}} @endisset</h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @isset($setPhotos)
                                        @foreach($setPhotos as $photo)
                                            <div class="col-sm-2">
                                                <a href="{{$photosDir.$photo->file_origin}}" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery" target="_blank">
                                                    <img src="{{$setPhotosDir.$photo->file_little}}" class="img-fluid mb-2" alt="white sample"/>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
