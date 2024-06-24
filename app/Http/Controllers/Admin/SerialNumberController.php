<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\SerialNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SerialNumberController extends Controller
{
    public function index(Request $request)
    {
        $search_query = $request->get("search_query");
        $numbers = SerialNumber::search($search_query)->with('item')->latest()->paginate($request->get('size', 10));

        return view('admin.serial_numbers.index', [
            'numbers' => $numbers,
        ]);
    }

    public function show(SerialNumber $serial_number)
    {

        return view('admin.serial_numbers.show', [
            'number' => $serial_number,
        ]);
    }


    public function create()
    {

        $items = Item::latest()->get();

        return view('admin.serial_numbers.create', [
            'items' => $items
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_numbers' => ['required', 'string'],
            'product' => ['required', 'string'],
            'warranty_end_date' => ['required', 'string', 'max:190'],
            'purchase_date' => ['nullable', 'string', 'max:190'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $warrantyEndDate = Carbon::createFromFormat('d F Y', $request->warranty_end_date)->format('Y-m-d');
        $purchaseDate = !is_null($request->purchase_date) ? Carbon::createFromFormat('d F Y', $request->purchase_date)->format('Y-m-d') : null;



        $preg_split = preg_split('/\r\n|[\r\n]/', $request->serial_numbers);
        $implode = implode(', ', $preg_split);
        //$explode = explode(', ', $implode);






        $serialNumber = new SerialNumber();
        $serialNumber->serial_numbers = $implode;
        $serialNumber->item_id = $request->product;
        $serialNumber->warranty_end_date = $warrantyEndDate;
        $serialNumber->purchase_date = $purchaseDate;
        $serialNumber->notes = $request->notes;
        $serialNumber->save();


        return back()->with('success', 'Serial number has been saved.');
    }


    public function edit(SerialNumber $serial_number)
    {

        $items = Item::latest()->get();
        $number = $serial_number;

        return view('admin.serial_numbers.edit', [
            'items' => $items,
            'number' => $number,
        ]);
    }


    public function update(Request $request, SerialNumber $serial_number)
    {
        $serialNumber = $serial_number;

        $request->validate([
            'serial_numbers' => ['required', 'string'],
            'product' => ['required', 'string'],
            'warranty_end_date' => ['required', 'string', 'max:190'],
            'purchase_date' => ['nullable', 'string', 'max:190'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $warrantyEndDate = Carbon::createFromFormat('d F Y', $request->warranty_end_date)->format('Y-m-d');
        $purchaseDate = !is_null($request->purchase_date) ? Carbon::createFromFormat('d F Y', $request->purchase_date)->format('Y-m-d') : null;

        $preg_split = preg_split('/\r\n|[\r\n]/', $request->serial_numbers);
        $implode = implode(', ', $preg_split);


        $serialNumber->serial_numbers = $implode;
        $serialNumber->item_id = $request->product;
        $serialNumber->warranty_end_date = $warrantyEndDate;
        $serialNumber->purchase_date = $purchaseDate;
        $serialNumber->notes = $request->notes;
        $serialNumber->save();


        return back()->with('success', 'Serial number has been updated.');
    }

    public function destroy(Request $request, SerialNumber $serial_number)
    {
        $serial_number->delete();
        return back()->with('success', 'Serial number has been deleted.');
    }
}
