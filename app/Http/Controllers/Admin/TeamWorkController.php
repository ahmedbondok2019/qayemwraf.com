<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\helper\HelperController;
use App\Http\Livewire\Dashboard\Admin\TeamWorks;
use App\Http\Requests\team_work\CreateTeamWorkRequest;
use App\Http\Requests\team_work\UpdateTeamWorkRequest;
use App\Models\TeamWork;
use App\Models\TeamWorkImage;
use App\Models\TeamWorkTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TeamWorkController extends BackendController
{
    public function index(Request $request)
    {
        if (! in_array('142', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = [];

        return view('dashboard.admin.team_work.index', $data);
    }

    public function create()
    {
        if (! in_array('143', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = [];

        return view('dashboard.admin.team_work.create', $data);
    }

    public function addTrans(Request $request)
    {
        if (! in_array('143', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $test = TeamWorkTranslation::where('team_work_id', $request->team_work_id)
            ->where('lang_id', app()->getLocale())->first();
        if (isset($test)) {
            alert()->error(trans_db('dashboard.Duplicate_TitleOrLanguage'), trans_db('dashboard.attention'));

            return redirect('/admin-2023/team_work/edit/'.$request->team_work_id);
        }

        $data['title'] = trans_db('dashboard.CreateNewteam_worktrans');
        $data['id'] = $request->team_work_id;

        return view('dashboard.admin.team_work.trans', $data);
    }

    public function edit(Request $request)
    {
        if (! in_array('144', Session::get('permissionData'))) {
            return redirect()->back();
        }

        $data['details'] = TeamWork::find($request->id);
        if ($data['details'] == null) {
            return redirect('/admin-2023/team_work/all');
        }

        $data['id'] = $request->id;
        $data['team_work'] = TeamWork::all();

        return view('dashboard.admin.team_work.edit', $data);
    }

    public function store(CreateTeamWorkRequest $request)
    {
        if (! in_array('143', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $data = self::storeTeamWork($request);
        if ($data['status'] == true) {
            alert()->success($data['message'], trans_db('dashboard.congratulation'));

            return redirect(LaravelLocalization::localizeUrl('/admin-2023/team_work/all'));
        } else {
            alert()->error($data['message'], trans_db('dashboard.attention'));

            return redirect(LaravelLocalization::localizeUrl('/admin-2023/team_work/addteam_work'));
        }
    }

    public function update(UpdateTeamWorkRequest $request)
    {
        if (! in_array('144', Session::get('permissionData'))) {
            return redirect()->back();
        }
        // dd($request->selected_team_work_categories);
        $data = self::updateteam_work($request);

        if ($data == true) {
            alert()->success(trans_db('dashboard.saved'), trans_db('dashboard.congratulation'));
        } else {
            alert()->error(trans_db('dashboard.notsaved'), trans_db('dashboard.attention'));
        }

        return redirect('admin-2023/team_work/all');
    }

    public static function storeTeamWork(Request $request, $type = null)
    {
        if ($type == null) {
            $test = TeamWorkTranslation::where('title', $request->title)->first();
            if (! empty($test)) {
                return ['status' => false, 'message' => trans_db('dashboard.notsaved')];
            }
            $CreateTeamWork = TeamWork::create(self::team_workData($request));
        } else {
            $CreateTeamWork = TeamWork::where('id', $request->id)->first();
        }

        // if ($request->primary_image == null && isset($CreateTeamWork->translations) && $CreateTeamWork->translations->primary_image == null) {
        //     return ['status' => false , 'message' => trans_db('dashboard.Image_required')];
        // }
        $data = self::allUpload($request);
        $CreateTrans = TeamWorkTranslation::create([
            'title' => strip_tags($request->title),
            'idea' => $request->idea,
            'posts' => $request->posts,
            'sponsored' => $request->sponsored,
            'result' => $request->result,
            'report' => $request->report,
            'primary_image' => $request->has('primary_image') ? $data[0] : $CreateTeamWork->primary_image,
            'video_link' => $request->video_link,
            'video_file' => ! empty($request->video_file) ? $data[2] : $CreateTeamWork->video_file,
            'team_work_id' => $CreateTeamWork->id,
            'lang_id' => app()->getLocale(),
        ]);

        if ($CreateTrans) {
            TeamWorkImage::where('team_work_id', $request->random_id)
                ->update(['team_work_id' => $CreateTeamWork->id]);

            return ['status' => true, 'message' => trans_db('dashboard.saved')];
        }

        return ['status' => false, 'message' => trans_db('dashboard.notsaved')];
    }

    public static function updateteam_work(UpdateTeamWorkRequest $request)
    {
        $testDublicate = TeamWorkTranslation::where('title', $request->title)
            ->where('team_work_id', '!=', $request->id)->first();
        if (! empty($testDublicate)) {
            session()->flash('msg', 'this title already taken..');

            return redirect()->back();
        }
        $team_work = TeamWorks::find($request->id);
        $team_work->update(self::team_workData($request, $team_work));

        $team_workTranslation = TeamWorkTranslation::where('team_work_id', $request->id)
            ->where('lang_id', app()->getLocale())->first();

        $data = self::allUpload($request);

        $team_workTranslation->update([
            'lang_id' => app()->getLocale(),
            'views' => 0,
            'title' => strip_tags($request->title),
            'idea' => $request->idea,
            'posts' => $request->posts,
            'sponsored' => $request->sponsored,
            'result' => $request->result,
            'report' => $request->report,
            'primary_image' => $request->has('primary_image') ? $data[0] : $team_workTranslation->primary_image,
            'video_link' => $request->video_link,
            'video_file' => ! empty($request->video_file) ? $data[2] : $team_workTranslation->video_file,
            'team_work_id' => $team_work->id,
        ]);

        if ($request->has('image')) {
            self::images(
                $request->image,
                strip_tags($request->title),
                $request->id,
                $team_workTranslation->id,
                app()->getLocale()
            );
        }

        return true;
    }

    public function delete(Request $request)
    {
        if (! in_array('145', Session::get('permissionData'))) {
            return redirect()->back();
        }
        TeamWork::active()->where('id', $request->id)->delete();

        alert()->success(trans_db('dashboard.deleted'), trans_db('dashboard.deleted'));

        return redirect('admin-2023/team_work/all');
    }

    public function delete_image(Request $request)
    {
        if (! in_array('44', Session::get('permissionData'))) {
            return redirect()->back();
        }
        $request->id != null ? $id = $request->random_id : $id = $request->random_id;
        if ($request->id !== null || $request->id != '') {
            $data = TeamWorkImage::where('id', $request->id)->first();
        } else {
            $data = TeamWorkImage::query();
            $file_ext = ['image/png', 'image/jpg', 'image/jpeg'];
            $extension = strtolower(File::mimeType(public_path('website/images/team_work/'.$request->file_name)));
            if (isset($request->file_name) && in_array($extension, $file_ext)) {
                $data = $data->where('image', str_replace(' ', '', $request->file_name));
            }
            $data = $data->where('team_work_id', $id)->first();
        }

        if ($data) {

            if (file_exists(public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.$data->image))) {
                unlink('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.$data->image);
            }
            $data->delete();

            alert()->success(trans_db('dashboard.Deleted Successfully..'), trans_db('dashboard.congratulation'));
        } else {
            alert()->error(trans_db('dashboard.delete error'), trans_db('dashboard.attention'));
        }
        if (request()->ajax()) {
            return response()->json(['status' => $data != null ? true : false]);
        }

        return redirect()->back();
    }

    public static function allUpload($request)
    {
        $ds = DIRECTORY_SEPARATOR;
        $primary_image = '';
        $pdf_file = '';
        $video_file = '';

        if ($request->has('primary_image')) {
            $primary_image = HelperController::make_slug($request->title).rand(10, 100).'.jpg';

            $path = public_path('website'.$ds.'images'.$ds.'team_work');
            $destination = public_path('website'.$ds.'images'.$ds.'team_work'.$ds.$primary_image);
            helperController::upload_images($path, $destination, Input::file('primary_image'), null, null, null);

            $path = public_path('website'.$ds.'images'.$ds.'team_work'.$ds.'thumb');
            $destination = public_path('website'.$ds.'images'.$ds.'team_work'.$ds.'thumb'.$ds.$primary_image);
            HelperController::upload_images($path, $destination, Input::file('primary_image'), null, null);
        }

        if (! empty($request->pdf_file)) {
            $pdf_file = HelperController::make_slug($request->title).'.pdf';
            $request->file('pdf_file')->move(public_path('website/uploads/pdf/'), $pdf_file);
        }

        if (! empty($request->video_file)) {
            $video_file = HelperController::make_slug($request->title).'.mp4';
            $request->file('video_file')->move(public_path('website/uploads/videos/'), $video_file);
        }

        return [$primary_image, $pdf_file, $video_file];
    }

    public static function images($images, $team_work_price, $team_workId, $transId, $lang_id)
    {
        if (! empty($images)) {
            foreach ($images as $image) {
                $imageSlug = HelperController::make_slug($team_work_price.rand(10, 100).'_'.str_replace(' ', '', Carbon::today()));
                $image_name = str_replace(' ', '', $imageSlug).'.jpg';

                TeamWorkImage::create([
                    'image' => $image_name,
                    'team_work_id' => $team_workId,
                    'translation_id' => $transId,
                    'lang_id' => $lang_id,
                ]);

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $image, '1000', '1000');

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.'thumb');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $image, '250', '250');
            }
        } else {
            return false;
        }
    }

    public static function team_workData(Request $request)
    {
        $data = self::allUpload($request);
        $data = [
            'lang_id' => app()->getLocale(),
            'views' => 0,
        ];

        return $data;
    }

    public function readFiles(Request $request)
    {
        $images = TeamWorkImage::where('team_work_id', $request->id)->get();
        $directory = 'website/images/team_work';
        $files_info = [];
        $file_ext = ['image/png', 'image/jpg', 'image/jpeg'];

        foreach ($images as $files) {
            if (file_exists(public_path('website/images/team_work/'.$files->image))) {
                if (file_get_contents('https://souqelmlabes.com/website/images/team_work/'.$files->image)) {
                    $extension = strtolower(File::mimeType(public_path('website/images/team_work/'.$files->image)));

                    if (in_array($extension, $file_ext)) { // Check file extension
                        $filename = File::name(public_path('website/images/team_work/'.$files->image));
                        $size = File::size(public_path('website/images/team_work/'.$files->image)); // Bytes
                        $sizeinMB = round($size / (1000 * 1024), 2); // MB

                        if ($sizeinMB <= 2) { // Check file size is <= 2 MB
                            $files_info[] = [
                                'id' => $files->id,
                                'name' => $filename,
                                'size' => $size,
                                'path' => 'data:'.$extension.';base64,'.base64_encode(file_get_contents('https://souqelmlabes.com/website/images/team_work/'.$files->image)),
                            ];
                        }
                    } else {
                        $files_info[] = $extension;
                    }
                }
            }
        }

        return response()->json($files_info);
    }

    public static function uploadImages(Request $request)
    {
        if (is_array($request->file)) {
            foreach ($request->file as $file) {
                $name = $file->getClientOriginalName();
                $imageSlug = HelperController::make_slug($name.rand(10, 100).'_'.str_replace(' ', '', Carbon::today()));
                $image_name = str_replace(' ', '', $imageSlug).'.jpg';

                $team_workId = $request->random_id;

                $data = [
                    // 'image' => $image_name,
                    'image' => str_replace(' ', '', $name),
                    'team_work_id' => $team_workId,
                    'translation_id' => $team_workId,
                    'lang_id' => app()->getLocale(),
                ];

                $test = TeamWorkImage::where($data)->exists();
                if ($test == false) {
                    TeamWorkImage::create($data);

                    $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work');
                    $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.str_replace(' ', '', $name));
                    HelperController::upload_images($path, $destination, $file, null, null);

                    $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.'thumb');
                    $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.str_replace(' ', '', $name));
                    HelperController::upload_images($path, $destination, $request->file('file'), null, null);
                }
            }
        } else {
            $name = $request->file('file')->getClientOriginalName();
            $imageSlug = HelperController::make_slug($name.rand(10, 100).'_'.str_replace(' ', '', Carbon::today()));
            $image_name = str_replace(' ', '', $imageSlug).'.jpg';

            $team_workId = $request->random_id;

            $data = [
                'image' => $image_name,
                'team_work_id' => $team_workId,
                'translation_id' => $team_workId,
                'lang_id' => app()->getLocale(),
            ];

            $test = TeamWorkImage::where($data)->exists();
            if ($test == false) {
                TeamWorkImage::create($data);

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $request->file('file'), null, null);

                $path = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.'thumb');
                $destination = public_path('website'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'team_work'.DIRECTORY_SEPARATOR.'thumb'.DIRECTORY_SEPARATOR.$image_name);
                HelperController::upload_images($path, $destination, $request->file('file'), null, null);
            }
        }

        return 'done';
    }
}
