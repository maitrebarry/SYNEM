<?php
namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function edit() {
        return view('administration.pages/contact-edit');
    }
    public function updateInfos(Request $request) {
        return back()->with('success_section', 'infos');
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
