<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Expense;
use App\Models\Estimates;
use App\Models\EstimatesAdd;
use App\Models\EstimateDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;

class SalesController extends Controller
{
    /** page estimates */

public function estimatesIndex()
{
    // Fetch only the estimates that belong to the logged-in user
    $userId = Auth::id(); // Get the ID of the currently logged-in user
    
    $estimates = DB::table('estimates')
        ->where('user_id', $userId) // Filter to only include estimates from the logged-in user
        ->get();

    $estimatesJoin = DB::table('estimates')
        ->join('estimates_adds', 'estimates.estimate_number', '=', 'estimates_adds.estimate_number')
        ->where('estimates.user_id', $userId) // Filter to only include estimates from the logged-in user
        ->select('estimates.*', 'estimates_adds.*')
        ->get();

    return view('sales.estimates', compact('estimates', 'estimatesJoin'));
}


    /** page create estimates */
    public function createEstimateIndex()
    {
        return view('sales.createestimate');
    }

    /** page edit estimates */
    public function editEstimateIndex($estimate_number)
    {
        $estimates          = DB::table('estimates') ->where('estimate_number',$estimate_number)->first();
        $estimatesJoin = DB::table('estimates')
            ->join('estimates_adds', 'estimates.estimate_number', '=', 'estimates_adds.estimate_number')
            ->select('estimates.*', 'estimates_adds.*')
            ->where('estimates_adds.estimate_number',$estimate_number)
            ->get();
        return view('sales.editestimate',compact('estimates','estimatesJoin'));
    }

    /** view page estimate */
    public function viewEstimateIndex($estimate_number)
    {
        $estimatesJoin = DB::table('estimates')
            ->join('estimates_adds', 'estimates.estimate_number', '=', 'estimates_adds.estimate_number')
            ->select('estimates.*', 'estimates_adds.*')
            ->where('estimates_adds.estimate_number',$estimate_number)
            ->get();
        return view('sales.estimateview',compact('estimatesJoin'));
    }

