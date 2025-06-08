<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Repositories\Crud;
use App\Traits\General;
use App\Traits\ImageSaveTrait;
use App\Models\MainImage;
use App\Rules\LimitMainImage;

class MainImageController extends Controller
{
    use General, ImageSaveTrait;

    protected $model;
    public function __construct(MainImage $mainImage)
    {
        $this->model = new Crud($mainImage);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Todas las imágenes';
        $data['images'] = $this->model->getOrderById('DESC', 5);

        return view('admin.main_images.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Agregar Imagen';

        return view('admin.main_images.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image_url' => 'required|image|mimes:jpeg,png,jpg|dimensions:min_width=540,min_height=540',
            'image_url' => new LimitMainImage(),
            'redirect_url' => 'required|string|max:255',
        ], [
            'image_url.required' => 'La imagen es obligatoria.',
            'image_url.image' => 'El archivo debe ser una imagen.',
            'image_url.mimes' => 'La imagen debe estar en formato: jpeg, png o jpg.',
            'image_url.dimensions' => 'La imagen debe ser mínimo de 540 x 540.',
            'redirect_url.required' => 'La URL es obligatoria.',
            'redirect_url.max' => 'La URL no puede exceder los 255 caracteres.'
        ]);

        $data = [
            'image_url' => $request->image_url ? $this->saveImage('main_images', $request->image_url, null, null) : null,
            'redirect_url' => $request->redirect_url,
        ];

        $this->model->create($data);

        return $this->controlRedirection($request, 'admin.main-images', 'MainImage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $mainImage = $this->model->getRecordById($id);
        $this->deleteFile($mainImage->image_url); // delete file from server
        $mainImage->delete();

        $this->showToastrMessage('error', "La imagen a sido eliminada con éxito");
        return redirect()->back();
    }
}
