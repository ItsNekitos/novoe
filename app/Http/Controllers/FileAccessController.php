<?php

namespace App\Http\Controllers;

use App\Http\Requests\IfUserRequest;
use App\Http\Resources\SharedFilesResource;
use App\Http\Resources\UserInforResource;
use App\Models\File;
use App\Models\FileAccess;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileAccessController extends Controller
{

    public function addaccess($file_id, IfUserRequest $request)
    {
        $f = File::with("user")->where("file_id", $file_id)->first();
        if (!$f) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }

        if ($f->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
        $user = User::where("email", $request->email)->first();

        FileAccess::firstOrCreate(["user_id" => $user->id, "file_id" => $f->id]);

        $fa = FileAccess::with("file")->where("file_id", $f->id)->get();
        $res = UserInforResource::collection($fa)->collection;
        $res[] = ["fullname" => $f->user->last_name, "email" => $f->user->email, "type" => "author"];
        return $res;
    }


    public function removeaccess($file_id, IfUserRequest $request)
    {
        $f = File::with("user")->where("file_id", $file_id)->first();
        if (!$f) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }

        if ($f->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
        $user = User::where("email", $request->email)->first();

        FileAccess::where("user_id", $user->id)->where("file_id", $f->id)->delete();

        $fa = FileAccess::with("file")->where("file_id", $f->id)->get();
        $res = UserInforResource::collection($fa)->collection;
        $res[] = ["fullname" => $f->user->last_name, "email" => $f->user->email, "type" => "author"];
        return $res;
    }


    public function shared()
    {
        return SharedFilesResource::collection(FileAccess::with("file")->where("user_id", Auth::user()->id)->get())->collection;
    }
}
