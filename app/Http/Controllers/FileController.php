<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenameFileRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Resources\UserInforResource;
use App\Http\Resources\ViewFilesResource;
use App\Models\File;
use App\Models\FileAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileController extends Controller
{


    public function add(UploadFileRequest $request)
    {
        function newnamefile($name, $original, $num = 1)
        {
            if (file_exists("uploads/" . $name)) {
                $ext = explode(".", $name);
                $name = pathinfo($original, PATHINFO_FILENAME) . " ($num)" . "." . end($ext);
                return newnamefile($name, $original, $num + 1);
            }
            return $name;
        }
        $response = [];
        foreach ($request->file("files") as $file) {
            $name = $file->getClientOriginalName();
            $aviableext = ["doc", "pdf", "docx", "zip", "jpeg", "jpg", "png"];
            $ext = explode(".", $name);
            if (($file->getSize() / 1024 / 1024) > 2 || !in_array(end($ext), $aviableext)) {
                $response[] = (["success" => false, "message" => "File not loaded", "name" => $name]);
                continue;
            }

            $f = Storage::disk('public')->putFileAs($file, newnamefile($name, $name));
            $path = Storage::disk('public')->url($f);
            $uid = Str::ulid();
            File::create(["user_id" => Auth::user()->id, "name" => $f, "url" => $path, "file_id" => $uid]);
            $response[] = (["success" => true, "message" => "Success", "name" => $f, "url" => $path, "file_id" => $uid]);
        }

        return response($response);
    }


    public function rename(RenameFileRequest $request, $file_id)
    {
        $f = File::where("file_id", $file_id)->first();
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
        $f->update(["name" => $request->name]);
        return response(["success" => true, "message" => "Renamed"]);
    }

    public function delete($file_id)
    {
        $f = File::where("file_id", $file_id)->first();
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
        Storage::disk('public')->delete($f->name);
        $f->delete();
        return response(["success" => true, "message" => "File already deleted"]);
    }


    public function download($file_id)
    {
        $f = File::where("file_id", $file_id)->first();
        if (!$f) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
        $fa = FileAccess::where("user_id", Auth::user()->id)->where("file_id", $f->id)->first();
        if ($f->user_id == Auth::user()->id || $fa) {
            return Storage::disk('public')->download($f->name);
        }

        return response()->json([
            'message' => 'Forbidden for you'
        ], 403);
    }

    public function viewfiles()
    {
        $files = ViewFilesResource::collection(File::with("accesses")->whereHas('accesses', function ($q) {
            $q->where('user_id', '=', Auth::user()->id);
        })->orWhere("user_id", Auth::user()->id)->get())->collection;
        return $files;
    }
}
