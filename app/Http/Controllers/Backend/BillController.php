<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\eBillRequest;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BillService;
use Illuminate\Support\Facades\Mail;


class BillController extends Controller
{
    protected $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    public function index(Request $request)
    {
        $this->checkAuthorization(auth()->user(), ['bills.view']);
        $bills = $this->billService->getBillsWithFilter($request->search);
        return view('backend.pages.bill.index', compact('bills'));
    }

    public function create()
    {
        $this->checkAuthorization(auth()->user(), ['bills.create']);
        $users = User::select('id', 'email')->get();
        return view('backend.pages.bill.create', compact('users'));
    }

    public function store(eBillRequest $request)
    {
        $this->checkAuthorization(auth()->user(), ['bills.create']);
        $sendNow = $request->has('save_and_send');
        $this->billService->createBill($request->all(), $sendNow);

        return redirect()->route('admin.bills.index')->with('success', 'Bill created successfully.');
    }

    public function edit($id)
    {
        $this->checkAuthorization(auth()->user(), ['bills.edit']);
        $bill = Bill::findOrFail($id);
        $users = User::select('id', 'email')->get();
        return view('backend.pages.bill.edit', compact('bill', 'users'));
    }

    public function update(eBillRequest $request, $id)
    {
        $this->checkAuthorization(auth()->user(), ['bills.edit']);
        $bill = Bill::findOrFail($id);
        $sendNow = $request->has('save_and_send');

        $this->billService->updateBill($bill, $request->all(), $sendNow);

        return redirect()->route('admin.bills.index')->with('success', 'Bill updated successfully.');
    }

    public function destroy($id)
    {
        $this->checkAuthorization(auth()->user(), ['bills.delete']);
        $bill = Bill::findOrFail($id);

        Payment::where('bill_id', $bill->id)->delete();

        $bill->delete();

        return redirect()->back()->with('success', 'Bill deleted successfully.');
    }

    public function sendEmail($id)
    {
        $this->checkAuthorization(auth()->user(), ['bills.view']);
        $bill = Bill::findOrFail($id);
        Mail::to($bill->user->email)->send(new \App\Mail\BillMail($bill));

        return back()->with('success', 'Email sent successfully to ' . $bill->user->email);
    }
}
