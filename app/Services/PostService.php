<?php
namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\MediaService;
use Illuminate\Http\UploadedFile;

class PostService
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function getPosts(array $filters = [])
    {
        $user = Auth::user();

        if ($user && $user->is_admin) { 
            // Kalau ada kolom penanda admin di tabel users
            $query = Post::with(['user', 'category', 'tags', 'media']);
        } else if ($user) {
            // Filter berdasarkan instansi_id user
            $query = Post::with(['user', 'category', 'tags', 'media'])
                ->where('instansi_id', $user->instansi_id);
                // ->orWhereNull('instansi_id');
        } else {
            $query = Post::with(['user', 'category', 'tags', 'media']);
        }
        // Apply filters
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['selected_categories_type'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('type', ($filters['selected_categories_type'] ?? 'post'));
            });
        }
        if (!empty($filters['tags'])) {
            $tags = is_array($filters['tags']) ? $filters['tags'] : [$filters['tags']];
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        }

        // Sorting
        $sortField = $filters['sort'] ?? 'created_at';
        $sortDirection = $filters['direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $filters['per_page'] ?? 10;
        // pd($filters, false);
        // pd($query->getBindings(), false);
        // pd($query->toSql());
        return $query->paginate($perPage);
    }

    public function getPublicPosts($category = null, array $filters = [])
    {
        $query = Post::where('status', 'published')->with('user', 'category', 'tags');
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }
        if (!empty($filters['tags'])) {
            $tags = is_array($filters['tags']) ? $filters['tags'] : [$filters['tags']];
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        }

        if (!empty($filters['selected_categories_type'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('type', ($filters['selected_categories_type'] ?? 'post'));
            });
        }
        return $query->latest()->paginate(10);
    }

    public function store(array $data)
    {
        // pd($data);
        DB::beginTransaction();
        try {
            $category = Category::where('name', $data['category_id'])->firstOrFail();

            $slg = Str::slug($data['title']);
            $existingCount = Post::where('slug', $slg)->count();
            if ($existingCount > 0) {
                $slg .= '-' . ($existingCount + 1);
            }

            $postData = [
                'type' => $data['type'] ?? (($category->type == 'post') ? 'article' : $category->type),
                'title' => $data['title'],
                'slug' => $slg,
                'content' => $data['content'],
                'user_id' => $data['user_id'] ?? Auth::id(),
                'category_id' => $category->id,
                'status' => $data['status'],
                'instansi_id' => $data['instansi_id'] ?? Auth::user()->instansi_id ?? null,
                'pos_pantau_id' =>  $data['pos_pantau_id'] ?? null,
                'views' => $data['views'] ?? 0,
            ];

            $post = Post::create($postData);

            if (!empty($data['tags'])) {
                // $tags = collect($data['tags'])->flatten()->filter()->all();
                // $post->tags()->sync($tags);
                $tags = collect($data['tags'])->map(function ($tagName) {
                    return \App\Models\Tag::firstOrCreate(['name' => $tagName])->id;
                });

                $post->tags()->sync($tags);

            }

            if (!empty($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
                $this->mediaService->attachMedia(
                    $post, 
                    $data['featured_image'], 
                    'featured_image', 
                    'media'
                );
            }

            if (!empty($data['fileUploads'])) {
                $files = is_array($data['fileUploads']) ? $data['fileUploads'] : [$data['fileUploads']];
                $collectionName = $data['collection_name'] ?? 'fileUploads';
                foreach ($files as $file) {
                    if ($file instanceof UploadedFile) {
                        $this->mediaService->attachMedia(
                            $post, 
                            $file, 
                            $collectionName, 
                            'media'
                        );
                    }
                }
            }

            DB::commit();
            return $post;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Post $post, array $data)
    {
        DB::beginTransaction();
        try {
            $category = Category::where('name', $data['category_id'])->firstOrFail();

            $postData = [
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'content' => $data['content'],
                'category_id' => $category->id,
                'status' => $data['status'],
                'instansi_id' => $data['instansi_id'] ?? $post->instansi_id,
                'pos_pantau_id' =>  $data['pos_pantau_id'] ?? $post->pos_pantau_id,
            ];

            $post->fill($postData);

            if ($post->isDirty()) {
                $post->save();
            } else {
                throw new \Exception('Data tidak berubah. Mungkin isinya sama seperti sebelumnya.');
            }

            if (!empty($data['tags'])) {
                $tags = collect($data['tags'])
                    ->flatten()
                    ->filter()
                    ->map(function ($tagName) {
                        return \App\Models\Tag::firstOrCreate(['name' => $tagName])->id;
                    })
                    ->all();

                $post->tags()->sync($tags);
            }
            
            if (!empty($data['featured_image'])) {
                $this->mediaService->attachMedia($post, $data['featured_image'], 'featured_image', 'media', true);
            }

            if (!empty($data['fileUploads'])) {
                $files = is_array($data['fileUploads']) ? $data['fileUploads'] : [$data['fileUploads']];
                $collectionName = $data['collection_name'] ?? 'fileUploads';
                foreach ($files as $file) {
                    if ($file instanceof UploadedFile) {
                        $this->mediaService->attachMedia(
                            $post, 
                            $file, 
                            $collectionName, 
                            'media'
                        );
                    }
                }
            }

            DB::commit();
            return $post;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Post $post)
    {
        $post->delete();
        return true;
    }

    public function bulkAction($selectedPosts, $action)
    {
        if (empty($selectedPosts) || empty($action)) {
            return ['status' => 'error', 'message' => 'Please select posts and action.'];
        }
        switch ($action) {
            case 'publish':
                Post::whereIn('id', $selectedPosts)->update(['status' => 'published']);
                return ['status' => 'success', 'message' => 'Posts published successfully.'];
            case 'draft':
                Post::whereIn('id', $selectedPosts)->update(['status' => 'draft']);
                return ['status' => 'success', 'message' => 'Posts set as draft successfully.'];
            case 'delete':
                Post::whereIn('id', $selectedPosts)->delete();
                return ['status' => 'success', 'message' => 'Posts deleted successfully.'];
        }
        return ['status' => 'error', 'message' => 'Invalid action.'];
    }

    public function getPublicPostDetail($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'published')->with('user', 'category', 'tags')->firstOrFail();
        $popularPosts = Post::where('status', 'published')->with('user', 'category', 'tags')->latest()->take(5)->get();
        $post->increment('views');
        return [$post, $popularPosts];
    }

    public function getPostBySlug($slug)
    {
        try {
            $query = Post::with(['user', 'category', 'tags', 'media'])
                ->where('slug', $slug);

            $post = $query->first();

            return $post;
        } catch (\Throwable $th) {
            \Log::error('Error in getPostBySlug: ' . $th->getMessage());
            return null;
        }
    }

    public function getPostById($id)
    {
        try {
            $query = Post::with(['user', 'category', 'tags', 'media'])
                ->where('id', $id);

            $post = $query->first();

            return $post;
        } catch (\Throwable $th) {
            \Log::error('Error in getPostById: ' . $th->getMessage());
            return null;
        }
    }
}
