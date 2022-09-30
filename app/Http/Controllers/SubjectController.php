<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Subject::class);
        return view('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|unique:subjects,name',
        ]);

        Subject::create([
            'name' => $request->subject,
            'is_active' => $request->is_active,
        ]);
        alert()->success('موضوع با موفقیت ایجاد گردید');
        return redirect()->route('admin.index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $this->authorize('update', $subject);
        return view('subject.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'subject' => 'required',
        ]);

        $subject->update([
            'name' => $request->subject,
            'is_active' => $request->is_active,
        ]);
        alert()->success('موضوع با موفقیت ویرایش گردید');
        return redirect()->route('admin.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        try {
            DB::beginTransaction();
            $subject->delete();
            foreach ($subject->tickets as $ticket) {
                $ticket->update([
                    'deleted_at' => Carbon::now(),
                ]);
                foreach ($ticket->responses as $response) {
                    $response->update([
                        'deleted_at' => Carbon::now(),
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            alert()->warning('موضوع و تیکت ها و پاسخ ها حذف نگردید');
            return redirect()->route('admin.index');
        }

        alert()->success('موضوع و تیکت ها و پاسخ های مرتبط با آن حذف گردید');
        return redirect()->route('admin.index');
    }
}
