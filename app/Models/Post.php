<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'name',
        'body',
        'author_id',
    ];

    public static function getTextAttribute($value)
    {
        return new HtmlString(
            app(Parsedown::class)->setSafeMode(true)->text($text)
        );
    }
    
    public function creator(){
        return $this->belongsTo(User::class,'author_id')->withDefault();
    }

    public function tags(){
        return $this->belongsToMany(Hub::class, 'post_hubs', 'posts_id', 'hub_id');
    }

    public function views(){
        return $this->hasMany(PostView::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(){
        return $this->hasMany(PostVote::class);
    }

    public function postFollowers(){
        return $this->belongsToMany(User::class, 'post_favorites', 'post_id', 'follower_id');
    }

    public function postFollowings(){
        return $this->belongsToMany(User::class, 'post_favorites', 'follower_id', 'post_id');
    }

    public function postIsFollowing(User $user){
        return !! $this->postFollowers()->where('follower_id', $user->id)->count();
    }

    public function postIsVoted(User $user){
        if (!! $this->votes()->where('user_id', $user->id)->where('status','0')->count()) {
            return 'downvoted';
        } else if (!! $this->votes()->where('user_id', $user->id)->where('status', '1')->count()){
            return 'upvoted';
        } 
    }

    public function getHubsIdsAttribute()
    {
        return $this->tags()->pluck('hub_id')->toArray();
    }
}
