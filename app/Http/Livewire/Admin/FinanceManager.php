<?php

namespace App\Http\Livewire\Admin;

use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class FinanceManager extends Component
{
    use WithPagination;

    public ?string $dateFrom = null;
    public ?string $dateTo = null;
    public ?string $category = null;
    public ?int $editingIncomeId = null;
    public ?int $editingExpenseId = null;

    public $incomeDescription;
    public $incomeAmount;
    public $incomeCategory;
    public $incomePaymentMethod;
    public $incomeDate;

    public $expenseDescription;
    public $expenseAmount;
    public $expenseCategory;
    public $expensePaymentMethod;
    public $expenseDate;
    public $expenseReceipt;

    protected $queryString = ['dateFrom', 'dateTo', 'category'];

    protected function incomeRules(): array
    {
        return [
            'incomeDescription' => 'required|string|max:500',
            'incomeAmount' => 'required|numeric|min:0',
            'incomeCategory' => 'required|string|max:100',
            'incomePaymentMethod' => 'nullable|string|max:50',
            'incomeDate' => 'required|date',
        ];
    }

    protected function expenseRules(): array
    {
        return [
            'expenseDescription' => 'required|string|max:500',
            'expenseAmount' => 'required|numeric|min:0',
            'expenseCategory' => 'required|string|max:100',
            'expensePaymentMethod' => 'nullable|string|max:50',
            'expenseDate' => 'required|date',
        ];
    }

    public function getTotalIncomeProperty()
    {
        return $this->incomesQuery()->sum('amount');
    }

    public function getTotalExpenseProperty()
    {
        return $this->expensesQuery()->sum('amount');
    }

    public function getBalanceProperty()
    {
        return $this->totalIncome - $this->totalExpense;
    }

    private function incomesQuery()
    {
        $query = Income::query();

        if ($this->dateFrom) {
            $query->whereDate('recorded_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('recorded_at', '<=', $this->dateTo);
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        return $query;
    }

    private function expensesQuery()
    {
        $query = Expense::query();

        if ($this->dateFrom) {
            $query->whereDate('recorded_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('recorded_at', '<=', $this->dateTo);
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        return $query;
    }

    public function createIncome(): void
    {
        $this->resetIncomeFields();
        $this->editingIncomeId = null;
        $this->dispatch('show-income-modal');
    }

    public function storeIncome(): void
    {
        $this->validate($this->incomeRules());

        Income::create([
            'description' => $this->incomeDescription,
            'amount' => $this->incomeAmount,
            'category' => $this->incomeCategory,
            'payment_method' => $this->incomePaymentMethod,
            'recorded_by' => auth()->id(),
            'recorded_at' => Carbon::parse($this->incomeDate),
        ]);

        session()->flash('message', 'Ingreso registrado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetIncomeFields();
    }

    public function editIncome(int $id): void
    {
        $income = Income::findOrFail($id);
        $this->editingIncomeId = $id;
        $this->incomeDescription = $income->description;
        $this->incomeAmount = $income->amount;
        $this->incomeCategory = $income->category;
        $this->incomePaymentMethod = $income->payment_method;
        $this->incomeDate = $income->recorded_at->format('Y-m-d\TH:i');

        $this->dispatch('show-income-modal');
    }

    public function updateIncome(): void
    {
        $this->validate($this->incomeRules());

        $income = Income::findOrFail($this->editingIncomeId);
        $income->update([
            'description' => $this->incomeDescription,
            'amount' => $this->incomeAmount,
            'category' => $this->incomeCategory,
            'payment_method' => $this->incomePaymentMethod,
            'recorded_at' => Carbon::parse($this->incomeDate),
        ]);

        session()->flash('message', 'Ingreso actualizado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetIncomeFields();
    }

    public function deleteIncome(int $id): void
    {
        Income::findOrFail($id)->delete();
        session()->flash('message', 'Ingreso eliminado.');
    }

    public function createExpense(): void
    {
        $this->resetExpenseFields();
        $this->editingExpenseId = null;
        $this->dispatch('show-expense-modal');
    }

    public function storeExpense(): void
    {
        $this->validate($this->expenseRules());

        Expense::create([
            'description' => $this->expenseDescription,
            'amount' => $this->expenseAmount,
            'category' => $this->expenseCategory,
            'payment_method' => $this->expensePaymentMethod,
            'recorded_by' => auth()->id(),
            'recorded_at' => Carbon::parse($this->expenseDate),
        ]);

        session()->flash('message', 'Gasto registrado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetExpenseFields();
    }

    public function editExpense(int $id): void
    {
        $expense = Expense::findOrFail($id);
        $this->editingExpenseId = $id;
        $this->expenseDescription = $expense->description;
        $this->expenseAmount = $expense->amount;
        $this->expenseCategory = $expense->category;
        $this->expensePaymentMethod = $expense->payment_method;
        $this->expenseDate = $expense->recorded_at->format('Y-m-d\TH:i');

        $this->dispatch('show-expense-modal');
    }

    public function updateExpense(): void
    {
        $this->validate($this->expenseRules());

        $expense = Expense::findOrFail($this->editingExpenseId);
        $expense->update([
            'description' => $this->expenseDescription,
            'amount' => $this->expenseAmount,
            'category' => $this->expenseCategory,
            'payment_method' => $this->expensePaymentMethod,
            'recorded_at' => Carbon::parse($this->expenseDate),
        ]);

        session()->flash('message', 'Gasto actualizado exitosamente.');
        $this->dispatch('close-modal');
        $this->resetExpenseFields();
    }

    public function deleteExpense(int $id): void
    {
        Expense::findOrFail($id)->delete();
        session()->flash('message', 'Gasto eliminado.');
    }

    private function resetIncomeFields(): void
    {
        $this->incomeDescription = null;
        $this->incomeAmount = null;
        $this->incomeCategory = null;
        $this->incomePaymentMethod = null;
        $this->incomeDate = now()->format('Y-m-d\TH:i');
    }

    private function resetExpenseFields(): void
    {
        $this->expenseDescription = null;
        $this->expenseAmount = null;
        $this->expenseCategory = null;
        $this->expensePaymentMethod = null;
        $this->expenseDate = now()->format('Y-m-d\TH:i');
        $this->expenseReceipt = null;
    }

    public function render()
    {
        $incomes = $this->incomesQuery()->with('recordedBy')
            ->orderBy('recorded_at', 'desc')
            ->paginate(15, ['*'], 'incomesPage');

        $expenses = $this->expensesQuery()->with('recordedBy')
            ->orderBy('recorded_at', 'desc')
            ->paginate(15, ['*'], 'expensesPage');

        return view('livewire.admin.finance-manager', [
            'incomes' => $incomes,
            'expenses' => $expenses,
        ]);
    }
}
