<?php

namespace App\Http\Livewire\Productos\Existencias;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Zona;
use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;

class ProductoCreate extends Component
{
    use WithFileUploads;

    public $newgProducto,$showUnidad=false;
    public $categoria,  $imagen, $urlImage;
    public $name, $unidad, $precio, $stock, $unidadList=[];
    public $zonasp, $zonaspList;

    public function resetFilters()
    {
        $this->reset(['name', 'imagen', 'categoria',  'unidad', 'precio', 'stock']);
    }

    public function mount()
    {
        $this->zonasp = Zona::all();
        $this->resetFilters();

        $this->newgProducto = false;
    }

    public function showModalFormProducto(){
        
        $this->resetFilters();

        $this->newgProducto=true;
    }

    public function updatedCategoria($id){
        $category= Categoria::find($id);
        
        if($category->name == "Limpieza" || $category->name == "limpieza" || $category->name == "LIMPIEZA"){
            $this->unidadList=["Caja","Galon 4 lt","Kilos","Pieza","Rollo","Saco 10 kg"];
            $this->showUnidad=false;
        }
        elseif($category->name == "Papelería" || $category->name == "papeleria" || $category->name == "PAPELERIA"){
            $this->unidadList=["Caja","Paq. 2pzs","Paquete","Pieza"];
            $this->showUnidad=false;
        }
        elseif($category->name == "Tóner" || $category->name == "tóner" || $category->name == "TONER"){
            $this->unidadList=["Pieza"];
            $this->showUnidad=false;
        }
        elseif($category->name == "Pintura" || $category->name == "pintura" || $category->name == "PINTURA"){
            $this->unidadList=["Bote","Cubeta 19 lt","Kilos","Litro","Pieza","Galon 4 lt"];
            $this->showUnidad=false;
        }
        elseif($category->name == "Ferretería" || $category->name == "ferretería" || $category->name == "FERRETERIA"){
            $this->unidadList=["Pieza","Metro"];
            $this->showUnidad=false;
        }
        elseif($category->name == "Señalética" || $category->name == "señalética" || $category->name == "SEÑALETICA"){
            $this->unidadList=["Pieza"];
            $this->showUnidad=false;
        }
        elseif($category->name == "Mobiliario" || $category->name == "mobiliario" || $category->name == "MOBILIARIO"){
            $this->unidadList=["Pieza"];
            $this->showUnidad=false;
        }
        else{
            $this->unidad="";
            $this->showUnidad=true;
        }
    }

    public function addProducto()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:250'],
            'categoria' => ['required', 'not_in:0'],
            'unidad' => ['required', 'string', 'max:15'],
            
            'stock' => ['required', 'integer', 'numeric', 'min:0'],
            'imagen' => ['nullable', 'image', 'max:1024', 'mimetypes:image/png,image/jpg,image/jpeg,image/webp'],
        ],
        [
            'name.required' => 'El Nombre del Producto es oblogatorio',
            'name.max' => 'El Nombre del Producto no debe ser mayor a 250 caracteres',
            'categoria.required' => 'La Categoria es obligatorio',
            'unidad.required' => 'La Unidad es oblogatoria',
            'unidad.max' => 'La Unidad no debe ser mayor a 30 caracteres',
           
            'stock.required' => 'El Stock es oblogatorio',
            'stock.min' => 'El Stock debe ser mayor a 0',
            'stock.integer' => 'El Stock debe ser un número',
            'stock.numeric' => 'El Stock debe ser un número',
            'imagen.image' => 'Debe ser un formato de imagen valido (.jpg .jpeg .png .webp)',
            'imagen.max' => 'La Imagen no debe ser mayor a 1 MB'
        ]);

        if ($this->imagen != null) {

            $this->urlImage = $this->imagen->store('product-photos', 'public');

        $producto = Producto::create([
            'name' => $this->name,
            'product_photo_path' => $this->urlImage,
            'categoria_id' => $this->categoria,
            'unidad' => $this->unidad,
            
            'stock' => $this->stock,
        ]);

    } else {
        $producto = Producto::create([
            'name' => $this->name,
            'product_photo_path' => $this->urlImage,
            'categoria_id' => $this->categoria,
            'unidad' => $this->unidad,
            
            'stock' => $this->stock,
        ]);
    }

    $producto->zonas()->sync($this->zonaspList);
        $this->mount();

        Alert::success('Nuevo Producto', "El Producto". ' '.$this->name. ' '. "ha sido agregado al sistema");

        return redirect()->route('productos');
    }

    public function updatedImagen()
    {
        $this->validate( [
            'imagen' => ['nullable', 'image', 'max:1024'],
        ],
        [
            'imagen.image' => 'Debe ser un formato de imagen valido (.jpg .jpeg .png .webp)',
            'imagen.max' => 'La Imagen no debe ser mayor a 1 MB'
        ]);
    }

  
    public function render()
    {
        $categorias = Categoria::where('status','Activo')->get();
        return view('livewire.productos.existencias.producto-create', compact('categorias'));
    }
}
