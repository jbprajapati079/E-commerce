<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Contact::orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('brand.delete', $row->id);
                    return '
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" id="delete">Delete</button>
                ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.contact.index');
    }

    public function delete($id)
    {
        try {
            $data = Contact::findOrFail($id)->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Contact deleted successfully!',
                'redirect' => route('admin.contact.index')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
