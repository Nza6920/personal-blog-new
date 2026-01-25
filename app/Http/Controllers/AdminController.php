<?php

namespace App\Http\Controllers;

use App\Actions\Topics\CreateTopic;
use App\Actions\Topics\DeleteTopic;
use App\Actions\Topics\UpdateTopic;
use App\Actions\Users\UpdateUserPassword;
use App\Handlers\ImageUploadHandler;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $topicsQuery = $request->user()->topics()->latest('id')->with(['user']);

        if ($search !== '') {
            $topicsQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $topics = $topicsQuery->paginate(15);

        return view('admin.index', [
            'user' => $request->user(),
            'topics' => $topics,
            'search' => $search,
        ]);
    }

    public function profile(Request $request)
    {
        return view('admin.profile', ['user' => $request->user()]);
    }

    public function updatePassword(Request $request, UpdateUserPassword $updateUserPassword)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $updateUserPassword->handle($request->user(), $validated['password']);

        return back()->with('success', '密码已更新');
    }

    public function destroy(Topic $topic, DeleteTopic $deleteTopic)
    {
        $deleteTopic->handle($topic);
        session()->flash('success', '文章已成功删除！');
        return redirect()->back();
    }

    public function create(Topic $topic)
    {
        return view('admin.create_and_edit', ['topic' => $topic]);
    }

    public function store(TopicRequest $request, CreateTopic $createTopic, ImageUploadHandler $uploader)
    {
        $createTopic->handle(
            $request->user(),
            $request->only(['title', 'body', 'body_type']),
            $request->file('background'),
            $uploader
        );

        return redirect()->route('admin.show')->with('message', '创建成功');
    }

    // 涓婁紶鍥剧墖
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 鍒濆鍖栬繑鍥炴暟鎹紝榛樿鏄け璐ョ殑
        $data = [
            'success'   => false,
            'msg'       => '上传失败！',
            'file_path' => ''
        ];

        $file = $request->file('upload_file');
        if ($file && $file->isValid()) {
            $result = $uploader->save($file, 'topics', Auth::id(), 1024);
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功！";
                $data['success']   = true;
            }
        }
        return $data;
    }

    // 缂栬緫甯栧瓙
    public function edit(Topic $topic)
    {
        return view('admin.create_and_edit', ['topic' => $topic]);
    }

    // 鏇存柊甯栧瓙
    public function update(TopicRequest $request, Topic $topic, UpdateTopic $updateTopic, ImageUploadHandler $uploader)
    {
        $updateTopic->handle(
            $topic,
            $request->only(['title', 'body', 'body_type']),
            $request->file('background'),
            $uploader
        );
        return redirect()->route('admin.show')->with('success', '更新成功！');
    }
}


