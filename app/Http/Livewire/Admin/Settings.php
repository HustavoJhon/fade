<?php

namespace App\Http\Livewire\Admin;

use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Settings extends Component
{
    use WithFileUploads;

    public $business_name;
    public $business_address;
    public $business_phone;
    public $business_email;
    public $business_description;
    public $social_facebook;
    public $social_instagram;
    public $social_tiktok;
    public $social_twitter;
    public $monday_open;
    public $monday_close;
    public $tuesday_open;
    public $tuesday_close;
    public $wednesday_open;
    public $wednesday_close;
    public $thursday_open;
    public $thursday_close;
    public $friday_open;
    public $friday_close;
    public $saturday_open;
    public $saturday_close;
    public $sunday_open;
    public $sunday_close;
    public $logo;
    public $newLogo;

    protected function rules(): array
    {
        return [
            'business_name' => 'nullable|string|max:255',
            'business_address' => 'nullable|string|max:500',
            'business_phone' => 'nullable|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'business_description' => 'nullable|string|max:1000',
            'social_facebook' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_tiktok' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'monday_open' => 'nullable|date_format:H:i',
            'monday_close' => 'nullable|date_format:H:i',
            'tuesday_open' => 'nullable|date_format:H:i',
            'tuesday_close' => 'nullable|date_format:H:i',
            'wednesday_open' => 'nullable|date_format:H:i',
            'wednesday_close' => 'nullable|date_format:H:i',
            'thursday_open' => 'nullable|date_format:H:i',
            'thursday_close' => 'nullable|date_format:H:i',
            'friday_open' => 'nullable|date_format:H:i',
            'friday_close' => 'nullable|date_format:H:i',
            'saturday_open' => 'nullable|date_format:H:i',
            'saturday_close' => 'nullable|date_format:H:i',
            'sunday_open' => 'nullable|date_format:H:i',
            'sunday_close' => 'nullable|date_format:H:i',
            'newLogo' => 'nullable|image|max:2048',
        ];
    }

    public function mount(): void
    {
        $this->loadSettings();
    }

    private function loadSettings(): void
    {
        $settings = BusinessSetting::all()->keyBy('key');

        $this->business_name = $settings->get('business_name')?->value;
        $this->business_address = $settings->get('business_address')?->value;
        $this->business_phone = $settings->get('business_phone')?->value;
        $this->business_email = $settings->get('business_email')?->value;
        $this->business_description = $settings->get('business_description')?->value;
        $this->social_facebook = $settings->get('social_facebook')?->value;
        $this->social_instagram = $settings->get('social_instagram')?->value;
        $this->social_tiktok = $settings->get('social_tiktok')?->value;
        $this->social_twitter = $settings->get('social_twitter')?->value;

        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
            $this->{$day . '_open'} = $settings->get($day . '_open')?->value;
            $this->{$day . '_close'} = $settings->get($day . '_close')?->value;
        }

        $this->logo = $settings->get('logo')?->value;
    }

    public function update(): void
    {
        $this->validate();

        $fields = [
            'business_name', 'business_address', 'business_phone', 'business_email',
            'business_description', 'social_facebook', 'social_instagram', 'social_tiktok', 'social_twitter',
        ];

        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
            $fields[] = $day . '_open';
            $fields[] = $day . '_close';
        }

        foreach ($fields as $field) {
            if ($this->$field !== null) {
                BusinessSetting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $this->$field]
                );
            }
        }

        session()->flash('message', 'Configuración actualizada exitosamente.');
    }

    public function saveLogo(): void
    {
        $this->validate(['newLogo' => 'required|image|max:2048']);

        $path = $this->newLogo->store('settings', 'public');

        if ($this->logo) {
            Storage::disk('public')->delete($this->logo);
        }

        BusinessSetting::updateOrCreate(
            ['key' => 'logo'],
            ['value' => $path]
        );

        $this->logo = $path;
        $this->newLogo = null;

        session()->flash('message', 'Logo actualizado exitosamente.');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
