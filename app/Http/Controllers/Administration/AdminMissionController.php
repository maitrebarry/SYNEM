<?php
namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminMissionController extends Controller
{
    public function edit() {
        return view('administration.pages/mission-edit');
    }
    public function updateMain(Request $request) {
        return back()->with('success_section', 'main');
    }
    public function updateImage(Request $request) {
        return back()->with('success_section', 'image');
    }
    public function updateDocuments(Request $request) {
        return back()->with('success_section', 'documents');
    }
    public function deleteImage() {
        return back()->with('success_section', 'image');
    }
    public function deleteDocument($id) {
        return back()->with('success_section', 'documents');
    }
}
