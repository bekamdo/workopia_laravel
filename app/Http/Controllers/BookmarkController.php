<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Job;

class BookmarkController extends Controller
{
    //@desc get all user bookmarks
    //route  GET/bookmarks
    public function index():View{
        $user = Auth::user();
        $bookmarks = $user -> bookmarkedJobs()-> orderBy('job_user_bookmarks.created_at','desc')  -> paginate(9);

        return view('jobs.bookmarked') -> with('bookmarks',$bookmarks);

    }

     //@desc Create a new  bookmarks
    //route  Post/bookmarks
    public function store(Job $job):RedirectResponse{
        $user = Auth::user();
        
        //check if the job is already bookmarked
        if($user -> bookmarkedJobs() -> where('job_id',$job->id) -> exists()){
            return back()->with('error','Job is already Bookmarked');
        }
        //create a new bookmark
        $user ->bookmarkedJobs() -> attach($job->id);
        return back()-> with('success','Job bookmarked succesfully');

    }

    //@desc Remove bookmarked Job
    //route  Delete/bookmarks
    public function destroy(Job $job):RedirectResponse{
        $user = Auth::user();
        
        //check if the job is not bookmarked
        if(!$user -> bookmarkedJobs() -> where('job_id',$job->id) -> exists()){
            return back()->with('error','Job is not Bookmarked');
        }
        //remove new bookmark
        $user ->bookmarkedJobs() ->  detach($job -> id);
        return back()-> with('success','Bookmarked removed succesfully');

    }

}
