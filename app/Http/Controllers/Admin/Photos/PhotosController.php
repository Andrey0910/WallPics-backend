<?php

namespace App\Http\Controllers\Admin\Photos;

use App\Http\Controllers\Controller;
use App\Models\Photos;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Exception;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.photos.load_photos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'image|mimes:jpeg,bmp,png,svg|max:'.Env::get('PHOTO_SIZE_MAX'),
        ]);

        $basePathDir = public_path(Env::get('BASE_PHOTOS_DIR').'/');
        $image = $request->file('file');
        $originalName = $image->getClientOriginalName();
        $fileExtension = $image->extension();
        $imageName = md5(time().$originalName);
        $pathDir = $this->getPathDir($imageName, $basePathDir);
        $imageFullName = $imageName.'.'.$fileExtension;
        try {
            $image->move($basePathDir . $pathDir, $imageFullName);
            $photos = new Photos();
            $photos->origin_name_photo = $originalName;
            $photos->md5_origin_photo = $imageName;
            $photos->file_origin = $pathDir . $imageFullName;
            $photos->clients_id = 0;
            $photos->categories_id = 0;
            $photos->save();

            return response()->json(['success' => $imageName]);
        }catch (Exception $e){
            return response()->json(['success' => 'Caught exception: '.$e->getMessage()]);
        }
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
            $pathDir .= $value.'/';
            $i++;
            if ($i >= $nesting){
                break;
            }
        }

        return $pathDir;
    }
}
