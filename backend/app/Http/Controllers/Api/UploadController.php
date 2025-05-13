<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Upload an image file
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|image|max:5120', // 5MB max
            ]);

            if (!$request->hasFile('file')) {
                return response()->json([
                    'message' => 'No file uploaded or file field missing'
                ], 400);
            }
            
            $file = $request->file('file');
            
            if (!$file->isValid()) {
                return response()->json([
                    'message' => 'Invalid file upload: ' . $file->getErrorMessage()
                ], 400);
            }
            
            $extension = $file->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;
            
            // Store in the public disk under uploads/images folder
            $path = $file->storeAs('uploads/images', $filename, 'public');
            
            if (!$path) {
                return response()->json([
                    'message' => 'Failed to store the file'
                ], 500);
            }
            
            // Return the full URL to the uploaded file
            $url = asset('storage/' . $path);
            
            return response()->json([
                'url' => $url,
                'path' => $path,
            ]);
        } catch (\Exception $e) {
            Log::error('File upload error: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error uploading file: ' . $e->getMessage()
            ], 500);
        }
    }
} 