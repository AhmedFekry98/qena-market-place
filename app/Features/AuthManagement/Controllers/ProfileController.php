<?php

namespace App\Features\AuthManagement\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Features\AuthManagement\Transformers\ProfileResource;
use App\Features\SystemManagements\Models\User;

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
}
