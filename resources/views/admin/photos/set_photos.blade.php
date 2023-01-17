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
            <form action="{{route('createSetPhotos')}}">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <input type="submit" value="Создать новый сет">
                                <h1>{{isset($result) ? $result : ''}}</h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if(isset($photos))
                                        @foreach($photos as $photo)
                                            <div class="col-sm-2">
                                                <a href="https://via.placeholder.com/1200/FFFFFF.png?text=1" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">
                                                    <img src="{{$basePathDir.$photo->file_origin}}" class="img-fluid mb-2" alt="white sample"/>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="col-sm-2">
                                        <a href="https://via.placeholder.com/1200/FFFFFF.png?text=1" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">
                                            <img src="https://via.placeholder.com/300/FFFFFF?text=1" class="img-fluid mb-2" alt="white sample"/>
                                        </a>
                                    </div>
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
