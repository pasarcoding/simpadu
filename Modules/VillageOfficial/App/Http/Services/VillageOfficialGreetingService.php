<?php

namespace Modules\VillageOfficial\App\Http\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Information\App\Models\Information;
use Modules\VillageOfficial\App\Models\VillageOfficialGreeting;
use Yajra\DataTables\Facades\DataTables;

class VillageOfficialGreetingService
{
    public function get()
    {
        return VillageOfficialGreeting::firstOrNew([]);
    }

    public function update($data)
    {
        $greeting = $this->get();

        $oldImage = [
            'image' => $greeting->exists() ? $greeting->getRawOriginal('image') : null,
            'sign_image' => $greeting->exists() ? $greeting->getRawOriginal('sign_image') : null,
        ];
        $newImage = [];

        if (isset($data['image']) && $data['image']->isValid()) {
            $newImage['image'] = $data['image']->store('village_official/greeting', 'public');
            $data['image'] = $newImage['image'];
        }

        if (isset($data['sign_image']) && $data['sign_image']->isValid()) {
            $newImage['sign_image'] = $data['sign_image']->store('village_official/greeting', 'public');
            $data['sign_image'] = $newImage['sign_image'];
        }

        DB::beginTransaction();
        try {
            $greeting->fill($data);
            $greeting->save();

            foreach ($newImage as $field => $path) {
                if (isset($oldImage[$field]) && $oldImage[$field]) {
                    Storage::disk('public')->delete($oldImage[$field]);
                }
            }

            DB::commit();
            return $greeting;
        } catch (Exception $e) {
            DB::rollBack();

            foreach ($newImage as $field => $path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }
    }

    public function destroy()
    {
        $greeting = $this->get();

        $image = [
            'image' => $greeting->exists() ? $greeting->getRawOriginal('image') : null,
            'sign_image' => $greeting->exists() ? $greeting->getRawOriginal('sign_image') : null,
        ];

        DB::beginTransaction();
        try {
            $delete = $greeting->delete();

            foreach ($image as $field => $path) {
                if ($delete && $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            DB::commit();
            return $delete;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
