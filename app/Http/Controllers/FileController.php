<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StoreFolderRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FileResource;



class FileController extends Controller
{
    //
    public function myFiles(string $folder = null)
    {
        // dd($folder); 
        if($folder) {
            $folder = File::query()->where('created_by', Auth::id())
            ->where('path', $folder)
            ->firstOrFail();
        }
        if(!$folder){
            $folder = $this->getRoot();
        }

        $files = File::query()
        ->where('parent_id', $folder->id)
        ->where('created_by', Auth::id())
        ->orderBy('is_folder', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $files = FileResource::collection($files);

        $ancestors = FileResource::collection([...$folder->ancestors, $folder]);

        $folder = new FileResource($folder);
        return Inertia::render('MyFiles', compact('folder', 'files', 'ancestors'));
    }
    
    public function createFolder( StoreFolderRequest $request)
    {
        $data = $request->validated();
        $parent = $request->parent;

        if(!$parent) {
            $parent = $this->getRoot();

        }

        $file = new File();
        
        $file->is_folder = 1;
        $file->name = $data['name'];

        $parent->appendNode($file);
        $file->created_by = Auth::id();
    }

    public function store(StoreFileRequest $request)
    {
        $data = $request->validated();
        $parent = $request->parent;
        $user = $request->id;
        $fileTree = $request->file_tree;
        
        if($parent){
            $parent = $this->getRoot();
        }

        if(!empty($fileTree)){
            $this->saveFileTree($fileTree, $parent, $user);
        }
        else{
            
        }
        
    }
    
    private function getRoot(): File
    {
        return File::query()->whereIsRoot()->where('created_by', Auth::id())->firstOrFail();
    }
}
