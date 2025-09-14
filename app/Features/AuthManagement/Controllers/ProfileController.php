<?php

namespace App\Features\AuthManagement\Controllers;

use App\Features\AuthManagement\Transformers\ProfileCollection;
use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Features\AuthManagement\Transformers\ProfileResource;
use App\Features\SystemManagements\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ApiResponses;

    public function show()
    {
        $user = Auth::user();

        return $this->okResponse(
            ProfileResource::make($user),
            "Success api call"
        );
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $userId = Auth::user()->id;

        $user = User::find($userId);

        if(!$user){
            return $this->badResponse('user not found');
        }

        // update user

        $user->update($validated);

        // update image
        if($request->has('image')){
            $user->Media()->delete();
            $user->addMediaFromRequest('image')->toMediaCollection('user-image');
        }


        return $this->okResponse(
            ProfileResource::make($user),
            "Success api call"
        );
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        if(!$user){
            return $this->badResponse('user not found');
        }
        // check is customer
        if($user->role != 'customer'){
            return $this->badResponse('you are not allowed to delete this user');
        }

        $user->delete();

        return $this->okResponse(null, "Success api call");
    }

    public function updateStudentCode(Request $request)
    {
        $valide = $request->validate([
            'teacher_code' => 'required|required',
        ]);

        $teacher = User::where('teacher_code', $valide['teacher_code'])->first();
        if (!$teacher) {
            return $this->badResponse(
                message: 'Teacher not found'
            );
        }
        $student = auth()->user();
        $student->teacher_id = $teacher->id;
        $student->save();

        return $this->okResponse(
            ProfileResource::make($student),
            "Success api call"
        );
    }

    public function registerAgent(Request $request)
    {
        try {
            DB::beginTransaction();
            $valide = $request->validate([
                'name' => 'required|string|max:255',
                "phone_code" => "required|string|max:255",
                "phone" => "required|string|max:255",
            ]);

            $data = [
                'name' => $valide['name'],
                'password' => Hash::make('Aa@261298'),
                'phone_code' => $valide['phone_code'],
                'phone' => $valide['phone'],
                "role" => "agent"
            ];
            $agent = User::create($data);

            // assign role
            $agent->assignRole('agent');

            DB::commit();
            return $this->okResponse(
                ProfileResource::make($agent),
                "Success api call"
            );
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->badResponse(
                message: $th->getMessage()
            );
        }
    }

    public function agents(Request $request)
    {
        $isPaginate = request('page') ;
        $agents = User::where('role', 'agent');

        $agents = $isPaginate ?
         $agents->paginate($request->get('per_page', 15))
          : $agents->get();

        return $this->okResponse(
            $isPaginate ?
            ProfileCollection::make($agents) :
            ProfileResource::collection($agents),
            "Success api call"
        );
    }
}
