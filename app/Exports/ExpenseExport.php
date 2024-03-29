<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExpenseExport implements FromQuery,WithHeadings,WithMapping
{

    use Exportable;
    private $user;
    private $user_id;

    public function __construct($user,$user_id)
    {
        $this->user = $user;
        $this->user_id = $user_id;
    }


    public function map($expense): array
    {
        return [
            $expense->created_at->format('Y-m-d'),
            $expense->membership_id,
            $expense->expensetypes->expence_type,
            $expense->amount,
            $expense->notes,
        ];
    }

    public function query()
    {
        $user=$this->user;
        $user_id=$this->user_id;
        if($user_id->name=='user'){
            $user=$this->user;
            if(isset($user->membership_code)){
                return Expense::where('membership_id',$user->membership_code);
            }else{
                return Expense::where('membership_id',$user->member_by);
            }
        }else{
            return Expense::where('amount','>=',0);
        }
    }


    public function headings(): array
    {
        return ["Date","Membership Code", "Expense Type", "Amount", "Message"];
    }



}
