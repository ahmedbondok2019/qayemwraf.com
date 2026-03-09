<?php

namespace App\Http\Controllers;

use App\Http\Controllers\helper\HelperController;
use App\Http\Requests\home\ContactUsRequest;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BlogController extends WebController
{
    protected function verifyRecaptcha(Request $request)
    {
        if (! HelperController::verify($request->input('g-recaptcha-response'))) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['تحقق جوجل مطلوب'],
            ]);
        }
    }

    public function index(Request $request)
    {
        $data['blogs'] = Blog::whereHas('BlogTranslation')
            ->latest()
            ->paginate(4);

        $data['recent'] = Blog::whereHas('BlogTranslation')->limit(5)->latest()->get();
        $data['section'] = 'blogs';
        $data['image'] = 'blogs.jpg';

        return view('blog', $data);
    }

    public function details(Request $request)
    {
        $data['blogs'] = Blog::where('lang_id', app()->getLocale())
            ->whereHas('BlogTranslation', function ($query) {
                $query->where('lang_id', app()->getLocale());
            })->get();

        $output = preg_replace('/[^0-9]/', '', $request->id);
        $data['blog'] = Blog::where('id', $output)
            ->whereHas('BlogTranslation')
            ->firstOrFail();

        $data['recent'] = Blog::whereHas('BlogTranslation')->limit(5)->latest()->get();
        $data['section'] = 'blogs';
        if (isset($data['blog']->BlogTranslation)) {
            $data['blog']->BlogTranslation->update(['views' => $data['blog']->BlogTranslation->views + 1]);
        }

        return view('blog_details', $data);
    }

    public function addComment(ContactUsRequest $request)
    {
        //        $this->verifyRecaptcha($request);
        //        return $request->all();
        //        $validator = Validator::make($request->all(), [
        //            'comment_email' => 'required|email|max:255',
        // //            'comment_subject' => 'required|string|max:255',
        //            'comment_name' => 'required|string|max:255',
        //            'comment_txt' => 'required|string|max:10000',
        // //            'g_recaptcha_response' => 'required|recaptcha',
        //        ]);
        //
        //        if ($validator->fails()) {
        //            return response()->json(['result' => '<div class="alert alert-danger"><span>' . __('website.check all inputs.') . '</span></div>']);
        //        }

        $test = BlogComment::where('comment_email', $request->comment_email)
            ->where('comment_name', $request->comment_name)
            ->where('comment_txt', $request->comment_txt)
            ->first();
        if (empty($test)) {
            BlogComment::create([
                'comment_name' => $request->comment_name,
                'comment_email' => $request->comment_email,
                'comment_txt' => $request->comment_txt,
                'blog_id' => $request->blog_details_id,
                'lang_id' => app()->getLocale(),
                'status' => 1,
            ]);

            return response()->json(['result' => '<div class="alert alert-success"><span>'.__('website.your comment added successfully').'</span></div>']);
        } else {
            return response()->json(['result' => '<div class="alert alert-danger"><span>'.__('website.your comment sent already no need to send again.').'</span></div>']);
        }
    }

    public function search_blog(Request $request)
    {
        if (empty($request->keyword)) {
            return redirect(\LaravelLocalization::localizeUrl('/'));
        }
        $keyword = HelperController::make_slug($request->keyword);

        return redirect(\LaravelLocalization::localizeUrl('blog/search/'.$keyword));
    }

    public function blog_result(Request $request)
    {
        $data['all'] = $request->all();
        $keyword = str_replace('-', ' ', HelperController::make_slug($request->keyword));

        $data['blogs'] = Blog::whereHas('BlogTranslation', function ($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        })->paginate(10);

        $data['recent'] = Blog::whereHas('BlogTranslation')->limit(5)->get();
        $data['keyword'] = $request->keyword;

        $data['section'] = 'blogs';
        $data['image'] = 'blogs.jpg';

        return view('blog', $data);
    }

    public function tags(Request $request)
    {
        $tag = str_replace('-', ' ', $request->tags);
        $data['blogs'] = Blog::where('lang_id', app()->getLocale())
            ->with('BlogTranslation', function ($query) use ($tag) {
                $query->where('lang_id', app()->getLocale())->where('tags', 'like', '%'.$tag.'%');
            })
            ->with('BlogComments')
            ->paginate(10);

        $data['section'] = 'blogs';
        $data['image'] = 'blogs.jpg';

        //        $data['blogs']->withPath('blogs/tag/'.$request->tags);
        //        $data['blogs']->appends(['section' => 'blogs' , 'image' => 'blogs.jpg']);

        return view('templates.blog.index', $data);

    }
}
