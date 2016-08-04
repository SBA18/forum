<?php

namespace Forum\Http\Controllers\Forum;

use Forum\Events\Forum\Section\SectionWasEdited;
use Forum\Http\Controllers\Controller;
use Forum\Http\Requests\Forum\Section\EditSectionFormRequest;
use Forum\Models\Section;

class EditSectionController extends Controller
{
    /**
     * Get the view to edit an existing section.
     *
     * @param int                  $id
     * @param Forum\Models\Section $section
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, Section $section)
    {
        $section = $section->findOrFail($id);

        return view('forum.section.edit')
            ->with('section', $section);
    }

    /**
     * Post section edit.
     *
     * @param int                  $id
     * @param Forum\Models\Section $section
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, EditSectionFormRequest $request, Section $section)
    {
        $section = $section->findOrFail($id);

        $section->update([
            'name'        => $request->input('name'),
            'slug'        => str_slug($request->input('name')),
            'description' => $request->input('description'),
        ]);

        event(new SectionWasEdited($section, $request->user()));

        notify()->flash('Success', 'success', [
            'text'  => 'Section has been updated.',
            'timer' => 2000,
        ]);

        return redirect()->route('home');
    }
}
