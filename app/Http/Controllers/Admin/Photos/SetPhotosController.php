<?php

namespace App\Http\Controllers\Admin\Photos;

use App\Http\Controllers\Controller;
use App\Models\SetPhotos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;

class SetPhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.photos.set_photos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $basePathDir = public_path(Env::get('BASE_PHOTOS_DIR').'/');
        $basePathDirSet = $basePathDir.Env::get('SET_PHOTOS_DIR').'/';

        if (file_exists($basePathDirSet)) {
            File::cleanDirectory($basePathDirSet);
        }
        DB::statement('truncate table set_photos');

        $photos  = DB::table('photos')
                        ->inRandomOrder()
                        ->take(Env::get('SIZE_SET_PHOTOS'))
                        ->get();

        $manager = new ImageManager(array('driver' => 'gd')); // Вместо "imagick" должно быть прописано "gd"
        foreach ($photos as $photo) {
            //определяем имя файла и расширение
            $arrFile = explode('.', $photo->file_origin);
            $img = $manager->make($basePathDir.$photo->file_origin);

            //обработка фотографии для medium размера
            $imageNameMedium = md5(time().'medium'.$photo->origin_name_photo);
            $pathDirMedium = $this->getPathDir($imageNameMedium, $basePathDirSet);
            $fullPathFile = $basePathDirSet.$pathDirMedium.$imageNameMedium.'.'.$arrFile[1];
            $this->resizeAndSaveImg($fullPathFile, $img, Env::get('WIDTHMEDIUM'), Env::get('HEIGHTMEDIUM'));

            //обработка фотографии для little размера
            $imageNameLittle = md5(time().'little'.$photo->origin_name_photo);
            $pathDirLittle = $this->getPathDir($imageNameLittle, $basePathDirSet);
            $fullPathFile = $basePathDirSet.$pathDirLittle.$imageNameLittle.'.'.$arrFile[1];
            $this->resizeAndSaveImg($fullPathFile, $img, Env::get('WIDTHLITTLE'), Env::get('HEIGHTLITTLE'));

            $setPhotos = new SetPhotos;
            $setPhotos->file_origin = $photo->file_origin;
            $setPhotos->file_medium = $pathDirMedium.$imageNameMedium.'.'.$arrFile[1];
            $setPhotos->file_little = $pathDirLittle.$imageNameLittle.'.'.$arrFile[1];
            $setPhotos->like = $photo->like;
            $setPhotos->photos_id = $photo->id;
            $setPhotos->clients_id = 0;
            $setPhotos->categories_id = 0;
            $setPhotos->save();
        }

        $data = [
            'result' => 'Новый сет создан',
            'photos' => $photos,
            'basePathDir' => Env::get('BASE_PHOTOS_DIR').'/',
        ];

        return view('admin.photos.set_photos', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create a path to store the photo
     *
     * @param string $imageName
     * @param string $basePathDir
     * @return string
     */
    public function getPathDir($imageName, $basePathDir): string
    {
        $pathDir = '';
        $nesting = Env::get('NESTING'); //вложенность папок
        $arrChar = str_split($imageName, 2);
        $i = 0;
        foreach ($arrChar as $value){
            if (!file_exists($basePathDir.$pathDir)) {
                mkdir($basePathDir.$pathDir, 0777, true);
            }
            if ($i >= $nesting){
                break;
            }
            $pathDir .= $value.'/';
            $i++;
        }

        return $pathDir;
    }

    public function resizeAndSaveImg($fullPathFile, $img, $width, $height){

        // изменяем размер изображения так, чтобы большая сторона умещалась в пределах лимита чем меньше
        // сторона будет масштабирована, чтобы сохранить исходное соотношение сторон
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        //созроняем картинку
        $img->save($fullPathFile, 100);
    }
}
