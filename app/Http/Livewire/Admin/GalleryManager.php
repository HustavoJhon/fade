<?php

namespace App\Http\Livewire\Admin;

use App\Models\Barber;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class GalleryManager extends Component
{
    use WithPagination, WithFileUploads;

    public $barber_id;
    public $caption;
    public $image;
    public $is_active = true;

    protected function rules(): array
    {
        return [
            'barber_id' => 'nullable|exists:barbers,id',
            'caption' => 'nullable|string|max:500',
            'image' => 'required|image|max:5120',
            'is_active' => 'boolean',
        ];
    }

    public function getBarbersProperty()
    {
        return Barber::with('user')->where('is_active', true)->get();
    }

    public function upload(): void
    {
        $this->validate();

        $maxOrder = Gallery::max('sort_order') ?? 0;

        Gallery::create([
            'barber_id' => $this->barber_id,
            'image' => $this->image->store('gallery', 'public'),
            'caption' => $this->caption,
            'sort_order' => $maxOrder + 1,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Imagen subida exitosamente.');
        $this->reset(['image', 'caption', 'barber_id']);
        $this->is_active = true;
    }

    public function delete(int $id): void
    {
        $gallery = Gallery::findOrFail($id);
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();
        session()->flash('message', 'Imagen eliminada.');
    }

    public function reorder(array $order): void
    {
        foreach ($order as $item) {
            Gallery::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        $this->dispatch('reorder-complete');
    }

    public function render()
    {
        return view('livewire.admin.gallery-manager', [
            'galleryItems' => Gallery::with('barber.user')
                ->orderBy('sort_order')
                ->paginate(20),
        ]);
    }
}