    /** save record create estimate */
    public function createEstimateSaveRecord(Request $request)
{
    $request->validate([
        'type_demande' => 'required|string|in:fourniture,achat',
    ]);

    DB::beginTransaction();
    try {

        $estimates = new Estimates;
        $estimates->type_demande = $request->type_demande;
        $estimates->estimate_date = $request->estimate_date;
        $estimates->expiry_date = $request->expiry_date;
        
        $estimates->user_id = Auth::id(); // Save with the user_id of the logged-in user

        $estimates->save();

        $estimate_number = DB::table('estimates')->orderBy('estimate_number', 'DESC')->select('estimate_number')->first();
        $estimate_number = $estimate_number->estimate_number;

        foreach ($request->item as $key => $items) {
            $estimatesAdd = [
                'item' => $items,
                'estimate_number' => $estimate_number,
                'description' => $request->description[$key],
                'qty' => $request->qty[$key],
                'motif'=> $request->motif[$key],

            ];

            EstimatesAdd::create($estimatesAdd);
        }
        if ($request->type_demande === 'achat') {
            $details = [];
            // Pieces to request
            if (isset($request->piece_joint)) {
                foreach ($request->piece_joint as $piece) {
                    $details[] = [
                        'estimate_id' => $estimates->id,
                        'detail_type' => 'Pieces to Request',
                        'detail_value' => $piece
                    ];
                }
            }

            // Elements required at reception
            if (isset($request->element_exiges_lors_de_la_reception)) {
                foreach ($request->element_exiges_lors_de_la_reception as $element) {
                    $details[] = [
                        'estimate_id' => $estimates->id,
                        'detail_type' => 'Elements Required at Reception',
                        'detail_value' => $element
                    ];
                }
            }

            // Participation in consultation/selection
            if ($request->has('participation_a_la_consultation_selection')) {
                $details[] = [
                    'estimate_id' => $estimates->id,
                    'detail_type' => 'Participation in Consultation/Selection',
                    'detail_value' => $request->participation_a_la_consultation_selection
                ];
            }

            // Budgetary status of purchase
            if (isset($request->achat_demande)) {
                foreach ($request->achat_demande as $status) {
                    $details[] = [
                        'estimate_id' => $estimates->id,
                        'detail_type' => 'Budgetary Status of Purchase',
                        'detail_value' => $status
                    ];
                }
            }

            // Save all details in one go
            EstimateDetail::insert($details);
        }
        DB::commit();
        Toastr::success('Ajout de la demande réussi', 'Success');
        return redirect()->route('form/estimates/page');
    } catch (\Exception $e) {
        DB::rollback();
        Toastr::error('ajout de la demande echoué', 'Error');
        return redirect()->back();
    }
}



public function index(Request $request)
{
    $userId = Auth::id(); // Get the ID of the currently logged-in user
    $query = Estimates::where('user_id', $userId); // Start the query with a filter for the logged-in user

    // Filter by type of demand
    if ($request->filled('type_demande')) {
        $query->where('type_demande', $request->type_demande);
    }

    // Filter by date range
    if ($request->filled('date_from')) {
        $query->whereDate('estimate_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('expiry_date', '<=', $request->date_to);
    }

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Retrieve the results with pagination
    $estimates = $query->paginate(10);

    return view('sales.estimates', compact('estimates'));
}








    public function sendEstimate(Request $request, $id)
    {
        // Retrieve the estimate as a model instance
        $estimate = Estimates::findOrFail($id);

        // Retrieve the user's validators
        $user = $estimate->user;
        $validators = $user->validators;

        // Send the estimate to each validator
        foreach ($validators as $validator) {
            Mail::to($validator->email)->send(new SendEstimate($estimate));
        }

        return back()->with('success', 'Estimate sent to validators.');
    }














































    /** update record estimate */
    public function updateEstimateRecord(Request $request)
{
    $request->validate([
        'type_demande' => 'required|string|in:fourniture,achat',
        'estimate_date' => 'required|date',
        'expiry_date' => 'required|date',
        'id' => 'required|integer|exists:estimates,id', // Make sure the estimate exists
    ]);

    DB::beginTransaction();
    try {
        $estimates = Estimates::findOrFail($request->id);
        $estimates->type_demande = $request->type_demande;
        $estimates->estimate_date = $request->estimate_date;
        $estimates->expiry_date = $request->expiry_date;
        
        $estimates->save();

        // Update related items
        foreach ($request->item as $key => $item) {
            $estimateAddId = $request->estimates_adds[$key];
            $estimatesAdd = EstimatesAdd::find($estimateAddId);
            if ($estimatesAdd) {
                $estimatesAdd->item = $item;
                $estimatesAdd->description = $request->description[$key];
                $estimatesAdd->qty = $request->qty[$key];
                $estimatesAdd->motif = $request->motif[$key];
                $estimatesAdd->save();
            }
        }

        // Handling additional options if 'achat' is selected
        if ($request->type_demande === 'achat') {
            $details = [];

            EstimateDetail::where('estimate_id', $estimates->id)->delete(); // Clear existing details

            $this->processDetails($details, $request, $estimates->id);

            // Save all new details
            EstimateDetail::insert($details);
        }

        DB::commit();
        Toastr::success('Mise à jour de la demande réussie', 'Success');
        return redirect()->route('form/estimates/page');
    } catch (\Exception $e) {
        DB::rollback();
        Toastr::error('Mise à jour de la demande échouée : ' . $e->getMessage(), 'Error');
        return redirect()->back();
    }
}































private function processDetails(&$details, $request, $estimateId)
{
    // Pieces to request
    if (isset($request->piece_joint)) {
        foreach ($request->piece_joint as $piece) {
            $details[] = [
                'estimate_id' => $estimateId,
                'detail_type' => 'Pieces to Request',
                'detail_value' => $piece
            ];
        }
    }

    // Elements required at reception
    if (isset($request->element_exiges_lors_de_la_reception)) {
        foreach ($request->element_exiges_lors_de_la_reception as $element) {
            $details[] = [
                'estimate_id' => $estimateId,
                'detail_type' => 'Elements Required at Reception',
                'detail_value' => $element
            ];
        }
    }

    // Participation in consultation/selection
    if ($request->has('participation_a_la_consultation_selection')) {
        $details[] = [
            'estimate_id' => $estimateId,
            'detail_type' => 'Participation in Consultation/Selection',
            'detail_value' => $request->participation_a_la_consultation_selection
        ];
    }

    // Budgetary status of purchase
    if (isset($request->achat_demande)) {
        foreach ($request->achat_demande as $status) {
            $details[] = [
                'estimate_id' => $estimateId,
                'detail_type' => 'Budgetary Status of Purchase',
                'detail_value' => $status
            ];
        }
    }
}


    /** delete record estimate add */
    public function EstimateAddDeleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {

            EstimatesAdd::destroy($request->id);

            DB::commit();
            Toastr::success('Estimates deleted successfully :)','Success');
            return redirect()->back();
            
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Estimates deleted fail :)','Error');
            return redirect()->back();
        }
    }
    
    /** delete record estimate */
    public function EstimateDeleteRecord(Request $request)
    {
        DB::beginTransaction();
        try {

            /** delete record table estimates_adds */
            $estimate_number = DB::table('estimates_adds')->where('estimate_number',$request->estimate_number)->get();
            foreach ($estimate_number as $key => $id_estimate_number) {
                DB::table('estimates_adds')->where('id', $id_estimate_number->id)->delete();
            }

            /** delete record table estimates */
            Estimates::destroy($request->id);

            DB::commit();
            Toastr::success('Estimates deleted successfully :)','Success');
            return redirect()->back();
            
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Estimates deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** view payments page */
    public function Payments()
    {
       return view('sales.payments');
    }

    /** expenses page index */
    public function Expenses()
    {
        /** get data show data on table page expenses */
        $data = DB::table('expenses')->get();
        return view('sales.expenses',compact('data'));
    }

    // save record
    public function saveRecord(Request $request)
    {
        $request->validate([
            'item_name'    => 'required|string|max:255',
            'purchase_from'=> 'required|string|max:255',
            'purchase_date'=> 'required|string|max:255',
            'purchased_by' => 'required|string|max:255',
            'amount'       => 'required|string|max:255',
            'paid_by'      => 'required|string|max:255',
            'status'       => 'required|string|max:255',
            'attachments'  => 'required',
        ]);

        DB::beginTransaction();
        try {

            $attachments = time().'.'.$request->attachments->extension();  
            $request->attachments->move(public_path('assets/images'), $attachments);

            $expense = new Expense;
            $expense->item_name  = $request->item_name;
            $expense->purchase_from = $request->purchase_from;
            $expense->purchase_date = $request->purchase_date;
            $expense->purchased_by  = $request->purchased_by;
            $expense->amount  = $request->amount;
            $expense->paid_by = $request->paid_by;
            $expense->status  = $request->status;
            $expense->attachments  = $attachments;
            $expense->save();
            
            DB::commit();
            Toastr::success('Create new Expense successfully :)','Success');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Add Expense fail :)','Error');
            return redirect()->back();
        }
    }

    // update
    public function updateRecord( Request $request)
    {
        DB::beginTransaction();
        try{
           
            $attachments = $request->hidden_attachments;
            $attachment  = $request->file('attachments');
            if($attachment != '')
            {
                unlink('assets/images/'.$attachments);
                $attachments = time().'.'.$attachment->getClientOriginalExtension();  
                $attachment->move(public_path('assets/images'), $attachments);
            } else {
                $attachments;
            }
            
            $update = [

                'id'           => $request->id,
                'item_name'    => $request->item_name,
                'purchase_from'=> $request->purchase_from,
                'purchase_date'=> $request->purchase_date,
                'purchased_by' => $request->purchased_by,
                'amount'       => $request->amount,
                'paid_by'      => $request->paid_by,
                'status'       => $request->status,
                'attachments'  => $attachments,
            ];

            Expense::where('id',$request->id)->update($update);
            DB::commit();
            Toastr::success('Expense updated successfully :)','Success');
            return redirect()->back();

        }catch(\Exception $e){
            DB::rollback();
            Toastr::error('Expense update fail :)','Error');
            return redirect()->back();
        }
    }

    // delete
    public function deleteRecord(Request $request)
    {
        DB::beginTransaction();
        try{

            Expense::destroy($request->id);
            unlink('assets/images/'.$request->attachments);
            DB::commit();
            Toastr::success('Expense deleted successfully :)','Success');
            return redirect()->back();
            
        } catch(\Exception $e) {
            DB::rollback();
            Toastr::error('Expense deleted fail :)','Error');
            return redirect()->back();
        }
    }

    /** search record */
    public function searchRecord(Request $request)
    {
        $data = DB::table('expenses')->get();

        // search by item name
        if(!empty($request->item_name) && empty($request->from_date) && empty($request->to_data))
        {
            $data = Expense::where('item_name','LIKE','%'.$request->item_name.'%')->get();
        }

        // search by from_date to_data
        if(empty($request->item_name) && !empty($request->from_date) && !empty($request->to_date))
        {
            $data = Expense::whereBetween('purchase_date',[$request->from_date, $request->to_date])->get();
        }
        
        // search by item name and from_date to_data
        if(!empty($request->item_name) && !empty($request->from_date) && !empty($request->to_date))
        {
            $data = Expense::where('item_name','LIKE','%'.$request->item_name.'%')
                            ->whereBetween('purchase_date',[$request->from_date, $request->to_date])
                            ->get();
        }

        return view('sales.expenses',compact('data'));
    }
}
