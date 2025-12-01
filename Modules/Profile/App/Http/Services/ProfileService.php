<?php

namespace Modules\Profile\App\Http\Services;

use App\Constants\PermissionName;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Resident\App\Models\Resident;
use Yajra\DataTables\Facades\DataTables;

class ProfileService
{

    public function update(User $user, $data)
    {
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }

        DB::beginTransaction();
        try {
            $user->update($data);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
