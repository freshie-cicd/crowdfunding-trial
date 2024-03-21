<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\ExpenseHead;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::all();
        return view('administrator.expense.index', compact(['expenses']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $heads = ExpenseHead::all();


        return view('administrator.expense.create', compact(['heads']));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense = new Expense;

        $expense['head'] = $request->head;
        $expense['amount'] = $request->amount;
        $expense['submitted_by'] = $request->submitted_by;
        $expense['memo'] = $request->memo;
        $expense['date'] = $request->date;
        $expense['is_approved'] = $request->is_approved;
        $expense['approved_by'] = $request->approved_by;
        $expense['type'] = $request->type;
        $expense['asset_id'] = $request->asset_id;
        $expense['note'] = $request->note;

        $expense->save();

        return redirect()->back()->with('success', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $heads = ExpenseHead::all();
      $data = Expense::where('id', $id)->get();

      return view('administrator.expense.edit', compact(['heads', 'data']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }



    public function head_index(){

      $expenseheads = ExpenseHead::all();

      return view('administrator.expense_head.index', compact(['expenseheads']));
    }


    public function head_create(){

      $expenseheads = ExpenseHead::all();

      return view('administrator.expense_head.create', compact(['expenseheads']));

    }


    public function head_store(Request $request){
        $head = new ExpenseHead;

        $head['parent'] = $request->parent_id;
        $head['name'] = $request->name;
        $head['status'] = $request->status;
        $head['note'] = $request->note;

        $head->save();

        return redirect()->back()->with('success', 'Added Successfully');
    }

    public function head_edit($id){
        $data = ExpenseHead::where('id', $id)->get();
        $expenseheads = ExpenseHead::all();

        return view('administrator.expense_head.edit', compact(['data', 'expenseheads']));
    }


    public function head_update(Request $request){
      $head = array();

      $head['parent'] = $request->parent_id;
      $head['name'] = $request->name;
      $head['status'] = $request->status;
      $head['note'] = $request->note;

      ExpenseHead::where('id', $request->id)->update($head);

      return redirect('administrator/expense-heads')->with('success', 'Edited Successfully');

    }

    public function head_destroy($id){

      ExpenseHead::where('id', $id)->delete();
      return redirect('administrator/expense-heads')->with('success', 'Deleted Successfully');

    }

}
