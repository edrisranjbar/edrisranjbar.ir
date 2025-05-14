<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connectors\SQLiteConnector;
use Illuminate\Database\SQLiteConnection;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

// Route::get('/import-sqlite-posts', function () {
//     try {
//         // Get the SQLite database path from the query parameter
//         $dbPath = request()->query('path');
//         $defaultCategoryId = request()->query('category_id', 1); // Default category ID if none provided
//         $overwrite = request()->query('overwrite', 'false') === 'true'; // Whether to overwrite existing posts
        
//         if (!$dbPath) {
//             return response()->json([
//                 'error' => 'Please provide a database path using the path query parameter'
//             ], 400);
//         }
        
//         // Validate category exists
//         $category = Category::find($defaultCategoryId);
//         if (!$category) {
//             return response()->json([
//                 'error' => 'Specified category ID does not exist'
//             ], 400);
//         }
        
//         // Check if the file exists
//         if (!file_exists($dbPath)) {
//             return response()->json([
//                 'error' => 'Database file not found at: ' . $dbPath
//             ], 404);
//         }
        
//         // Create a new SQLite connection
//         $config = [
//             'driver' => 'sqlite',
//             'database' => $dbPath,
//             'prefix' => '',
//             'foreign_key_constraints' => false,
//         ];
        
//         // Connect to the SQLite database
//         $connector = new SQLiteConnector();
//         $connection = new SQLiteConnection(
//             $connector->connect($config),
//             $dbPath,
//             $config['prefix'],
//             $config
//         );
        
//         // Get the posts from SQLite directly into the import process
//         $sqlitePosts = $connection->table('posts')->get();
        
//         $stats = [
//             'total' => count($sqlitePosts),
//             'imported' => 0,
//             'skipped' => 0,
//             'errors' => 0,
//             'error_messages' => [] // Simpler error tracking
//         ];
        
//         // Process each post
//         foreach ($sqlitePosts as $sqlitePost) {
//             try {
//                 // Fix UTF-8 encoding issues
//                 $title = mb_convert_encoding($sqlitePost->title, 'UTF-8', 'UTF-8');
//                 $content = mb_convert_encoding($sqlitePost->content, 'UTF-8', 'UTF-8');
//                 $slug = mb_convert_encoding($sqlitePost->slug, 'UTF-8', 'UTF-8');
                
//                 // Check if post with same slug already exists
//                 $existingPost = Post::where('slug', $slug)->first();
                
//                 if ($existingPost && !$overwrite) {
//                     $stats['skipped']++;
//                     continue;
//                 }
                
//                 // Extract a summary from the content
//                 $summary = '';
                
//                 // Try to extract first paragraph from HTML content
//                 if (preg_match('/<p>(.*?)<\/p>/s', $content, $matches)) {
//                     $summary = strip_tags($matches[1]);
//                     // Limit to 200 characters
//                     if (mb_strlen($summary) > 200) {
//                         $summary = mb_substr($summary, 0, 197) . '...';
//                     }
//                 } else {
//                     // If no paragraphs, just take first 200 chars of stripped content
//                     $plainText = strip_tags($content);
//                     $summary = mb_substr($plainText, 0, 197) . '...';
//                 }
                
//                 // Make sure summary is properly encoded
//                 $summary = mb_convert_encoding($summary, 'UTF-8', 'UTF-8');
                
//                 // Prepare the post data
//                 $postData = [
//                     'title' => $title,
//                     'slug' => $slug,
//                     'content' => $content,
//                     'summary' => $summary,
//                     'published' => $sqlitePost->status === 'published',
//                     'category_id' => $defaultCategoryId,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ];
                
//                 // If we have a created_at time in the SQLite data, use it for published_at
//                 if (isset($sqlitePost->created_at) && !empty($sqlitePost->created_at)) {
//                     try {
//                         $postData['published_at'] = Carbon::parse($sqlitePost->created_at);
//                     } catch (\Exception $e) {
//                         // If date parsing fails, use current time
//                         $postData['published_at'] = now();
//                     }
//                 } else {
//                     // Default to current time if no created_at is available
//                     $postData['published_at'] = now();
//                 }
                
//                 // Handle the featured image if exists
//                 if (isset($sqlitePost->thumbnail) && !empty($sqlitePost->thumbnail)) {
//                     $postData['featured_image'] = mb_convert_encoding($sqlitePost->thumbnail, 'UTF-8', 'UTF-8');
//                 }
                
//                 // Old timestamp handling - commented out in favor of using current time
//                 /*
//                 // Set timestamps if available in source
//                 if (isset($sqlitePost->created_at)) {
//                     $postData['created_at'] = Carbon::parse($sqlitePost->created_at);
//                 }
                
//                 if (isset($sqlitePost->updated_at)) {
//                     $postData['updated_at'] = Carbon::parse($sqlitePost->updated_at);
//                 }
//                 */
                
//                 if ($existingPost && $overwrite) {
//                     // Update existing post
//                     $existingPost->update($postData);
//                     $stats['imported']++;
//                 } else {
//                     // Create new post
//                     Post::create($postData);
//                     $stats['imported']++;
//                 }
//             } catch (\Exception $e) {
//                 $stats['errors']++;
//                 $stats['error_messages'][] = mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8');
//             }
//         }
        
//         // Simplify the response to avoid any encoding issues
//         return response()->json([
//             'success' => true,
//             'message' => "Processed {$stats['total']} posts: {$stats['imported']} imported, {$stats['skipped']} skipped, {$stats['errors']} errors",
//             'stats' => [
//                 'total' => $stats['total'],
//                 'imported' => $stats['imported'],
//                 'skipped' => $stats['skipped'],
//                 'errors' => $stats['errors']
//             ]
//         ]);
        
//     } catch (\Exception $e) {
//         return response()->json([
//             'error' => 'An error occurred: ' . mb_convert_encoding($e->getMessage(), 'UTF-8', 'UTF-8')
//         ], 500);
//     }
// });