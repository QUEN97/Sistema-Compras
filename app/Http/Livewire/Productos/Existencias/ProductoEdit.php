<?php

namespace App\Http\Livewire\Productos\Existencias;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Livewire\WithFileUploads;

class ProductoEdit extends Component
{
    use WithFileUploads;

    public $EditProducto, $photo, $urlImage;
    public $producto_id, $name, $imagen, $categoria, $unidad, $precio, $stock, $status;

    public $productosUpdate;

    public function mount()
    {
        $this->EditProducto = false;
        $this->productosUpdate=[];
    }

    public function confirmProductoEdit(int $id)
    {
        $producto = Producto::where('id', $id)->first();

        $this->producto_id = $id;
        $this->name = $producto->name;
        $this->photo = $producto->product_photo_path;
        $this->categoria = $producto->categoria_id;
        $this->unidad = $producto->unidad;
        $this->precio = $producto->precio;
        $this->stock = $producto->stock;
        $this->status = $producto->status;

        $this->EditProducto = true;
        $arrayID=[];
        $zonasArray=DB::table('producto_zona')->select('zona_id')->where('producto_id',$id)->get(); 
        foreach($zonasArray as $zona){
           
           $arrayID[]=$zona->zona_id;
       } 
       
       $this->productosUpdate=$arrayID;
    }

    public function EditarProducto($id)
    {
        $producto = Producto::where('id', $id)->first();

        $this->validate([
            'categoria' => ['required', 'not_in:0'],
            'name' => ['required', 'max:250'],
            'unidad' => ['required', 'string', 'max:30', 'regex:/[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/'],
            'precio' => ['required', 'min:0'],
            'stock' => ['required',  'min:0'],
            'status' => ['required', 'not_in:0'],
            'imagen' => ['nullable', 'image', 'max:1024'],
        ],
        [
            'name.required' => 'El Nombre del Producto es oblogatorio',
            'name.max' => 'El Nombre del Producto no debe ser mayor a 250 caracteres',
            'categoria.required' => 'La Categoria es oblogatoria',
            'unidad.required' => 'La Unidad es oblogatoria',
            'unidad.max' => 'La Unidad no debe ser mayor a 30 caracteres',
            'unidad.string' => 'La Unidad debe ser solo Texto',
            'precio.required' => 'El Precio es oblogatorio',
            'precio.min' => 'El Precio debe ser mayor a 0',
            'stock.required' => 'El Stock es oblogatorio',
            'stock.min' => 'El Stock debe ser mayor a 0',
            'status.required' => 'El Status es obligatorio',
            'imagen.image' => 'Debe ser un formato de imagen valido (.jpg .jpeg .png .webp)',
            'imagen.max' => 'La Imagen no debe ser mayor a 1 MB'
        ]);

        if ($this->imagen != null) {

            $this->urlImage = $this->imagen->store('product-photos', 'public');

            $producto->forceFill([
                'name' => $this->name,
                'product_photo_path' => $this->urlImage,
                'categoria_id' => $this->categoria,
                'precio' => $this->precio,
                'unidad' => $this->unidad,
                'stock' => $this->stock,
                'status' => $this->status,
            ])->save();
        } else {
            $producto->forceFill([
                'name' => $this->name,
                'categoria_id' => $this->categoria,
                'precio' => $this->precio,
                'unidad' => $this->unidad,
                'stock' => $this->stock,
                'status' => $this->status,
            ])->save();
        }

        $this->EditProducto = false;

        if (isset($producto->zonas)){
            $producto->zonas()->sync($this->productosUpdate);
            }else{
                $producto->zonas()->sync(array());
            }

            Alert::success('Producto Actualizado', "El Producto". ' '.$this->name. ' '. "ha sido actualizado en el sistema");

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
        $categorias = Categoria::all();
        $zonass = Zona::all();
        return view('livewire.productos.existencias.producto-edit', compact('categorias','zonass'));
    }
}
