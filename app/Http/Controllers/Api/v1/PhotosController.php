<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhotosStorRequest;
use App\Http\Resources\PhotosResource;
use App\Models\Photos;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
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
        return PhotosResource::collection(Photos::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PhotosStorRequest $request)
    {
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

            return response()->json(['success' => true, 'message' => 'Photo loaded!']);
        }catch (Exception $e){
            return response()->json(['success' => false, 'message' => 'Caught exception: '.$e->getMessage()]);
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
        return new PhotosResource(Photos::findOrFail($id));
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
        $photo = Photos::findOrFail($id);
        $photo->isDelete = 1;
        $photo->save();
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
}
