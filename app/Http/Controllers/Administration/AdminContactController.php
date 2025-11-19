<?php
namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactCarousel;
use App\Models\ContactInfo;
use App\Models\ContactHour;
use App\Models\ContactFaq;
use Illuminate\Support\Facades\Storage;

class AdminContactController extends Controller
{
    public function edit()
    {
        $carousels = ContactCarousel::orderBy('ordering')->get();
        $infos = ContactInfo::where('type', '!=', 'map')->orderBy('ordering')->get();
        $hours = ContactHour::orderBy('ordering')->get();
        $faqs = ContactFaq::orderBy('ordering')->get();
        $map = ContactInfo::where('type', 'map')->first();
        return view('administration.pages.contact-edit', compact('carousels', 'infos', 'hours', 'faqs', 'map'));
    }

    // Carousel CRUD
    public function storeCarousel(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
        ]);

        $data = $request->only('title', 'caption');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            Storage::disk('public')->putFileAs('contact/carousel', $file, $name);
            $data['image'] = $name;
        }

        // set ordering to last
        $last = ContactCarousel::max('ordering') ?? 0;
        $data['ordering'] = $last + 1;

        ContactCarousel::create($data);

        return back()->with('success_section', 'carousel');
    }

    public function updateCarousel(Request $request, $id)
    {
        $carousel = ContactCarousel::findOrFail($id);
        $request->validate([
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'image' => 'nullable|image|max:10240',
        ]);

        $carousel->title = $request->input('title');
        $carousel->caption = $request->input('caption');
        if ($request->hasFile('image')) {
            // delete old
            if ($carousel->image && Storage::disk('public')->exists('contact/carousel/' . $carousel->image)) {
                Storage::disk('public')->delete('contact/carousel/' . $carousel->image);
            }
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            Storage::disk('public')->putFileAs('contact/carousel', $file, $name);
            $carousel->image = $name;
        }
        $carousel->save();

        return back()->with('success_section', 'carousel');
    }

    public function deleteCarousel($id)
    {
        $carousel = ContactCarousel::findOrFail($id);
        if ($carousel->image && Storage::disk('public')->exists('contact/carousel/' . $carousel->image)) {
            Storage::disk('public')->delete('contact/carousel/' . $carousel->image);
        }
        $carousel->delete();
        return response()->json(['success' => true]);
    }

    public function reorderCarousels(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            ContactCarousel::where('id', $id)->update(['ordering' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    // Contact infos (address/phone/email entries)
    public function storeInfo(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'label' => 'nullable|string|max:255',
            'value' => 'required|string',
        ]);
        $last = ContactInfo::max('ordering') ?? 0;
        ContactInfo::create(array_merge($request->only('type','label','value'), ['ordering' => $last + 1]));
        return response()->json(['success' => true]);
    }

    public function updateInfo(Request $request, $id)
    {
        $info = ContactInfo::findOrFail($id);
        $request->validate(['label' => 'nullable|string|max:255','value'=>'required|string']);
        $info->update($request->only('label','value'));
        return response()->json(['success' => true]);
    }

    public function deleteInfo($id)
    {
        ContactInfo::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function reorderInfos(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            ContactInfo::where('id', $id)->update(['ordering' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    // Hours CRUD
    public function storeHour(Request $request)
    {
        $request->validate(['day'=>'required|string','open'=>'nullable','close'=>'nullable','closed'=>'nullable|boolean']);
        $last = ContactHour::max('ordering') ?? 0;
        ContactHour::create(['day'=>$request->day,'open'=>$request->open,'close'=>$request->close,'closed'=>($request->closed?1:0),'ordering'=>$last+1]);
        return response()->json(['success' => true]);
    }

    public function updateHour(Request $request, $id)
    {
        $h = ContactHour::findOrFail($id);
        $h->update(['day'=>$request->day,'open'=>$request->open,'close'=>$request->close,'closed'=>($request->closed?1:0)]);
        return response()->json(['success' => true]);
    }

    public function deleteHour($id)
    {
        ContactHour::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function reorderHours(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            ContactHour::where('id', $id)->update(['ordering' => $index + 1]);
        }
        return response()->json(['success'=>true]);
    }

    // FAQ CRUD
    public function storeFaq(Request $request)
    {
        $request->validate(['question'=>'required|string','answer'=>'required|string']);
        $last = ContactFaq::max('ordering') ?? 0;
        ContactFaq::create(['question'=>$request->question,'answer'=>$request->answer,'ordering'=>$last+1]);
        return response()->json(['success' => true]);
    }

    public function updateFaq(Request $request, $id)
    {
        $f = ContactFaq::findOrFail($id);
        $f->update($request->only('question','answer'));
        return response()->json(['success' => true]);
    }

    public function deleteFaq($id)
    {
        ContactFaq::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function reorderFaqs(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            ContactFaq::where('id', $id)->update(['ordering' => $index + 1]);
        }
        return response()->json(['success'=>true]);
    }

    // Map: store iframe or coords as a special contact_info record type=map
    public function updateMap(Request $request)
    {
        $request->validate(['value' => 'nullable|string']);
        $map = ContactInfo::firstOrNew(['type'=>'map']);
        $map->value = $request->input('value');
        $map->label = 'map';
        $map->save();
        return response()->json(['success' => true]);
    }

    public function showCarousel($id)
    {
        $c = ContactCarousel::findOrFail($id);
        return response()->json($c);
    }
}
