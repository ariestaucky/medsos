<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Post;
use App\Image;
use App\Comment;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReport(Request $request)
    {
        // Create report
        $report = new Report;
        $report->reporter_id = auth()->user()->id;
        $report->reason = $request->input('reason');
        
        $post = Post::find($request->input('post_id'));
        $post->report()->save($report);
            
        return redirect()->back()->with('success', 'Poster reported');
    }

    public function imageReport(Request $request)
    {
        // Create report
        $report = new Report;
        $report->reporter_id = auth()->user()->id;
        $report->reason = $request->input('reason');
        
        $post = Image::find($request->input('post_id'));
        $post->report()->save($report);
            
        return redirect()->back()->with('success', 'Image reported');
    }

    public function commentReport(Request $request)
    {
        // Create report
        $report = new Report;
        $report->reporter_id = auth()->user()->id;
        $report->reason = $request->input('reason');
        
        $post = Comment::find($request->input('post_id'));
        $post->report()->save($report);
            
        return redirect()->back()->with('success', 'Comment reported');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
