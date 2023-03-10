<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'feature_image',
        'user_id'
    ];

    public static function boot(){
        parent::boot();
        static::creating(function($post){
            $post->user_id = auth()->user()?auth()->user()->id:null;
        });
    }

    public function scopeMyPost($query)
    {
        $user = auth()->user();
        $user_id = blank($user)?0:$user->id;
        return $query->where('user_id','=',$user_id);
    }

    /**
     * Get the user that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the comments for the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getCommentCountAttribute() {
        return $this->comments()->count();
    }

    public function getIsEditableAttribute(){
        $user = auth()->user();
        if(blank($user)){
            return false;
        }else{
            return $user->id == $this->user_id;
        }
    }

    public function getImageLinkAttribute(){
        // Storage::setVisibility($this->feature_image, 'public');
        // return Storage::disk('public')->url($this->feature_image);
        return url($this->feature_image);
    }
}
