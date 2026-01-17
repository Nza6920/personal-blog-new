<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $topics = $request->user()->topics()->latest('id')->with(['user'])->paginate(15);
        return view('admin.index', ['user' => $request->user(), 'topics' => $topics ]);
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }

    public function create(Topic $topic)
    {
        return view('admin.create_and_edit', ['topic' => $topic]);
    }

    public function store(TopicRequest $request, Topic $topic,ImageUploadHandler $uploader)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        if ($request->background) {
            $result = $uploader->save($request->background, 'background', $topic->id);
            if ($result) {
                $topic->background = $result['path'];
            }
        }
        $topic->save();
        return redirect()->route('admin.show')->with('message', '创建成功');
    }

    // 上传图片
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];

        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }

    // 编辑帖子
    public function edit(Topic $topic)
    {
        return view('admin.create_and_edit', ['topic' => $topic]);
    }

    // 更新帖子
    public function update(TopicRequest $request,Topic $topic,ImageUploadHandler $uploader)
    {
        $topic->fill($request->all());
        if ($request->background) {
            $result = $uploader->save($request->background, 'background', $topic->id);
            if ($result) {
                $topic->background = $result['path'];
            }
        }
        $topic->save();
    		return redirect()->route('admin.show')->with('success', '更新成功！');
    }
}
