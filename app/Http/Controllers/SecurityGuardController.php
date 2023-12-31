<?php

namespace App\Http\Controllers;

use App\Models\LocationHistory;
use App\Models\SecurityGuard;
use App\Models\Student;
use App\Models\StudentViolation;
use App\Models\User;
use App\Models\Violation;
use App\Services\Utils\FileServiceInterface;
use App\Traits\ExceptionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Guard;

class SecurityGuardController extends Controller
{
    use ExceptionTrait;
    private $fileService;
    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }

    public function studentEntry(Request $request) {
        $fields = $request->validate([
            'user_id' => 'required|string',
            'nfc_id' => 'required|string',
        ]);
        $studentUser = User::where('id', $fields['user_id'])->where('nfc_id', $fields['nfc_id'])->with('role')->first();

        if(!$studentUser) {
            return $this->throwException("NFC ID Mismatch. Please contact the IT Support", 401);
        }
        $student = Student::where('user_id', $studentUser->id)->first();
        $guard = SecurityGuard::where('user_id', auth()->user()->id)->with('location')->first();
        $student->location_id = $guard->location_id;
        $student->save();

        LocationHistory::create([
            'location_id' => $guard->location_id,
            'user_id' => $student->id,
        ]);

        $violation = StudentViolation::where('status', 'violated')->where('violator_id', $studentUser->id)->get();
        $studentUser->user_image = $this->fileService->download($studentUser->user_image, $studentUser->id);
        $studentUser->user_signature = $this->fileService->download($studentUser->user_signature, $studentUser->id);
        return response(['security-guard' => $guard, 'student' => $student, 'student_user' => $studentUser, 'violations' => $violation], 200);
    }

    public function violationList(){
        return Violation::all();
    }
    public function addViolation(Request $request) {
        $fields = $request->validate([
            'violation_id' => 'required|string',
            'violator_id' => 'required|string',
            'guard_id' => 'required|string',
            'note' => 'string',
        ]);

        $violation = StudentViolation::create([
            'violation_id' => $fields['violation_id'],
            'violator_id' => $fields['violator_id'],
            'guard_id' => $fields['guard_id'],
            'status' => 'violated',
            'note' => $fields['note'],
        ]);

        return $violation;
    }

    public function update(Request $request) {
        $fields = $request->validate([
            'location_id' => 'requited|string'
        ]);
        $securityGuard = SecurityGuard::where('user_id', Auth::user()->id)->first();
        $securityGuard->location_id = $fields['location_id'];
        $securityGuard->save();
        return $securityGuard;
    }
}
