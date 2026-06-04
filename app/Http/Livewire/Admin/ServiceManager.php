<?php

namespace App\Http\Livewire\Admin;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class ServiceManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public ?string $categoryFilter = null;
    public ?int $editingServiceId = null;

    public $category_id;
    public $name;
    public $description;
    public $price;
    public $duration;
    public $image;
    public $is_active = true;
    public $newImage;

    protected function rules(): array
    {
        return [
            'category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:5',
            'newImage' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ];
    }

    public function getCategoriesProperty()
    {
        return ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();
    }

    public function index(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetInputFields();
        $this->editingServiceId = null;
        $this->dispatch('show-service-modal');
    }

    public function store(): void
    {
        $this->validate();

        $imagePath = null;
        if ($this->newImage) {
            $imagePath = $this->newImage->store('services', 'public');
        }

        Service::create([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
            'image' => $imagePath,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Servicio creado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function edit(int $id): void
    {
        $service = Service::findOrFail($id);
        $this->editingServiceId = $id;
        $this->category_id = $service->category_id;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->price = $service->price;
        $this->duration = $service->duration;
        $this->image = $service->image;
        $this->is_active = $service->is_active;
        $this->newImage = null;

        $this->dispatch('show-service-modal');
    }

    public function update(): void
    {
        $this->validate();

        $service = Service::findOrFail($this->editingServiceId);

        $data = [
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
            'is_active' => $this->is_active,
        ];

        if ($this->newImage) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $this->newImage->store('services', 'public');
        }

        $service->update($data);

        session()->flash('message', 'Servicio actualizado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetInputFields();
    }

    public function destroy(int $id): void
    {
        $service = Service::findOrFail($id);
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();
        session()->flash('message', 'Servicio eliminado exitosamente.');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toggleActive(int $id): void
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => !$service->is_active]);
        session()->flash('message', 'Estado del servicio actualizado.');
    }

    private function resetInputFields(): void
    {
        $this->category_id = null;
        $this->name = null;
        $this->description = null;
        $this->price = null;
        $this->duration = null;
        $this->image = null;
        $this->newImage = null;
        $this->is_active = true;
    }

    public function render()
    {
        $query = Service::with('category');

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        return view('livewire.admin.service-manager', [
            'services' => $query->orderBy('id', 'desc')->paginate(15),
        ]);
    }
}
